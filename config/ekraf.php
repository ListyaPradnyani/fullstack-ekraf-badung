<?php

/**
 * ====================================================================================
 * KONFIGURASI KONTEN STATIS & DATA MASTER PORTAL EKRAF BADUNG
 * ====================================================================================
 * 
 * File ini mengatur data statis untuk landing page serta opsi pada form UMKM.
 * Seluruh path gambar di bawah bersifat relatif terhadap folder: public/
 * 
 * PANDUAN PENGUBAHAN GAMBAR & DATA:
 * - Subsektor: Menggunakan ikon Bootstrap Icons (https://icons.getbootstrap.com)
 * - Komunitas: Disimpan di public/assets/images/komunitas/ (rasio 4:5 atau tegak)
 * - Program: Disimpan di public/assets/images/program/ (rasio landscape ~16:9 atau 4:3)
 * - Struktur Pengurus: Disimpan di public/assets/images/struktur/ (rasio 1:1 / persegi)
 * ====================================================================================
 */
return [
    'kecamatan' => [
        'Abiansemal',
        'Kuta',
        'Kuta Selatan',
        'Kuta Utara',
        'Mengwi',
        'Petang',
    ],
    'legalitas' => [
        'HKI',
        'HACCP',
        'Halal',
        'Lainnya',
    ],
    'kesiapan' => [
        'Komitmen ketersediaan stok produk memadai selama kegiatan berlangsung',
        'Penerapan kemasan ramah lingkungan (eco-friendly packaging)',
        'Penyediaan sarana pemilahan sampah di area pameran',
        'Kepatuhan pelaporan rekapitulasi penjualan selama kegiatan berlangsung',
        'Persetujuan publikasi profil usaha pada media publikasi resmi pemerintah',
    ],

    /**
     * DAFTAR 17 SUBSEKTOR EKONOMI KREATIF (Standar Kemenparekraf)
     * Ditampilkan di landing page pada section #subsektor
     */
    'subsektor' => [
        [
            'ico' => '<i class="bi bi-egg-fried"></i>',
            'name' => 'Kuliner',
        ],
        [
            'ico' => '<i class="bi bi-person-standing-dress"></i>',
            'name' => 'Fashion',
        ],
        [
            'ico' => '<i class="bi bi-gem"></i>',
            'name' => 'Kriya',
        ],
        [
            'ico' => '<i class="bi bi-controller"></i>',
            'name' => 'Aplikasi & Game',
        ],
        [
            'ico' => '<i class="bi bi-camera"></i>',
            'name' => 'Fotografi',
        ],
        [
            'ico' => '<i class="bi bi-film"></i>',
            'name' => 'Film, Animasi & Video',
        ],
        [
            'ico' => '<i class="bi bi-music-note-beamed"></i>',
            'name' => 'Musik',
        ],
        [
            'ico' => '<i class="bi bi-ticket-perforated"></i>',
            'name' => 'Seni Pertunjukan',
        ],
        [
            'ico' => '<i class="bi bi-palette"></i>',
            'name' => 'Seni Rupa',
        ],
        [
            'ico' => '<i class="bi bi-vector-pen"></i>',
            'name' => 'Desain Komunikasi Visual',
        ],
        [
            'ico' => '<i class="bi bi-lamp"></i>',
            'name' => 'Desain Interior',
        ],
        [
            'ico' => '<i class="bi bi-box-seam"></i>',
            'name' => 'Desain Produk',
        ],
        [
            'ico' => '<i class="bi bi-buildings"></i>',
            'name' => 'Arsitektur',
        ],
        [
            'ico' => '<i class="bi bi-book"></i>',
            'name' => 'Penerbitan',
        ],
        [
            'ico' => '<i class="bi bi-tv"></i>',
            'name' => 'TV & Radio',
        ],
        [
            'ico' => '<i class="bi bi-megaphone"></i>',
            'name' => 'Periklanan',
        ],
        [
            'ico' => '<i class="bi bi-shop"></i>',
            'name' => 'Pasar Seni',
        ],
    ],
    /**
     * JEJARING KOMUNITAS MITRA
     * Ditampilkan di landing page pada section #komunitas
     * Lokasi Foto: public/assets/images/komunitas/ (rasio 4:5 / tegak)
     */
    'komunitas' => [
        [
            'name' => 'Badung Music Society',
            'desc' => 'Wadah pembinaan musisi dan penggiat industri seni musik Kabupaten Badung.',
            'img' => 'assets/images/komunitas/musik.jpg',
        ],
        [
            'name' => 'Komunitas Fotografer Badung',
            'desc' => 'Asosiasi praktisi fotografi dalam eksplorasi visual serta dokumentasi potensi daerah.',
            'img' => 'assets/images/komunitas/foto.jpg',
        ],
        [
            'name' => 'Sanggar Seni Mengwi',
            'desc' => 'Lembaga pelestarian dan pembinaan seni rupa, kriya, dan seni tari tradisional Bali.',
            'img' => 'assets/images/komunitas/sanggar.jpg',
        ],
        [
            'name' => 'Badung Creative Developer',
            'desc' => 'Komunitas pengembang teknologi informasi, aplikasi digital, dan pegiat desain grafis.',
            'img' => 'assets/images/komunitas/dev.jpg',
        ],
    ],

    /**
     * PROGRAM KERJA & PEMBERDAYAAN
     * Ditampilkan di landing page pada section #program
     * Lokasi Foto: public/assets/images/program/ (rasio landscape / 16:9 atau 4:3)
     */
    'program' => [
        [
            'name' => 'Go Ekraf',
            'img' => 'assets/images/program/goekraf.jpg',
            'desc' => 'Program pendampingan dan standardisasi usaha pelaku kreatif: fasilitasi legalitas, penguatan merek, dan pemasaran digital.',
        ],
        [
            'name' => 'Kolaborasi Kreatif Pentahelix',
            'img' => 'assets/images/program/kolaborasi.jpg',
            'desc' => 'Fasilitasi sinergi kemitraan yang menghubungkan pelaku usaha kreatif dengan pasar industri, pemodal, dan jaringan kemitraan strategis.',
        ],
        [
            'name' => 'Pelatihan & Workshop Berkala',
            'img' => 'assets/images/program/pelatihan.jpg',
            'desc' => 'Penyelenggaraan bimbingan teknis terstruktur guna meningkatkan kompetensi dan daya saing sumber daya manusia di berbagai subsektor kreatif.',
        ],
    ],

    /**
     * AGENDA / EVENT STATIS (Cadangan)
     * Catatan: Landing page secara dinamis memprioritaskan agenda dari database (tabel 'agendas')
     * yang diinput oleh Administrator. Array ini menjadi fallback jika database belum terisi.
     * Lokasi Foto: public/assets/images/event/ (event-1.jpg, event-2.jpg, event-3.jpg)
     */
    'event' => [
        [
            'date' => '2026-11-15',
            'name' => 'Badung Creative Fest',
            'loc' => 'Mengwi',
            'time' => '10.00 WITA',
            'img' => 'assets/images/event/event-1.jpg',
        ],
        [
            'date' => '2026-12-02',
            'name' => 'Pameran UMKM Kreatif',
            'loc' => 'Kuta',
            'time' => '10.00 WITA',
            'img' => 'assets/images/event/event-2.jpg',
        ],
        [
            'date' => '2026-12-20',
            'name' => 'Workshop Branding Produk',
            'loc' => 'Abiansemal',
            'time' => '13.00 WITA',
            'img' => 'assets/images/event/event-3.jpg',
        ],
    ],

    /**
     * KALENDER AGENDA STATIS (Cadangan)
     * Catatan: Disinkronkan dengan data database (tabel 'agendas') melalui LandingController.
     */
    'kalender' => [
        [
            'date' => '2026-10-12',
            'name' => 'Rapat Koordinasi Komite',
            'time' => '10.00 WITA',
            'loc' => 'Kantor Komite',
        ],
        [
            'date' => '2026-10-25',
            'name' => 'Sosialisasi Go Ekraf',
            'time' => '09.00 WITA',
            'loc' => 'Mengwi',
        ],
        [
            'date' => '2026-10-25',
            'name' => 'Temu Komunitas',
            'time' => '15.00 WITA',
            'loc' => 'Kuta',
        ],
        [
            'date' => '2026-11-08',
            'name' => 'Kurasi UMKM Kreatif',
            'time' => '13.00 WITA',
            'loc' => 'Abiansemal',
        ],
        [
            'date' => '2026-11-15',
            'name' => 'Badung Creative Fest',
            'time' => '10.00 WITA',
            'loc' => 'Mengwi',
        ],
        [
            'date' => '2026-12-02',
            'name' => 'Pameran UMKM Kreatif',
            'time' => '10.00 WITA',
            'loc' => 'Kuta',
        ],
    ],

    /**
     * STRUKTUR KEPENGURUSAN KOMITE
     * Ditampilkan di landing page pada section #struktur
     * Lokasi Foto Pengurus: public/assets/images/struktur/ (Rasio persegi 1:1, min 400x400px)
     * Untuk mengganti foto: timpa file org-1.jpg s/d org-4.jpg atau ubah path di bawah.
     */
    'struktur' => [
        [
            'name' => 'Nama Ketua',
            'role' => 'Ketua Komite',
            'img' => 'assets/images/struktur/org-1.jpg',
        ],
        [
            'name' => 'Nama Wakil',
            'role' => 'Wakil Ketua Komite',
            'img' => 'assets/images/struktur/org-2.jpg',
        ],
        [
            'name' => 'Nama Sekretaris',
            'role' => 'Sekretaris Komite',
            'img' => 'assets/images/struktur/org-3.jpg',
        ],
        [
            'name' => 'Nama Bendahara',
            'role' => 'Bendahara Komite',
            'img' => 'assets/images/struktur/org-4.jpg',
        ],
    ],
];
