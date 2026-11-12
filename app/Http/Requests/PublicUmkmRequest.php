<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;

/** Form pendaftaran UMKM di landing page. Tamu sekaligus membuat akun (email + password). */
class PublicUmkmRequest extends UmkmRequest
{
    /** Bila validasi gagal, kembali ke form di landing page. */
    protected $redirect = '/#daftar-umkm';

    public function authorize(): bool
    {
        return true; // tamu boleh mengirim; akun dibuat otomatis
    }

    protected function actorIsAdmin(): bool
    {
        return false; // dari landing page selalu masuk antrean kurasi
    }

    public function rules(): array
    {
        $rules = parent::rules();
        if (! $this->user()) {
            $rules['email'] = ['required', 'email', 'max:150', 'unique:users,email'];
            $rules['password'] = ['required', 'confirmed', Password::min(8)];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return parent::attributes() + ['email' => 'email', 'password' => 'password'];
    }

    public function messages(): array
    {
        return parent::messages() + [
            'email.unique' => 'Email ini sudah terdaftar. Silakan masuk lewat tombol Masuk, lalu daftarkan UMKM dari akunmu.',
            'email.email' => 'Format email tidak valid.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'password.min' => 'Password minimal 8 karakter.',
        ];
    }
}
