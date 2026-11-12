<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\MengelolaBerkasUmkm;
use App\Http\Requests\UmkmRequest;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/** Form UMKM Directory di dashboard: pelaku usaha (data sendiri) dan admin (semua data). */
class UmkmController extends Controller
{
    use MengelolaBerkasUmkm;

    private function authorizeUmkm(Request $request, Umkm $umkm): void
    {
        abort_unless($request->user()->isAdmin() || $umkm->user_id === $request->user()->id, 403);
    }

    public function index(Request $request)
    {
        $umkms = $request->user()->umkms()->with('files')->latest()->get();

        return view('umkm.index', compact('umkms'));
    }

    public function create()
    {
        return view('umkm.form', ['umkm' => new Umkm(['tampilkan_kontak' => false])]);
    }

    public function store(UmkmRequest $request)
    {
        $user = $request->user();
        $data = $request->dataUmkm();
        $data['user_id'] = $user->id;
        $data['submitted_at'] = now();
        if (! $user->isAdmin()) {
            $data['status'] = 'pending';
        }
        $data['legalitas'] = $this->legalitasLengkap($request, $data['legalitas']);

        $umkm = DB::transaction(function () use ($data, $request) {
            $umkm = Umkm::create($data);
            $this->simpanBerkas($umkm, $request);

            return $umkm;
        });

        return redirect()->route($user->isAdmin() ? 'admin.umkm.index' : 'umkm.index')
            ->with('ok', "Data \"{$umkm->nama_brand}\" tersimpan dan menunggu kurasi admin.");
    }

    public function edit(Request $request, Umkm $umkm)
    {
        $this->authorizeUmkm($request, $umkm);
        $umkm->load('files');

        return view('umkm.form', compact('umkm'));
    }

    public function update(UmkmRequest $request, Umkm $umkm)
    {
        $this->authorizeUmkm($request, $umkm);
        $admin = $request->user()->isAdmin();

        $data = $request->dataUmkm();
        $data['legalitas'] = $this->legalitasLengkap($request, $data['legalitas']);
        if (! $admin) {
            $data['status'] = 'pending'; // perubahan dari pelaku usaha dikurasi ulang
            $data['catatan_admin'] = $umkm->catatan_admin;
        }

        // batas 5 foto produk setelah penghapusan + unggahan baru
        $hapus = array_map('intval', $request->input('hapus_file', []));
        $sisa = $umkm->files()->where('jenis', 'produk')->whereNotIn('id', $hapus)->count();
        $baru = count($request->file('foto_produk', []));
        if ($sisa + $baru > 5) {
            throw ValidationException::withMessages(['foto_produk' => 'Total foto produk maksimal 5.']);
        }

        DB::transaction(function () use ($umkm, $data, $request) {
            $umkm->update($data);
            $this->simpanBerkas($umkm, $request);
        });

        $pesan = 'Perubahan tersimpan.';
        if (! $admin) {
            $pesan .= ' Data akan ditinjau ulang oleh admin sebelum tampil di website.';
        }

        return redirect()->route($admin ? 'admin.umkm.index' : 'umkm.index')->with('ok', $pesan);
    }

    public function destroy(Request $request, Umkm $umkm)
    {
        $this->authorizeUmkm($request, $umkm);
        $umkm->load('files')->delete();

        return redirect()->route($request->user()->isAdmin() ? 'admin.umkm.index' : 'umkm.index')
            ->with('ok', 'Data UMKM dihapus.');
    }
}
