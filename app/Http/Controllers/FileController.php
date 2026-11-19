<?php

namespace App\Http\Controllers;

use App\Models\UmkmFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/** Menyajikan berkas privat (KTP, NIB, legalitas) hanya untuk pemilik & admin. */
class FileController extends Controller
{
    public function show(Request $request, UmkmFile $file)
    {
        $user = $request->user();

        // Foto produk bersifat publik; berkas privat (KTP, NIB, legalitas) hanya untuk admin & pemilik
        if ($file->jenis !== 'produk') {
            abort_unless($user && ($user->isAdmin() || ($file->umkm && $file->umkm->user_id === $user->id)), 403);
        }

        if (! $file->path) {
            return $file->url ? redirect()->away($file->url) : abort(404);
        }
        abort_unless(Storage::disk($file->disk())->exists($file->path), 404);

        return Storage::disk($file->disk())->response($file->path, $file->nama_asli);
    }
}
