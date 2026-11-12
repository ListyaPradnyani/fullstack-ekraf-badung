<?php

namespace Database\Seeders;

use App\Models\Umkm;
use App\Models\User;
use App\Support\UmkmCsvImporter;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun admin (ubah lewat ADMIN_EMAIL / ADMIN_PASSWORD di .env sebelum seeding)
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@ekrafbadung.test')],
            ['name' => 'Admin Ekraf Badung', 'password' => env('ADMIN_PASSWORD', 'ganti-password-ini'), 'role' => 'admin'],
        );
        User::updateOrCreate(
            ['email' => 'user@ekrafbadung.test'],
            ['name' => 'Pelaku Usaha Contoh', 'password' => 'password123', 'role' => 'user'],
        );

        $this->seedContoh();
        $this->call(AgendaSeeder::class);

        // Data Excel kurasi -> status "menunggu kurasi" sampai disetujui admin
        $csv = database_path('seeders/data/kurasi_fesyen_kriya.csv');
        if (is_file($csv)) {
            $h = UmkmCsvImporter::import($csv);
            $this->command?->info("Impor Excel: {$h['baru']} data baru.");
        }
    }

    /** 6 UMKM contoh dari website HTML, supaya landing page tidak kosong. Hapus lewat panel admin bila tak perlu. */
    private function seedContoh(): void
    {
        if (Umkm::where('nama_brand', 'Kopi Pelangi Badung')->exists()) {
            return;
        }
        $contoh = [
            ['Kopi Pelangi Badung', 'Kuliner', 'Mengwi', 'kopi', 'Kedai kopi lokal yang menyangrai biji kopi Kintamani dan Pupuan secara kecil-kecilan. Cocok buat nongkrong, kerja, atau oleh-oleh biji kopi.', "Kopi susu gula aren\nBiji kopi Kintamani\nCold brew botol", 'Jl. Raya Mengwi No. 12, Mengwi, Badung', 'Setiap hari, 08.00 – 21.00 WITA', '6281234560001', 'kopipelangi.badung'],
            ['Tenun Sari Dewi', 'Fesyen', 'Abiansemal', 'tenun', 'Pengrajin kain tenun endek dengan motif tradisional dan modern. Dikerjakan manual oleh penenun lokal Abiansemal.', "Kain endek\nSelendang\nOuter & kemeja endek", 'Jl. Mekar Sari No. 7, Abiansemal, Badung', 'Senin – Sabtu, 09.00 – 17.00 WITA', '6281234560002', 'tenunsaridewi'],
            ['Ukir Kayu Wirasana', 'Kriya', 'Petang', 'ukir', 'Sanggar ukir kayu turun-temurun. Menerima pesanan panel, topeng, dan dekorasi rumah dengan detail khas Bali.', "Panel ukir\nTopeng kayu\nDekorasi dinding", 'Banjar Petang Kaja, Petang, Badung', 'Senin – Sabtu, 08.00 – 16.00 WITA', '6281234560003', 'ukirwirasana'],
            ['Lensa Badung Studio', 'Fotografi', 'Kuta', 'lensa', 'Studio foto dan video untuk produk UMKM, prewedding, dan dokumentasi event. Ada paket khusus pelaku usaha kreatif.', "Foto produk\nDokumentasi event\nVideo promosi", 'Jl. Raya Kuta No. 88, Kuta, Badung', 'Setiap hari, 09.00 – 20.00 WITA', '6281234560004', 'lensabadung.studio'],
            ['Jajan Bali Ayu', 'Kuliner', 'Kuta Utara', 'jajan', 'Aneka jajan pasar Bali yang dibuat segar setiap hari: lapis legit, laklak, dan klepon, tersedia juga paket hampers upacara.', "Laklak\nKlepon & dadar gulung\nPaket hampers", 'Jl. Gunung Sari No. 21, Kuta Utara, Badung', 'Setiap hari, 06.00 – 15.00 WITA', '6281234560005', 'jajanbaliayu'],
            ['Garuda Game Lab', 'Aplikasi & Game', 'Kuta Selatan', 'game', 'Studio game indie yang mengangkat cerita dan budaya Bali ke dalam game mobile. Terbuka untuk kolaborasi dan magang.', "Game mobile\nAplikasi edukasi\nJasa pembuatan app", 'Jl. Uluwatu No. 5, Kuta Selatan, Badung', 'Senin – Jumat, 09.00 – 17.00 WITA', '6281234560006', 'garudagamelab'],
        ];
        foreach ($contoh as [$brand, $kat, $kec, $img, $cerita, $produk, $alamat, $jam, $wa, $ig]) {
            $u = Umkm::create([
                'nama_brand' => $brand, 'nama_pelaku' => $brand, 'kategori' => $kat, 'kecamatan' => $kec,
                'cerita_usaha' => $cerita, 'produk' => $produk, 'alamat' => $alamat, 'jam_buka' => $jam,
                'no_wa' => $wa, 'media_sosial' => 'Instagram: '.$ig, 'tampilkan_kontak' => true,
                'setuju_data' => true, 'status' => 'approved', 'submitted_at' => now(),
            ]);
            $u->files()->create(['jenis' => 'produk', 'url' => "assets/images/umkm/{$img}.jpg"]);
        }
    }
}
