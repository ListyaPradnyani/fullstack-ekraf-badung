<?php

namespace App\Http\Controllers\Concerns;

use App\Http\Requests\UmkmRequest;
use App\Models\Umkm;
use App\Models\UmkmFile;

/** Logika berkas bersama untuk form di dashboard dan form di landing page. */
trait MengelolaBerkasUmkm
{
    /** Jenis legalitas yang diunggah filenya otomatis dianggap "dimiliki". */
    protected function legalitasLengkap(UmkmRequest $request, array $dipilih): array
    {
        $diunggah = array_keys($request->file('foto_legalitas', []));
        $valid = array_intersect(array_merge($dipilih, $diunggah), config('ekraf.legalitas'));

        return array_values(array_unique($valid));
    }

    protected function simpanBerkas(Umkm $umkm, UmkmRequest $request): void
    {
        if ($ids = $request->input('hapus_file')) {
            $umkm->files()->whereIn('id', $ids)->get()->each->delete();
        }

        // KTP & NIB: satu berkas, unggahan baru menggantikan yang lama
        foreach (['ktp' => 'foto_ktp', 'nib' => 'foto_nib'] as $jenis => $field) {
            if ($request->hasFile($field)) {
                $umkm->files()->where('jenis', $jenis)->get()->each->delete();
                UmkmFile::simpan($umkm, $request->file($field), $jenis);
            }
        }

        foreach ($request->file('foto_produk', []) as $f) {
            UmkmFile::simpan($umkm, $f, 'produk');
        }

        foreach ($request->file('foto_legalitas', []) as $label => $f) {
            if (in_array($label, config('ekraf.legalitas'), true)) {
                UmkmFile::simpan($umkm, $f, 'legalitas', $label);
            }
        }
    }
}
