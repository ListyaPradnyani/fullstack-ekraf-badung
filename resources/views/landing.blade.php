<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EKRAF BADUNG, Komite Ekonomi Kreatif Kabupaten Badung</title>
  <meta name="description" content="Website resmi Komite Ekonomi Kreatif (EKRAF) Kabupaten Badung: UMKM kreatif, komunitas, program Go Ekraf, event, dan kalender kegiatan.">
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

  <!-- ===== NAVBAR ===== -->
  <header class="navbar">
    <div class="nav-inner">
      <a href="#home" class="brand" aria-label="EKRAF BADUNG — Beranda">
        <img src="{{ asset('assets/images/logo-ekraf-badung.jpg') }}" alt="Logo EKRAF BADUNG">
      </a>

      <button class="nav-toggle" aria-label="Buka menu" aria-expanded="false" aria-controls="nav-menu"><span></span></button>

      <nav id="nav-menu" class="nav-menu" aria-label="Navigasi utama">
        <div class="nav-item" data-menu="home">
          <button class="nav-btn" aria-expanded="false">Home <span class="chev" aria-hidden="true"></span></button>
          <div class="dropdown">
            <a href="#apa-itu-ekraf">Apa Itu Ekraf</a>
            <a href="#subsektor">Subsektor Ekraf</a>
          </div>
        </div>

        <div class="nav-item" data-menu="about">
          <button class="nav-btn" aria-expanded="false">About <span class="chev" aria-hidden="true"></span></button>
          <div class="dropdown">
            <a href="#about">Apa Itu Komite Ekraf Badung</a>
            <a href="#visi-misi">Visi &amp; Misi</a>
            <a href="#struktur">Struktur Organisasi</a>
          </div>
        </div>

        <div class="nav-item" data-menu="umkm"><a class="nav-link" href="#umkm">UMKM Directory</a></div>
        <div class="nav-item" data-menu="komunitas"><a class="nav-link" href="#komunitas">Komunitas</a></div>

        <div class="nav-item" data-menu="program">
          <button class="nav-btn" aria-expanded="false">Program / Event <span class="chev" aria-hidden="true"></span></button>
          <div class="dropdown">
            <a href="#program">Program Go Ekraf</a>
            <a href="#event">Event Ekraf Badung</a>
          </div>
        </div>

        <div class="nav-item" data-menu="calendar"><a class="nav-link" href="#calendar">Calendar Ekraf</a></div>
        <div class="nav-cta">
          @auth
            <a class="btn btn-forest nav-login" href="{{ route('dashboard') }}"><i class="bi bi-person-circle" aria-hidden="true"></i>&nbsp;{{ auth()->user()->isAdmin() ? 'Panel Admin' : 'Akun Saya' }}</a>
          @else
            <a class="btn btn-forest nav-login" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right" aria-hidden="true"></i>&nbsp;Masuk</a>
          @endauth
        </div>


      </nav>
    </div>
  </header>

  <main>
    <!-- ===== HOME / HERO ===== -->
    <section id="home" class="hero" data-menu="home">
      <div class="container">
        <div class="hero-grid">
          <div class="hero-copy">
            <p class="hello">Halo, Badung!</p>
            <h1>Kreatif dari Badung,<br><em>buat semua orang.</em></h1>
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <div class="hero-actions">
              <a href="#umkm" class="btn btn-forest">Jelajahi UMKM</a>
              <a href="#calendar" class="btn btn-ghost">Lihat kalender</a>
            </div>
            <ul class="hero-stats">
              <li><b data-count="17">17</b> subsektor</li>
              <li><b data-count="100" data-suffix="+">100+</b> UMKM</li>
              <li><b data-count="20" data-suffix="+">20+</b> komunitas</li>
            </ul>
          </div>

          <div class="hero-slider" id="hero-slider" role="region" aria-roledescription="carousel" aria-label="Galeri Ekraf Badung" tabindex="0">
            <div class="hs-frame">
              <div class="hs-track">
                <figure class="hs-slide active" data-tone="" aria-label="1 dari 4" data-caption="Kreativitas berakar dari budaya Bali"><img src="{{ asset('assets/images/hero/hero-1.jpg') }}" alt="Candi bentar di waktu senja" onerror="this.remove()"></figure>
                <figure class="hs-slide" data-tone="sun" aria-label="2 dari 4" data-caption="Alam Badung, sumber inspirasi"><img src="{{ asset('assets/images/hero/hero-2.jpg') }}" alt="Sawah terasering Badung" loading="lazy" onerror="this.remove()"></figure>
                <figure class="hs-slide" data-tone="sky" aria-label="3 dari 4" data-caption="Tradisi yang terus hidup"><img src="{{ asset('assets/images/hero/hero-3.jpg') }}" alt="Penjor Bali menjulang" loading="lazy" onerror="this.remove()"></figure>
                <figure class="hs-slide" data-tone="sun" aria-label="4 dari 4" data-caption="Komunitas yang saling dukung"><img src="{{ asset('assets/images/hero/hero-4.jpg') }}" alt="Pelaku kreatif berkumpul bersama" loading="lazy" onerror="this.remove()"></figure>
              </div>
              <div class="hs-shade" aria-hidden="true"></div>
              <div class="hs-caption" aria-live="polite">
                <span class="hs-count"><b id="hs-now">01</b> / <span id="hs-total">04</span></span>
                <p id="hs-text">Kreativitas berakar dari budaya Bali</p>
              </div>
              <div class="hs-controls">
                <button class="hs-btn" id="hs-prev" aria-label="Gambar sebelumnya"><i class="bi bi-arrow-left"></i></button>
                <button class="hs-btn" id="hs-next" aria-label="Gambar berikutnya"><i class="bi bi-arrow-right"></i></button>
              </div>
            </div>
            <div class="hs-dots" id="hs-dots" role="tablist" aria-label="Pilih gambar"></div>
            <span class="sticker" aria-hidden="true">Badung,<br>soul of Bali</span>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== APA ITU EKRAF ===== -->
    <section id="apa-itu-ekraf" data-menu="home">
      <div class="container">
        <div class="split">
          <figure class="ph arch tall reveal"><img src="{{ asset('assets/images/hero/ekraf.jpg') }}" alt="" loading="lazy" onerror="this.remove()"></figure>
          <div class="reveal">
            <h2>Apa sih ekraf itu?</h2>
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <ul class="points">
              <li><span class="dot sun"><i class="bi bi-lightbulb"></i></span><div><h3>Ide &amp; kreativitas</h3><p>Lorem ipsum dolor sit amet consectetur.</p></div></li>
              <li><span class="dot leaf"><i class="bi bi-flower1"></i></span><div><h3>Budaya Bali</h3><p>Ut enim ad minim veniam quis nostrud.</p></div></li>
              <li><span class="dot sky"><i class="bi bi-graph-up-arrow"></i></span><div><h3>Nilai ekonomi</h3><p>Duis aute irure dolor in reprehenderit.</p></div></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== SUBSEKTOR ===== -->
    <section id="subsektor" class="band-sage" data-menu="home">
      <div class="container">
        <div class="section-head reveal">
          <h2>17 subsektor, pilih yang paling kamu banget</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div id="subsektor-grid" class="sticker-cloud"></div>
      </div>
    </section>

    <!-- ===== ABOUT ===== -->
    <section id="about" data-menu="about">
      <div class="container">
        <div class="split flip">
          <div class="reveal reveal-left">
            <h2>Kenalan sama Komite Ekraf Badung</h2>
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio praesent libero sed cursus ante dapibus diam.</p>
            <p>Sed nisi nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum praesent mauris fusce nec tellus sed augue semper porta.</p>
          </div>
          <div class="duo reveal reveal-right">
            <figure class="ph arch"><img src="{{ asset('assets/images/hero/about-1.jpg') }}" alt="Motif kain tradisional Bali" loading="lazy" onerror="this.remove()"></figure>
            <figure class="ph blob"><img src="{{ asset('assets/images/hero/about-2.jpg') }}" alt="Gamelan gong Bali" loading="lazy" onerror="this.remove()"></figure>
          </div>
        </div>
      </div>
    </section>

    <section id="visi-misi" class="band-forest" data-menu="about">
      <div class="container">
        <div class="section-head reveal">
          <h2>Mau dibawa ke mana?</h2>
        </div>
        <div class="vm-grid">
          <article class="vm-visi reveal reveal-left">
            <h3>Visi</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
          </article>
          <article class="vm-misi reveal reveal-right">
            <h3>Misi</h3>
            <ol>
              <li>Lorem ipsum dolor sit amet consectetur adipiscing elit.</li>
              <li>Sed do eiusmod tempor incididunt ut labore et dolore.</li>
              <li>Ut enim ad minim veniam quis nostrud exercitation.</li>
              <li>Duis aute irure dolor in reprehenderit in voluptate.</li>
            </ol>
          </article>
        </div>
      </div>
    </section>

    <section id="struktur" data-menu="about">
      <div class="container">
        <div class="section-head reveal">
          <h2>Orang-orang di balik komite</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div id="org-grid" class="org-grid"></div>
      </div>
    </section>

    <!-- ===== UMKM DIRECTORY ===== -->
    <section id="umkm" class="band-peach" data-menu="umkm">
      <div class="container">
        <div class="section-head reveal">
          <h2>Jajan karya lokal yuk</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div class="toolbar">
          <input id="umkm-search" type="search" placeholder="Cari nama atau lokasi…" aria-label="Cari UMKM">
          <div id="umkm-filters" class="filters" role="group" aria-label="Filter kategori"></div>
        </div>
        <div id="umkm-grid" class="cards"></div>

        @include('partials.daftar-umkm')
      </div>
    </section>

    <!-- ===== KOMUNITAS ===== -->
    <section id="komunitas" data-menu="komunitas">
      <div class="container">
        <div class="section-head reveal">
          <h2>Gabung geng kreatif</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div id="komunitas-grid" class="komunitas-grid"></div>
      </div>
    </section>

    <!-- ===== PROGRAM ===== -->
    <section id="program" class="band-sage" data-menu="program">
      <div class="container">
        <div class="section-head reveal">
          <h2>Program buat naik kelas</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div id="program-grid" class="program-list"></div>
      </div>
    </section>

    <!-- ===== EVENT ===== -->
    <section id="event" data-menu="program">
      <div class="container">
        <div class="section-head reveal">
          <h2>Seru-seruan mendatang</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div id="event-grid" class="cards"></div>
      </div>
    </section>

    <!-- ===== CALENDAR ===== -->
    <section id="calendar" class="band-forest" data-menu="calendar">
      <div class="container">
        <div class="section-head reveal">
          <h2>Catat tanggalnya ya</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
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

  <!-- ===== FOOTER ===== -->
  <footer class="footer">
    <div class="container">
      <p class="footer-big">Ekraf Badung</p>
      <div class="footer-grid">
        <div>
          <p>Komite Ekonomi Kreatif Kabupaten Badung. Lorem ipsum dolor sit amet.</p>
        </div>
        <ul>
          <li><a href="#home">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#umkm">UMKM Directory</a></li>
          <li><a href="#komunitas">Komunitas</a></li>
        </ul>
        <ul>
          <li><a href="#program">Program Go Ekraf</a></li>
          <li><a href="#event">Event</a></li>
          <li><a href="#calendar">Calendar Ekraf</a></li>
          <li>@auth<a href="{{ route('dashboard') }}">Dashboard</a>@else<a href="{{ route('login') }}">Masuk / Daftar UMKM</a>@endauth</li>
        </ul>
      </div>
      <div class="footer-bottom">© <span id="year"></span> Ekraf Badung</div>
    </div>
  </footer>

  <!-- ===== MODAL DETAIL UMKM ===== -->
  <div class="modal" id="umkm-modal" hidden>
    <div class="modal-backdrop" data-close></div>
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
