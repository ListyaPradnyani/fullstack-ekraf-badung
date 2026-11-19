<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stat = [
            'total' => Umkm::count(),
            'pending' => Umkm::where('status', 'pending')->count(),
            'approved' => Umkm::where('status', 'approved')->count(),
            'rejected' => Umkm::where('status', 'rejected')->count(),
            'users' => User::where('role', 'user')->count(),
        ];
        $perKecamatan = Umkm::selectRaw('kecamatan, count(*) as total')->groupBy('kecamatan')
            ->pluck('total', 'kecamatan');
        $terbaru = Umkm::where('status', 'pending')->latest('submitted_at')->limit(6)->get();

        return view('admin.dashboard', compact('stat', 'perKecamatan', 'terbaru'));
    }

    private function filtered(Request $request): Builder
    {
        return Umkm::query()->with('user')
            ->when($request->q, function ($q, $s) {
                $q->where(fn ($w) => $w->where('nama_brand', 'like', "%{$s}%")
                    ->orWhere('nama_pelaku', 'like', "%{$s}%")
                    ->orWhere('no_wa', 'like', "%{$s}%"));
            })
            ->when($request->kecamatan, fn ($q, $v) => $q->where('kecamatan', $v))
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->latest('submitted_at')->latest('id');
    }

    public function umkm(Request $request)
    {
        $umkms = $this->filtered($request)->paginate(20)->withQueryString();

        return view('admin.umkm', compact('umkms'));
    }

    public function bulk(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
            'aksi' => ['required', Rule::in(['approved', 'rejected', 'pending', 'hapus'])],
        ], [
            'ids.required' => 'Pilih minimal satu UMKM.',
            'aksi.required' => 'Pilih aksi.',
        ]);

        $items = Umkm::with('files')->whereIn('id', $data['ids'])->get();
        if ($data['aksi'] === 'hapus') {
            $items->each->delete();
            $pesan = $items->count().' UMKM dihapus.';
        } else {
            Umkm::whereIn('id', $items->pluck('id'))->update(['status' => $data['aksi']]);
            $pesan = $items->count().' UMKM diubah menjadi "'.Umkm::STATUSES[$data['aksi']].'".';
        }

        return back()->with('ok', $pesan);
    }

    public function export(Request $request)
    {
        // Ambil struktur dan urutan kolom resmi langsung dari tabel 'umkms' di database
        $kolom = Schema::getColumnListing('umkms');

        return response()->streamDownload(function () use ($request, $kolom) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // BOM agar UTF-8 terbaca dengan benar di Excel

            // Header baris pertama otomatis persis sesuai nama kolom database
            fputcsv($out, $kolom);

            $this->filtered($request)->chunk(200, function ($rows) use ($out, $kolom) {
                foreach ($rows as $u) {
                    $baris = [];
                    foreach ($kolom as $k) {
                        $val = $u->{$k};

                        if (is_array($val)) {
                            // Format JSON agar struktur data legalitas & kesiapan tetap valid dan mudah diimpor kembali
                            $baris[] = json_encode($val, JSON_UNESCAPED_UNICODE);
                        } elseif (is_bool($val)) {
                            // Format boolean konsisten 1 atau 0 sesuai tipe tinyint database
                            $baris[] = $val ? 1 : 0;
                        } elseif ($val instanceof \DateTimeInterface) {
                            $baris[] = $val->format('Y-m-d H:i:s');
                        } else {
                            $baris[] = $val ?? '';
                        }
                    }
                    fputcsv($out, $baris);
                }
            });
            fclose($out);
        }, 'umkm-ekraf-badung-'.now()->format('Ymd-His').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function users()
    {
        $users = User::withCount('umkms')->orderBy('role')->orderBy('name')->get();

        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate(['role' => ['required', Rule::in(['user', 'admin'])]]);

        if ($user->id === $request->user()->id) {
            return back()->withErrors(['role' => 'Kamu tidak bisa mengubah role akunmu sendiri.']);
        }
        $user->update($data);

        return back()->with('ok', "Role {$user->name} diubah menjadi {$data['role']}.");
    }
}
