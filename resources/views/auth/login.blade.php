@extends('layouts.app')
@section('title', 'Masuk')
@section('inline-errors', '1')
@section('no-nav', '1')
@section('main-class', 'p-0')

@section('content')
<!-- Topbar Minimalis (Tanpa Navbar Default, Persis Referensi Tokopedia) -->
<header class="auth-tokopedia-topbar">
  <div class="container d-flex align-items-center justify-content-between">
    <a href="{{ route('home') }}" class="auth-brand-pill" aria-label="Beranda Ekraf Badung">
      <img src="{{ asset('assets/images/logo-ekraf-badung.jpg') }}" alt="Logo Ekraf Badung">
    </a>
    <a href="{{ route('home') }}" class="auth-nav-back-link">
      <i class="bi bi-arrow-left"></i> <span>Kembali ke Website</span>
    </a>
  </div>
</header>

<!-- Konten Split 2 Kolom (Persis Pola Tokopedia) -->
<div class="auth-tokopedia-main">
  <div class="container">
    <div class="row align-items-center justify-content-center g-4 g-lg-5">

      <!-- Kolom Kiri: Ilustrasi Kreatif & Showcase UMKM Badung -->
      <div class="col-lg-6 d-none d-lg-block">
        <div class="auth-showcase-panel">
          <div class="auth-illustration-wrap">
            <!-- Micro-Interactions: Floating Badges -->
            <div class="floating-pill pill-top-left">
              <i class="bi bi-patch-check-fill text-success fs-6"></i>
              <span>Direktori UMKM Resmi</span>
            </div>
            <div class="floating-pill pill-bottom-right">
              <i class="bi bi-shop text-warning fs-6"></i>
              <span>17 Subsektor Ekraf</span>
            </div>

            <!-- Ilustrasi Vektor Khas Ekraf Badung -->
            <svg class="auth-illustration-svg" viewBox="0 0 440 310" fill="none" xmlns="http://www.w3.org/2000/svg">
              <!-- Background Ambient Blobs -->
              <circle cx="220" cy="155" r="140" fill="#E3EEE4" fill-opacity="0.75"/>
              <circle cx="285" cy="115" r="95" fill="#FDE6D3" fill-opacity="0.8"/>
              <circle cx="145" cy="195" r="85" fill="#D4E8EC" fill-opacity="0.6"/>

              <!-- Balinese Candi Bentar Silhouette di latar belakang -->
              <path d="M115 220V120L130 130V105L145 115V80L160 95V220H115Z" fill="#0B4A38" fill-opacity="0.12"/>
              <path d="M325 220V120L310 130V105L295 115V80L280 95V220H325Z" fill="#0B4A38" fill-opacity="0.12"/>

              <!-- Platform / Lantai Dasar -->
              <ellipse cx="220" cy="235" rx="185" ry="22" fill="#DDE7E0"/>

              <!-- Parasut Paket Produk Kreatif (Sentuhan khas Tokopedia beraksen Ekraf Badung) -->
              <g transform="translate(60, 42)">
                <path d="M0 35C0 15.67 17.9 0 40 0C62.1 0 80 15.67 80 35H0Z" fill="#0B4A38"/>
                <path d="M25 35C25 15.67 31.7 0 40 0C48.3 0 55 15.67 55 35H25Z" fill="#F58220"/>
                <line x1="0" y1="35" x2="35" y2="60" stroke="#8FA097" stroke-width="1.5"/>
                <line x1="80" y1="35" x2="45" y2="60" stroke="#8FA097" stroke-width="1.5"/>
                <line x1="40" y1="35" x2="40" y2="60" stroke="#8FA097" stroke-width="1.5"/>
                <rect x="28" y="60" width="24" height="24" rx="4" fill="#FDE6D3" stroke="#F58220" stroke-width="2"/>
                <line x1="40" y1="60" x2="40" y2="84" stroke="#F58220" stroke-width="2"/>
              </g>

              <!-- Toko UMKM Ekraf Badung (Storefront) -->
              <g transform="translate(145, 95)">
                <rect x="25" y="45" width="150" height="95" rx="8" fill="#FFFFFF" stroke="#0B4A38" stroke-width="2.5"/>
                <rect x="80" y="75" width="40" height="65" rx="4" fill="#0B4A38"/>
                <rect x="85" y="80" width="30" height="55" rx="2" fill="#1F7A52"/>
                <circle cx="110" cy="108" r="3" fill="#F58220"/>
                
                <rect x="35" y="75" width="35" height="40" rx="4" fill="#D4E8EC" stroke="#0B4A38" stroke-width="2"/>
                <rect x="130" y="75" width="35" height="40" rx="4" fill="#D4E8EC" stroke="#0B4A38" stroke-width="2"/>
                
                <!-- Produk di etalase: Kerajinan Gerabah & Produk Kopi -->
                <path d="M47 105C47 97 57 97 57 105H47Z" fill="#F58220"/>
                <path d="M142 105C142 97 152 97 152 105H142Z" fill="#0B4A38"/>

                <!-- Kanopi Toko (Garis Hijau & Oranye Ekraf) -->
                <path d="M10 45L20 15H180L190 45H10Z" fill="#0B4A38"/>
                <path d="M35 45L40 15H65L55 45H35Z" fill="#F58220"/>
                <path d="M85 45L90 15H115L105 45H85Z" fill="#F58220"/>
                <path d="M135 45L140 15H165L155 45H135Z" fill="#F58220"/>
                
                <!-- Gelombang Kanopi -->
                <path d="M10 45C10 50 17 52 22 45C27 52 34 52 39 45C44 52 51 52 56 45C61 52 68 52 73 45C78 52 85 52 90 45C95 52 102 52 107 45C112 52 119 52 124 45C129 52 136 52 141 45C146 52 153 52 158 45C163 52 170 52 175 45C180 52 187 50 190 45V42H10V45Z" fill="#0B4A38"/>

                <!-- Papan Nama Toko -->
                <rect x="55" y="-5" width="90" height="22" rx="6" fill="#F58220" stroke="#FFFFFF" stroke-width="2"/>
                <text x="100" y="10" font-family="'Figtree', sans-serif" font-weight="bold" font-size="9" fill="#FFFFFF" text-anchor="middle" letter-spacing="0.5">EKRAF STORE</text>
              </g>

              <!-- Maskot Tas Kreatif Hijau Daun yang Ramah -->
              <g transform="translate(120, 160)">
                <rect x="0" y="20" width="60" height="52" rx="14" fill="#1F7A52" stroke="#0B4A38" stroke-width="2"/>
                <path d="M18 20V8C18 3.5 42 3.5 42 8V20" stroke="#0B4A38" stroke-width="3" fill="none" stroke-linecap="round"/>
                <ellipse cx="20" cy="40" rx="5" ry="6" fill="#FFFFFF"/>
                <ellipse cx="40" cy="40" rx="5" ry="6" fill="#FFFFFF"/>
                <circle cx="21" cy="40" r="3" fill="#10261D"/>
                <circle cx="39" cy="40" r="3" fill="#10261D"/>
                <path d="M24 50C24 54 36 54 36 50" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round"/>
                <circle cx="12" cy="48" r="3" fill="#F58220" fill-opacity="0.6"/>
                <circle cx="48" cy="48" r="3" fill="#F58220" fill-opacity="0.6"/>
                <circle cx="46" cy="18" r="6" fill="#F58220"/>
                <circle cx="46" cy="18" r="2.5" fill="#FFFFFF"/>
              </g>

              <!-- Ikon Melayang: Palet Lukis & Kamera Kreatif -->
              <g transform="translate(295, 170)">
                <path d="M0 25C0 11.2 11.2 0 25 0C38.8 0 50 11.2 50 25C50 32 45 35 40 35C37 35 35 32 32 32C29 32 27 35 25 35C11.2 35 0 25 0 25Z" fill="#FDE6D3" stroke="#F58220" stroke-width="2"/>
                <circle cx="14" cy="16" r="3" fill="#0B4A38"/>
                <circle cx="25" cy="10" r="3" fill="#F58220"/>
                <circle cx="36" cy="16" r="3" fill="#1F7A52"/>
                <circle cx="16" cy="27" r="4" fill="#FFFFFF" stroke="#F58220" stroke-width="1.5"/>
              </g>

              <g transform="translate(345, 125)">
                <rect x="0" y="8" width="42" height="30" rx="6" fill="#0B4A38"/>
                <circle cx="21" cy="23" r="8" fill="#D4E8EC" stroke="#FFFFFF" stroke-width="2"/>
                <rect x="13" y="3" width="16" height="5" rx="2" fill="#F58220"/>
                <circle cx="34" cy="14" r="2" fill="#F58220"/>
              </g>
            </svg>
          </div>

          <!-- Headline & Subtitle persis gaya Tokopedia -->
          <h2 class="auth-showcase-title">Pusat Direktori & Potensi UMKM Badung</h2>
          <p class="auth-showcase-desc">Satu wadah terintegrasi untuk pendataan, fasilitasi kurasi, dan promosi produk ekonomi kreatif Kabupaten Badung.</p>

          <!-- Feature Pills -->
          <div class="auth-feature-pills">
            <span class="feature-pill-item"><i class="bi bi-patch-check-fill text-success"></i> Terdaftar Resmi</span>
            <span class="feature-pill-item"><i class="bi bi-shop text-warning"></i> 17 Subsektor Ekraf</span>
            <span class="feature-pill-item"><i class="bi bi-graph-up-arrow text-info"></i> Promosi Digital</span>
          </div>
        </div>
      </div>

      <!-- Kolom Kanan: Card Login Berpola Modern -->
      <div class="col-12 col-md-8 col-lg-5 col-xl-5">
        <div class="auth-card-tokopedia">
          <div class="auth-card-header">
            <h1 class="auth-card-title">Masuk Sekarang</h1>
            <p class="auth-card-subtitle">
              Belum punya akun Ekraf? <a href="{{ route('register') }}">Daftar sebagai pelaku usaha</a>
            </p>
          </div>

          <!-- Form Login (Hanya Email & Password terdaftar) -->
          <form method="POST" action="{{ url('/login') }}" novalidate>
            @csrf

            <!-- Input Email (Pill Shape with Icon) -->
            <div class="auth-field-group">
              <label for="email" class="auth-field-label">Email</label>
              <div class="auth-input-pill-wrap">
                <span class="input-icon"><i class="bi bi-person"></i></span>
                <input id="email" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       class="auth-input-pill @error('email') is-invalid @enderror" 
                       placeholder="nama@email.com" 
                       required 
                       autofocus 
                       autocomplete="username">
              </div>
              @error('email')
                <div class="auth-field-error">
                  <i class="bi bi-exclamation-circle-fill"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>

            <!-- Input Password (Pill Shape with Lock & Eye Toggle) -->
            <div class="auth-field-group">
              <label for="password" class="auth-field-label">Password</label>
              <div class="auth-input-pill-wrap">
                <span class="input-icon"><i class="bi bi-lock"></i></span>
                <input id="password" 
                       type="password" 
                       name="password" 
                       class="auth-input-pill has-toggle @error('password') is-invalid @enderror" 
                       placeholder="Masukkan password Anda" 
                       required 
                       autocomplete="current-password">
                <button type="button" class="auth-btn-pwd-toggle" id="togglePassword" aria-label="Lihat password" tabindex="-1">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
              @error('password')
                <div class="auth-field-error">
                  <i class="bi bi-exclamation-circle-fill"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>

            <!-- Checkbox Ingat Saya -->
            <div class="auth-check-row">
              <label class="auth-checkbox-label" for="remember">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span>Ingat saya</span>
              </label>
            </div>

            <!-- Tombol Masuk Gradien Kapsul -->
            <button type="submit" class="auth-submit-btn">
              <span>MASUK</span>
              <i class="bi bi-arrow-right"></i>
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    if (toggleBtn && passwordInput) {
      toggleBtn.addEventListener('click', function () {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        const icon = this.querySelector('i');
        if (icon) {
          icon.classList.toggle('bi-eye', !isPassword);
          icon.classList.toggle('bi-eye-slash', isPassword);
        }
        this.setAttribute('aria-label', isPassword ? 'Sembunyikan password' : 'Lihat password');
      });
    }
  });
</script>
@endpush
