<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UmkmFile extends Model
{
    protected $fillable = ['umkm_id', 'jenis', 'label', 'path', 'url', 'nama_asli'];

    protected static function booted(): void
    {
        // hapus file fisik ikut terhapus bersama barisnya
        static::deleting(function (UmkmFile $f) {
            if ($f->path) {
                Storage::disk($f->disk())->delete($f->path);
            }
        });
    }

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }

    /** Foto produk -> disk public (tampil di landing). KTP/NIB/legalitas -> disk privat. */
    public function disk(): string
    {
        return $this->jenis === 'produk' ? 'public' : 'local';
    }

    public static function simpan(Umkm $umkm, UploadedFile $file, string $jenis, ?string $label = null): self
    {
        $disk = $jenis === 'produk' ? 'public' : 'local';
        $path = $file->store("umkm/{$umkm->id}/{$jenis}", $disk);

        return $umkm->files()->create([
            'jenis' => $jenis,
            'label' => $label,
            'path' => $path,
            'nama_asli' => $file->getClientOriginalName(),
        ]);
    }

    public function isImage(): bool
    {
        $ref = $this->path ?: ($this->url ?? '');

        return (bool) preg_match('/\.(jpe?g|png|webp|gif)(\?.*)?$/i', $ref);
    }

    /**
     * URL gambar yang bisa langsung dipakai <img>, atau null.
     * Pakai asset() (relatif ke host yang sedang dibuka), bukan Storage::url() yang mengikuti APP_URL,
     * supaya foto tetap tampil di 127.0.0.1:8000, localhost, maupun domain produksi.
     */
    public function imageUrl(): ?string
    {
        if ($this->path) {
            if ($this->jenis === 'produk') {
                return asset('storage/'.$this->path);
            }

            return $this->isImage() ? route('files.show', $this) : null;
        }
        if ($this->url && str_starts_with($this->url, 'assets/')) {
            return asset($this->url);
        }
        if ($this->url && $this->isImage()) {
            return $this->url;
        }
        // Foto produk dari Google Drive (hasil Excel): coba tampilkan thumbnail jika file dibagikan publik
        if ($this->jenis === 'produk' && $this->url
            && preg_match('~(?:[?&]id=|/d/)([A-Za-z0-9_-]{20,})~', $this->url, $m)) {
            return 'https://drive.google.com/thumbnail?id='.$m[1].'&sz=w900';
        }

        return null;
    }

    /** Tautan untuk membuka berkas (storage / Drive). */
    public function openUrl(): ?string
    {
        if ($this->path) {
            return $this->jenis === 'produk'
                ? asset('storage/'.$this->path)
                : route('files.show', $this);
        }

        return $this->url && str_starts_with($this->url, 'assets/') ? asset($this->url) : $this->url;
    }
}
