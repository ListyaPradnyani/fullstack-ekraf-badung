<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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
        $kolom = ['nama_brand', 'nama_pelaku', 'kategori', 'kecamatan', 'no_wa', 'alamat', 'media_sosial', 'produk', 'cerita_usaha', 'status', 'submitted_at'];

        return response()->streamDownload(function () use ($request, $kolom) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // BOM agar terbaca benar di Excel
            fputcsv($out, array_merge($kolom, ['legalitas', 'kesiapan']));
            $this->filtered($request)->chunk(200, function ($rows) use ($out, $kolom) {
                foreach ($rows as $u) {
                    $baris = array_map(fn ($k) => $u->{$k}, $kolom);
                    fputcsv($out, array_merge($baris, [implode('; ', $u->legalitas ?? []), implode('; ', $u->kesiapan ?? [])]));
                }
            });
            fclose($out);
        }, 'umkm-ekraf-badung-'.now()->format('Ymd').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
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
