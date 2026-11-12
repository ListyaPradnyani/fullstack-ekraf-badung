<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\MengelolaBerkasUmkm;
use App\Http\Requests\PublicUmkmRequest;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/** Menerima form UMKM dari landing page; tamu otomatis dibuatkan akun lalu langsung masuk. */
class PublicUmkmController extends Controller
{
    use MengelolaBerkasUmkm;

    public function store(PublicUmkmRequest $request)
    {
        $user = $request->user();
        $baruLogin = $user === null;

        $data = $request->dataUmkm();
        $data['legalitas'] = $this->legalitasLengkap($request, $data['legalitas']);
        $data['status'] = 'pending';
        $data['submitted_at'] = now();

        $umkm = DB::transaction(function () use ($request, $data, &$user) {
            $user ??= User::create([
                'name' => $request->input('nama_pelaku'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'role' => 'user',
            ]);
            $umkm = Umkm::create($data + ['user_id' => $user->id]);
            $this->simpanBerkas($umkm, $request);

            return $umkm;
        });

        if ($baruLogin) {
            Auth::login($user);
            $request->session()->regenerate();
        }

        return redirect()->route($user->isAdmin() ? 'admin.umkm.index' : 'umkm.index')
            ->with('ok', "Terima kasih! Data \"{$umkm->nama_brand}\" terkirim dan menunggu kurasi admin. ".
                ($baruLogin ? 'Akunmu sudah dibuat dan kamu sudah masuk.' : ''));
    }
}
