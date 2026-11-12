<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UmkmRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /** Apakah pengirim form berperan sebagai admin (PublicUmkmRequest menimpa: selalu false). */
    protected function actorIsAdmin(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['tampilkan_kontak' => $this->boolean('tampilkan_kontak')]);
    }

    public function rules(): array
    {
        $admin = $this->actorIsAdmin();
        $wajibFile = $this->isMethod('post') && ! $admin ? 'required' : 'nullable';
        $kategori = array_column(config('ekraf.subsektor'), 'name');

        $rules = [
            'nama_pelaku' => ['required', 'string', 'max:150'],
            'nama_brand' => ['required', 'string', 'max:150'],
            'kategori' => ['nullable', Rule::in($kategori)],
            'kecamatan' => ['required', Rule::in(config('ekraf.kecamatan'))],
            'no_wa' => ['required', 'regex:/^[0-9+\-\s]{9,20}$/'],
            'alamat' => ['required', 'string', 'max:500'],
            'media_sosial' => ['nullable', 'string', 'max:500'],
            'produk' => ['required', 'string', 'max:3000'],
            'cerita_usaha' => ['nullable', 'string', 'max:5000'],
            'jam_buka' => ['nullable', 'string', 'max:100'],
            'legalitas' => ['nullable', 'array'],
            'legalitas.*' => [Rule::in(config('ekraf.legalitas'))],
            'kesiapan' => ['nullable', 'array'],
            'kesiapan.*' => [Rule::in(config('ekraf.kesiapan'))],
            'tampilkan_kontak' => ['boolean'],
            'setuju_data' => ['accepted'],
            'foto_ktp' => [$wajibFile, 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'foto_nib' => [$wajibFile, 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'foto_produk' => [$wajibFile, 'array', 'max:5'],
            'foto_produk.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'foto_legalitas' => ['nullable', 'array'],
            'foto_legalitas.*' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'hapus_file' => ['nullable', 'array'],
            'hapus_file.*' => ['integer'],
        ];

        if ($admin) {
            $rules['status'] = ['required', Rule::in(['pending', 'approved', 'rejected'])];
            $rules['catatan_admin'] = ['nullable', 'string', 'max:1000'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'nama_pelaku' => 'nama pelaku usaha',
            'nama_brand' => 'nama brand',
            'no_wa' => 'no. WA',
            'alamat' => 'alamat usaha',
            'media_sosial' => 'media sosial',
            'produk' => 'produk yang diajukan',
            'cerita_usaha' => 'cerita usaha',
            'setuju_data' => 'persetujuan data',
            'foto_ktp' => 'foto KTP',
            'foto_nib' => 'foto NIB',
            'foto_produk' => 'foto produk',
            'foto_produk.*' => 'foto produk',
            'foto_legalitas.*' => 'foto legalitas',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'accepted' => 'Kamu harus menyetujui pengolahan data.',
            'max.string' => ':attribute terlalu panjang (maks :max karakter).',
            'max.file' => 'Ukuran :attribute maksimal :max KB.',
            'max.array' => 'Maksimal :max berkas untuk :attribute.',
            'mimes' => ':attribute harus berformat :values.',
            'image' => ':attribute harus berupa gambar.',
            'regex' => 'Format :attribute tidak valid.',
            'in' => ':attribute tidak valid.',
            'uploaded' => ':attribute gagal diunggah (cek batas upload_max_filesize di php.ini).',
        ];
    }

    /** Kolom tabel umkms yang boleh diisi dari form. */
    public function dataUmkm(): array
    {
        $d = $this->validated();
        $d = array_intersect_key($d, array_flip([
            'nama_pelaku', 'nama_brand', 'kategori', 'kecamatan', 'no_wa', 'alamat', 'media_sosial',
            'produk', 'cerita_usaha', 'jam_buka', 'legalitas', 'kesiapan', 'tampilkan_kontak',
            'status', 'catatan_admin',
        ]));
        $d['legalitas'] = array_values($d['legalitas'] ?? []);
        $d['kesiapan'] = array_values($d['kesiapan'] ?? []);
        $d['setuju_data'] = true;

        return $d;
    }
}
