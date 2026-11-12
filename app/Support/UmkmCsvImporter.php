<?php

namespace App\Support;

use App\Models\Umkm;
use Illuminate\Support\Carbon;

/**
 * Impor data kurasi (hasil ekspor Google Form / Excel -> CSV) ke tabel umkms.
 * Kolom CSV: timestamp,nama_brand,nama_pelaku,no_wa,kecamatan,alamat,media_sosial,produk,
 *            nib_url,foto_produk_urls,hki,ktp_url,kesiapan,setuju
 * Kolom ganda (foto produk, kesiapan) dipisah dengan "||".
 * Data yang sudah ada (nama brand + no. WA sama) diperbarui, bukan diduplikasi.
 */
class UmkmCsvImporter
{
    /** @return array{baru:int, diperbarui:int} */
    public static function import(string $path, string $status = 'pending'): array
    {
        $fh = fopen($path, 'r');
        if (! $fh) {
            throw new \RuntimeException("File tidak bisa dibuka: {$path}");
        }
        $header = array_map(fn ($h) => trim($h, "\xEF\xBB\xBF \t"), fgetcsv($fh) ?: []);
        $hasil = ['baru' => 0, 'diperbarui' => 0];
        $kecamatan = array_combine(array_map('mb_strtolower', config('ekraf.kecamatan')), config('ekraf.kecamatan'));

        while (($row = fgetcsv($fh)) !== false) {
            if (count($row) < count($header)) {
                continue;
            }
            $r = array_combine($header, array_slice($row, 0, count($header)));
            if (trim($r['nama_brand'] ?? '') === '') {
                continue;
            }

            $wa = trim($r['no_wa'] ?? '');
            $kec = trim($r['kecamatan'] ?? '');
            $attrs = [
                'nama_pelaku' => trim($r['nama_pelaku'] ?? ''),
                'kecamatan' => $kecamatan[mb_strtolower($kec)] ?? ($kec ?: null),
                'alamat' => trim($r['alamat'] ?? '') ?: null,
                'media_sosial' => trim($r['media_sosial'] ?? '') ?: null,
                'produk' => trim($r['produk'] ?? '') ?: null,
                'legalitas' => strcasecmp(trim($r['hki'] ?? ''), 'Ada') === 0 ? ['HKI'] : [],
                'kesiapan' => self::pecah($r['kesiapan'] ?? ''),
                'setuju_data' => ($r['setuju'] ?? '1') === '1',
                'submitted_at' => ! empty($r['timestamp']) ? Carbon::parse($r['timestamp']) : now(),
            ];

            $umkm = Umkm::firstWhere(['nama_brand' => trim($r['nama_brand']), 'no_wa' => $wa]);
            if ($umkm) {
                $umkm->update($attrs);
                $umkm->files()->whereNull('path')->delete(); // tautan lama diganti yang baru
                $hasil['diperbarui']++;
            } else {
                $umkm = Umkm::create($attrs + [
                    'nama_brand' => trim($r['nama_brand']), 'no_wa' => $wa, 'status' => $status,
                ]);
                $hasil['baru']++;
            }

            // Berkas dari Google Drive disimpan sebagai tautan (kolom url)
            if (! empty($r['ktp_url'])) {
                $umkm->files()->create(['jenis' => 'ktp', 'url' => trim($r['ktp_url'])]);
            }
            if (! empty($r['nib_url'])) {
                $umkm->files()->create(['jenis' => 'nib', 'url' => trim($r['nib_url'])]);
            }
            foreach (self::pecah($r['foto_produk_urls'] ?? '') as $u) {
                $umkm->files()->create(['jenis' => 'produk', 'url' => $u]);
            }
        }
        fclose($fh);

        return $hasil;
    }

    private static function pecah(string $v): array
    {
        return array_values(array_filter(array_map('trim', explode('||', $v)), fn ($s) => $s !== ''));
    }
}
