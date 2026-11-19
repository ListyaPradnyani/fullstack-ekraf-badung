<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Resmi Komite Ekonomi Kreatif Kabupaten Badung</title>
  <meta name="description" content="Portal resmi Komite Ekonomi Kreatif (EKRAF) Kabupaten Badung: Direktori pelaku usaha UMKM, sinergi komunitas kreatif, program pemberdayaan, dan kalender kegiatan resmi.">
  <meta name="theme-color" content="#0b4a38">
  <link rel="icon" href="{{ asset('assets/icons/favicon.jpg') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght,SOFT@0,9..144,400..700,100;1,9..144,400..700,100&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
  <div class="progress" id="progress" aria-hidden="true"></div>

  <!-- =========================================================================
       BAGIAN 1: NAVBAR (NAVIGASI UTAMA MELAYANG)
       - File Logo: public/assets/images/logo-ekraf-badung.jpg
       - Link Menu: Mengarah ke anchor section (#home, #about, #umkm, dll.)
       - Tombol Masuk/Panel: Mengarah ke login atau panel dashboard admin
       ========================================================================= -->
  <header class="navbar">
    <div class="nav-inner">
      <a href="#home" class="brand" aria-label="EKRAF BADUNG — Beranda">
        <img src="{{ asset('assets/images/logo-ekraf-badung.jpg') }}" alt="Logo EKRAF BADUNG">
      </a>

      <button class="nav-toggle" aria-label="Buka menu" aria-expanded="false" aria-controls="nav-menu"><span></span></button>

      <nav id="nav-menu" class="nav-menu" aria-label="Navigasi utama">
        <div class="nav-item" data-menu="home">
          <button class="nav-btn" aria-expanded="false">Beranda <span class="chev" aria-hidden="true"></span></button>
          <div class="dropdown">
            <a href="#apa-itu-ekraf">Tentang Ekonomi Kreatif</a>
            <a href="#subsektor">17 Subsektor Ekraf</a>
          </div>
        </div>

        <div class="nav-item" data-menu="about">
          <button class="nav-btn" aria-expanded="false">Profil Komite <span class="chev" aria-hidden="true"></span></button>
          <div class="dropdown">
            <a href="#about">Tentang Komite</a>
            <a href="#visi-misi">Visi &amp; Misi</a>
            <a href="#struktur">Struktur Organisasi</a>
          </div>
        </div>

        <div class="nav-item" data-menu="umkm"><a class="nav-link" href="#umkm">Direktori UMKM</a></div>
        <div class="nav-item" data-menu="komunitas"><a class="nav-link" href="#komunitas">Jejaring Komunitas</a></div>

        <div class="nav-item" data-menu="program">
          <button class="nav-btn" aria-expanded="false">Program &amp; Kegiatan <span class="chev" aria-hidden="true"></span></button>
          <div class="dropdown">
            <a href="#program">Program Kerja</a>
            <a href="#event">Agenda Kegiatan</a>
          </div>
        </div>

        <div class="nav-item" data-menu="calendar"><a class="nav-link" href="#calendar">Kalender Agenda</a></div>
        <div class="nav-cta">
          @auth
            <a class="btn btn-forest nav-login" href="{{ route('dashboard') }}"><i class="bi bi-person-circle" aria-hidden="true"></i>&nbsp;{{ auth()->user()->isAdmin() ? 'Panel Administrator' : 'Akun Saya' }}</a>
          @else
            <a class="btn btn-forest nav-login" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right" aria-hidden="true"></i>&nbsp;Masuk</a>
          @endauth
        </div>
      </nav>
    </div>
  </header>

  <main>
    <!-- =========================================================================
         BAGIAN 2: HERO BANNER & SLIDER
         - Teks Judul & Narasi: Ubah langsung di tag <h1> dan <p class="lead"> di bawah
         - Statistik: Ubah angka pada atribut data-count di tag <ul class="hero-stats">
         - Foto Carousel Slider: Disimpan di public/assets/images/hero/
           * Slide 1: hero-1.jpg (Rasio 4:3, resolusi saran ~1000x750px)
           * Slide 2: hero-2.jpg
           * Slide 3: hero-3.jpg
           * Slide 4: hero-4.jpg
           (Ubah caption teks pada atribut data-caption di setiap tag <figure>)
         ========================================================================= -->
    <section id="home" class="hero" data-menu="home">
      <div class="container">
        <div class="hero-grid">
          <div class="hero-copy">
            <p class="hello">Pemerintah Kabupaten Badung</p>
            <h1>Pengembangan Ekosistem<br><em>Ekonomi Kreatif Badung</em></h1>
            <p class="lead">Wadah kolaborasi strategis antara pemerintah daerah, pelaku usaha, akademisi, dan komunitas dalam memajukan potensi ekonomi kreatif yang berdaya saing global berbasis kearifan budaya lokal.</p>
            <div class="hero-actions">
              <a href="#umkm" class="btn btn-forest">Jelajahi Direktori UMKM</a>
              <a href="#calendar" class="btn btn-ghost">Lihat Kalender Agenda</a>
            </div>
            <ul class="hero-stats">
              <li><b data-count="17">17</b> subsektor</li>
              <li><b data-count="100" data-suffix="+">100+</b> UMKM terdaftar</li>
              <li><b data-count="20" data-suffix="+">20+</b> komunitas mitra</li>
            </ul>
          </div>

          <div class="hero-slider" id="hero-slider" role="region" aria-roledescription="carousel" aria-label="Galeri Ekraf Badung" tabindex="0">
            <div class="hs-frame">
              <div class="hs-track">
                <figure class="hs-slide active" data-tone="" aria-label="1 dari 4" data-caption="Harmoni kebudayaan Bali dan inovasi kreatif daerah"><img src="{{ asset('assets/images/hero/hero-1.jpg') }}" alt="Candi bentar di waktu senja" onerror="this.remove()"></figure>
                <figure class="hs-slide" data-tone="sun" aria-label="2 dari 4" data-caption="Potensi sumber daya alam dan pariwisata Badung"><img src="{{ asset('assets/images/hero/hero-2.jpg') }}" alt="Sawah terasering Badung" loading="lazy" onerror="this.remove()"></figure>
                <figure class="hs-slide" data-tone="sky" aria-label="3 dari 4" data-caption="Pelestarian tradisi dan warisan budaya bernilai ekonomi tinggi"><img src="{{ asset('assets/images/hero/hero-3.jpg') }}" alt="Penjor Bali menjulang" loading="lazy" onerror="this.remove()"></figure>
                <figure class="hs-slide" data-tone="sun" aria-label="4 dari 4" data-caption="Sinergi komunitas dan pelaku usaha kreatif Kabupaten Badung"><img src="{{ asset('assets/images/hero/hero-4.jpg') }}" alt="Pelaku kreatif berkumpul bersama" loading="lazy" onerror="this.remove()"></figure>
              </div>
              <div class="hs-shade" aria-hidden="true"></div>
              <div class="hs-caption" aria-live="polite">
                <span class="hs-count"><b id="hs-now">01</b> / <span id="hs-total">04</span></span>
                <p id="hs-text">Harmoni kebudayaan Bali dan inovasi kreatif daerah</p>
              </div>
              <div class="hs-controls">
                <button class="hs-btn" id="hs-prev" aria-label="Gambar sebelumnya"><i class="bi bi-arrow-left"></i></button>
                <button class="hs-btn" id="hs-next" aria-label="Gambar berikutnya"><i class="bi bi-arrow-right"></i></button>
              </div>
            </div>
            <div class="hs-dots" id="hs-dots" role="tablist" aria-label="Pilih gambar"></div>
          </div>
        </div>
      </div>
    </section>

    <!-- =========================================================================
         BAGIAN 3: TENTANG EKONOMI KREATIF (PENGERTIAN & PERAN STRATEGIS)
         - Foto Ilustrasi Samping: public/assets/images/hero/ekraf.jpg (Rasio tegak 4:5)
         - Poin Keunggulan: Inovasi, Kearifan Lokal, Dampak Ekonomi Berkelanjutan
         ========================================================================= -->
    <section id="apa-itu-ekraf" data-menu="home">
      <div class="container">
        <div class="split">
          <figure class="ph arch tall reveal"><img src="{{ asset('assets/images/hero/ekraf.jpg') }}" alt="Aktivitas ekonomi kreatif Badung" loading="lazy" onerror="this.remove()"></figure>
          <div class="reveal">
            <h2>Pengertian &amp; Peran Strategis Ekonomi Kreatif</h2>
            <p class="lead">Ekonomi kreatif merupakan perwujudan nilai tambah berbasis gagasan, ilmu pengetahuan, dan keterampilan sumber daya manusia yang berakar pada kekayaan seni dan budaya lokal Kabupaten Badung guna menggerakkan perekonomian daerah.</p>
            <ul class="points">
              <li><span class="dot sun"><i class="bi bi-lightbulb"></i></span><div><h3>Inovasi &amp; Daya Cipta</h3><p>Pemanfaatan kreativitas dan kekayaan intelektual sebagai penggerak utama penciptaan nilai tambah produk.</p></div></li>
              <li><span class="dot leaf"><i class="bi bi-flower1"></i></span><div><h3>Kearifan Budaya Lokal</h3><p>Penguatan karya kreatif yang berakar pada nilai luhur seni tradisi, adat istiadat, dan kearifan lokal Bali.</p></div></li>
              <li><span class="dot sky"><i class="bi bi-graph-up-arrow"></i></span><div><h3>Dampak Ekonomi Berkelanjutan</h3><p>Penciptaan lapangan kerja berkualitas, peningkatan daya saing UMKM, dan pertumbuhan ekonomi inklusif.</p></div></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- =========================================================================
         BAGIAN 4: 17 SUBSEKTOR EKONOMI KREATIF (KEMENPAREKRAF)
         - Data Subsektor: Dikelola di config/ekraf.php pada array 'subsektor'
         - Render Otomatis: Ditampilkan via public/js/main.js ke #subsektor-grid
         ========================================================================= -->
    <section id="subsektor" class="band-sage" data-menu="home">
      <div class="container">
        <div class="section-head reveal">
          <h2>17 Subsektor Ekonomi Kreatif</h2>
          <p>Klasifikasi subsektor ekonomi kreatif binaan Pemerintah Kabupaten Badung sesuai standar nasional Kementerian Pariwisata dan Ekonomi Kreatif.</p>
        </div>
        <div id="subsektor-grid" class="sticker-cloud"></div>
      </div>
    </section>

    <!-- =========================================================================
         BAGIAN 5: PROFIL KOMITE EKONOMI KREATIF BADUNG
         - Narasi Profil: Edit langsung pada paragraf di bawah
         - Foto Kolase Profil: Disimpan di public/assets/images/hero/
           * Foto 1 (Arch/Lengkung): about-1.jpg
           * Foto 2 (Blob/Organik):  about-2.jpg
         ========================================================================= -->
    <section id="about" data-menu="about">
      <div class="container">
        <div class="split flip">
          <div class="reveal reveal-left">
            <h2>Profil Komite Ekonomi Kreatif Kabupaten Badung</h2>
            <p class="lead">Komite Ekonomi Kreatif Kabupaten Badung dibentuk sebagai wadah kemitraan strategis antara Pemerintah Daerah dan unsur pentahelix (akademisi, bisnis, komunitas, pemerintah, dan media) dalam mengakselerasi ekosistem ekonomi kreatif daerah.</p>
            <p>Melalui koordinasi lintas pemangku kepentingan, Komite berperan aktif dalam merumuskan rekomendasi kebijakan, mendampingi standardisasi usaha, memfasilitasi pelindungan hak kekayaan intelektual (HKI), serta memperluas akses pasar produk kreatif unggulan Badung ke tingkat nasional maupun internasional.</p>
          </div>
          <div class="duo reveal reveal-right">
            <figure class="ph arch"><img src="{{ asset('assets/images/hero/about-1.jpg') }}" alt="Motif kain tradisional Bali" loading="lazy" onerror="this.remove()"></figure>
            <figure class="ph blob"><img src="{{ asset('assets/images/hero/about-2.jpg') }}" alt="Gamelan gong Bali" loading="lazy" onerror="this.remove()"></figure>
          </div>
        </div>
      </div>
    </section>

    <!-- =========================================================================
         BAGIAN 6: VISI & MISI STRATEGIS
         - Teks Visi & Misi: Edit langsung pada tag <article class="vm-visi"> dan <article class="vm-misi">
         ========================================================================= -->
    <section id="visi-misi" class="band-forest" data-menu="about">
      <div class="container">
        <div class="section-head reveal">
          <h2>Visi &amp; Misi Strategis</h2>
          <p class="text-white-50">Arah haluan pembangunan dan penguatan ekosistem ekonomi kreatif Kabupaten Badung.</p>
        </div>
        <div class="vm-grid">
          <article class="vm-visi reveal reveal-left">
            <h3>Visi</h3>
            <p>Terwujudnya Kabupaten Badung sebagai pusat ekonomi kreatif yang mandiri, berdaya saing global, dan berkelanjutan berbasis keluhuran budaya Bali.</p>
          </article>
          <article class="vm-misi reveal reveal-right">
            <h3>Misi</h3>
            <ol>
              <li>Meningkatkan kapasitas kompetensi dan profesionalisme sumber daya manusia kreatif daerah.</li>
              <li>Mendorong inovasi produk lokal berstandar mutu tinggi yang memiliki daya saing pasar global.</li>
              <li>Memperkuat sinergi pentahelix dalam pembiayaan, fasilitasi legalitas, dan pelindungan kekayaan intelektual.</li>
              <li>Memperluas akses promosi dan jaringan rantai pasok pasar domestik serta mancanegara.</li>
            </ol>
          </article>
        </div>
      </div>
    </section>

    <!-- =========================================================================
         BAGIAN 7: STRUKTUR ORGANISASI KEPENGURUSAN (SIMETRIS)
         - Data Pengurus: Dikelola di config/ekraf.php pada array 'struktur'
         - Lokasi File Foto:
           * Ketua:      public/assets/images/struktur/org-1.jpg
           * Wakil:      public/assets/images/struktur/org-2.jpg
           * Sekretaris: public/assets/images/struktur/org-3.jpg
           * Bendahara:  public/assets/images/struktur/org-4.jpg
         - Saran Format Foto: Rasio 1:1 (persegi), resolusi min. 400x400px (ditampilkan bulat simetris)
         ========================================================================= -->
    <section id="struktur" data-menu="about">
      <div class="container">
        <div class="section-head reveal">
          <h2>Struktur Kepengurusan Komite</h2>
          <p>Susunan pengurus dan penanggung jawab bidang teknis Komite Ekonomi Kreatif Kabupaten Badung.</p>
        </div>
        <div id="org-grid" class="org-grid"></div>
      </div>
    </section>

    <!-- =========================================================================
         BAGIAN 8: DIREKTORI PELAKU USAHA & UMKM KREATIF
         - Data UMKM: Diambil dinamis dari Database (Tabel 'umkms') melalui LandingController.php
         - Kategori Filter: "Semua", "Fashion", "Kriya" (public/js/main.js)
         - Sistem Pagination: Otomatis diatur di public/js/main.js (6 UMKM per halaman)
         - Form Registrasi UMKM: resources/views/partials/daftar-umkm.blade.php
         ========================================================================= -->
    <section id="umkm" class="band-peach" data-menu="umkm">
      <div class="container">
        <div class="section-head reveal">
          <h2>Direktori Pelaku Usaha &amp; UMKM Kreatif</h2>
          <p>Katalog resmi pelaku usaha ekonomi kreatif yang terdaftar dan terverifikasi di wilayah Kabupaten Badung.</p>
        </div>
        <div class="toolbar">
          <input id="umkm-search" type="search" placeholder="Cari nama pelaku usaha, brand, atau kecamatan…" aria-label="Cari UMKM">
          <div id="umkm-filters" class="filters" role="group" aria-label="Filter kategori"></div>
        </div>
        <div id="umkm-grid" class="cards"></div>
        <div id="umkm-pagination" class="umkm-pagination"></div>

        @include('partials.daftar-umkm')
      </div>
    </section>

    <!-- =========================================================================
         BAGIAN 9: JEJARING KOMUNITAS KREATIF MITRA
         - Data Komunitas: Dikelola di config/ekraf.php pada array 'komunitas'
         - Lokasi Foto: public/assets/images/komunitas/ (musik.jpg, foto.jpg, sanggar.jpg, dev.jpg)
         ========================================================================= -->
    <section id="komunitas" data-menu="komunitas">
      <div class="container">
        <div class="section-head reveal">
          <h2>Jejaring Komunitas Kreatif</h2>
          <p>Kolaborasi aktif bersama kelompok penggerak seni, asosiasi profesi, dan komunitas kreatif di Kabupaten Badung.</p>
        </div>
        <div id="komunitas-grid" class="komunitas-grid"></div>
      </div>
    </section>

    <!-- =========================================================================
         BAGIAN 10: PROGRAM KERJA & PEMBERDAYAAN
         - Data Program: Dikelola di config/ekraf.php pada array 'program'
         - Lokasi Foto: public/assets/images/program/ (goekraf.jpg, kolaborasi.jpg, pelatihan.jpg)
         ========================================================================= -->
    <section id="program" class="band-sage" data-menu="program">
      <div class="container">
        <div class="section-head reveal">
          <h2>Program Kerja &amp; Pemberdayaan</h2>
          <p>Program strategis pendampingan, penguatan kapasitas, dan akselerasi daya saing pelaku usaha ekonomi kreatif daerah.</p>
        </div>
        <div id="program-grid" class="program-list"></div>
      </div>
    </section>

    <!-- =========================================================================
         BAGIAN 11: AGENDA KEGIATAN & EVENT MENDATANG
         - Sumber Data: Sinkron dinamis dari Database Admin (Tabel 'agendas') via LandingController.php
         - Foto Event: Memakai siklus foto di public/assets/images/event/ (event-1.jpg, event-2.jpg, event-3.jpg)
         - Interaksi: Mengklik kartu kegiatan otomatis menggeser & menyorot tanggal terkait pada kalender di bawah
         ========================================================================= -->
    <section id="event" data-menu="program">
      <div class="container">
        <div class="section-head reveal">
          <h2>Agenda Kegiatan &amp; Event Mendatang</h2>
          <p>Daftar agenda kegiatan, lokakarya, pameran UMKM, dan festival resmi yang diselenggarakan di Kabupaten Badung.</p>
        </div>
        <div id="event-grid" class="cards"></div>
      </div>
    </section>

    <!-- =========================================================================
         BAGIAN 12: KALENDER AGENDA KEGIATAN
         - Sumber Data: Sinkron dinamis dari Database Admin (Tabel 'agendas') via LandingController.php
         - Fitur: Navigasi bulan, dropdown pemilih tahun/bulan, dan panel detail kegiatan harian
         ========================================================================= -->
    <section id="calendar" class="band-forest" data-menu="calendar">
      <div class="container">
        <div class="section-head reveal">
          <h2>Kalender Agenda Kegiatan</h2>
          <p>Jadwal resmi agenda kerja, koordinasi, kurasi, dan kegiatan Komite Ekonomi Kreatif Kabupaten Badung yang dikelola oleh administrator.</p>
        </div>
        <div class="cal reveal reveal-zoom">
          <div class="cal-board">
            <div class="cal-top">
              <button class="cal-nav" id="cal-prev" aria-label="Bulan sebelumnya">‹</button>
              <div class="cal-title-wrap">
                <button type="button" class="cal-title-btn" id="cal-title" aria-haspopup="dialog" aria-expanded="false" title="Pilih bulan dan tahun">
                  <span class="cal-title-text" aria-live="polite"></span>
                  <i class="bi bi-chevron-down cal-title-icon" aria-hidden="true"></i>
                </button>
                <div class="cal-picker" id="cal-picker" hidden role="dialog" aria-label="Pemilih Bulan dan Tahun">
                  <div class="cal-picker-header">
                    <div class="cal-picker-year-ctrl">
                      <button type="button" class="cal-py-btn" id="cal-picker-prev-year" aria-label="Tahun sebelumnya"><i class="bi bi-chevron-left"></i></button>
                      <span class="cal-picker-year" id="cal-picker-year"></span>
                      <button type="button" class="cal-py-btn" id="cal-picker-next-year" aria-label="Tahun berikutnya"><i class="bi bi-chevron-right"></i></button>
                    </div>
                    <button type="button" class="cal-picker-today-btn" id="cal-picker-today">Bulan Ini</button>
                  </div>
                  <div class="cal-picker-months" id="cal-picker-months"></div>
                </div>
              </div>
              <button class="cal-nav" id="cal-next" aria-label="Bulan berikutnya">›</button>
            </div>
            <div class="cal-dow" aria-hidden="true"><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span></div>
            <div id="cal-grid" class="cal-grid"></div>
          </div>
          <aside class="cal-agenda">
            <h4 id="agenda-title">Agenda bulan ini</h4>
            <div id="cal-list" class="agenda-list"></div>
          </aside>
        </div>
      </div>
    </section>
  </main>

  <!-- =========================================================================
       BAGIAN 13: FOOTER RESMI PEMKAB BADUNG
       - Link internal, atribusi instansi, dan hak cipta resmi
       ========================================================================= -->
  <footer class="footer">
    <div class="container">
      <p class="footer-big">Ekraf Badung</p>
      <div class="footer-grid">
        <div>
          <p>Komite Ekonomi Kreatif Kabupaten Badung. Wadah resmi pengembangan potensi industri kreatif di bawah naungan Pemerintah Kabupaten Badung, Provinsi Bali.</p>
        </div>
        <ul>
          <li><a href="#home">Beranda</a></li>
          <li><a href="#about">Profil Komite</a></li>
          <li><a href="#umkm">Direktori UMKM</a></li>
          <li><a href="#komunitas">Jejaring Komunitas</a></li>
        </ul>
        <ul>
          <li><a href="#program">Program Kerja</a></li>
          <li><a href="#event">Agenda Kegiatan</a></li>
          <li><a href="#calendar">Kalender Agenda</a></li>
          <li>@auth<a href="{{ route('dashboard') }}">Panel Administrator</a>@else<a href="{{ route('login') }}">Masuk / Pendaftaran Akun</a>@endauth</li>
        </ul>
      </div>
      <div class="footer-bottom">© <span id="year"></span> Pemerintah Kabupaten Badung — Komite Ekonomi Kreatif. Hak Cipta Dilindungi.</div>
    </div>
  </footer>

  <!-- =========================================================================
       MODAL POPUP DETAIL PELAKU USAHA UMKM
       - Muncul otomatis saat kartu UMKM pada direktori diklik
       - Data teks, kontak WhatsApp, Instagram, dan peta dimuat dinamis via public/js/main.js (fungsi fillModal)
       ========================================================================= -->
  <div class="modal" id="umkm-modal" hidden>
    <div class="m-backdrop" data-close></div>
    <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="m-title">
      <button class="modal-close" data-close aria-label="Tutup detail"><i class="bi bi-x-lg"></i></button>
      <div class="m-media" id="m-media"></div>
      <div class="m-body" id="m-body"></div>
    </div>
  </div>

  <button class="to-top" id="to-top" aria-label="Kembali ke atas"><i class="bi bi-arrow-up"></i></button>

  <script>window.EKRAF_DATA = @json($data);</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>
