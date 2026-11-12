<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Umkm extends Model
{
    public const STATUSES = [
        'pending' => 'Menunggu kurasi',
        'approved' => 'Disetujui',
        'rejected' => 'Ditolak',
    ];

    protected $fillable = [
        'user_id', 'nama_pelaku', 'nama_brand', 'kecamatan', 'no_wa', 'alamat',
        'media_sosial', 'cerita_usaha', 'legalitas', 'produk', 'kesiapan', 'kategori',
        'jam_buka', 'setuju_data', 'tampilkan_kontak', 'status', 'catatan_admin', 'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'legalitas' => 'array',
            'kesiapan' => 'array',
            'setuju_data' => 'boolean',
            'tampilkan_kontak' => 'boolean',
            'submitted_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (Umkm $u) {
            $u->files->each->delete();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(UmkmFile::class);
    }

    public function scopeApproved(Builder $q): Builder
    {
        return $q->where('status', 'approved');
    }

    public function filesOf(string $jenis, ?string $label = null)
    {
        return $this->files->where('jenis', $jenis)
            ->when($label, fn ($c) => $c->where('label', $label))->values();
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    /** Daftar produk untuk chip di popup (dipisah baris baru / koma). */
    public function produkList(): array
    {
        $items = preg_split('/[\r\n,;]+/', (string) $this->produk) ?: [];

        return array_slice(array_values(array_filter(array_map('trim', $items), fn ($s) => $s !== '' && mb_strlen($s) <= 60)), 0, 6);
    }

    /** Nomor WA format internasional tanpa +. */
    public function waInternasional(): string
    {
        $d = preg_replace('/\D+/', '', (string) $this->no_wa);
        if ($d === '') {
            return '';
        }
        if (str_starts_with($d, '0')) {
            return '62'.substr($d, 1);
        }
        if (str_starts_with($d, '8')) {
            return '62'.$d;
        }

        return $d;
    }

    /** Tebak username Instagram dari isian media sosial (null bila tidak yakin). */
    public function instagramUsername(): ?string
    {
        $t = (string) $this->media_sosial;
        if (preg_match('~instagram\.com/([A-Za-z0-9._]+)~i', $t, $m)) {
            return $m[1];
        }
        if (preg_match('~\b(?:ig|instagram)\s*(?:[:.]\s*@?|\s@)([A-Za-z0-9._]{3,})~i', $t, $m)) {
            return $m[1];
        }
        if (! preg_match('~tiktok|tik tok|facebook|\bfb\b|shopee|tokopedia~i', $t) && preg_match('~@([A-Za-z0-9._]{3,})~', $t, $m)) {
            return $m[1];
        }

        return null;
    }

    /** Bentuk data yang dibaca js/main.js di landing page. */
    public function toLanding(): array
    {
        $img = $this->filesOf('produk')->map->imageUrl()->filter()->first();

        return [
            'name' => $this->nama_brand,
            'cat' => $this->kategori ?: 'Lainnya',
            'loc' => $this->kecamatan ?: '',
            'img' => $img ?: '',
            'desc' => $this->cerita_usaha ?: $this->produk,
            'products' => $this->produkList(),
            'addr' => $this->alamat,
            'hours' => $this->jam_buka,
            'wa' => $this->tampilkan_kontak ? $this->waInternasional() : '',
            'ig' => $this->instagramUsername() ?: '',
        ];
    }
}
