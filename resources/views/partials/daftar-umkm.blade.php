{{-- Section Pendaftaran UMKM: Dual-Column Split Grid (@guest) & Compact Direct Form (@auth) --}}
@php
  $adaAkun = auth()->check();
  $adalahAdmin = $adaAkun && auth()->user()->isAdmin();
  $pilihLegal = old('legalitas', []);
  $pilihSiap = old('kesiapan', []);
@endphp

@guest
  {{-- Tampilan untuk Tamu (Belum Login): Split Grid 2 Kolom (Kiri: Preview/Overview, Kanan: CTA) --}}
  <div class="reg reg-guest-wrap" id="daftar-umkm">
    <div class="row g-4 align-items-stretch reg-split">
      {{-- Kolom Kiri: Overview/Preview Form --}}
      <div class="col-12 col-lg-7">
        <div class="reg-preview-card">
          <div class="reg-preview-head">
            <span class="tag">Overview Pendaftaran</span>
            <h3>Tahapan Registrasi UMKM Ekraf</h3>
            <p>Siapkan informasi dan berkas usahamu untuk bergabung dalam ekosistem ekonomi kreatif Kabupaten Badung.</p>
          </div>

          <div class="reg-preview-steps">
            <div class="reg-pstep">
              <span class="pstep-num">1</span>
              <div class="pstep-body">
                <h4>Data &amp; Identitas Usaha</h4>
                <p>Nama pelaku, nama brand, kecamatan di Badung, subsektor ekraf, kontak WhatsApp, dan alamat usaha.</p>
              </div>
            </div>

            <div class="reg-pstep">
              <span class="pstep-num">2</span>
              <div class="pstep-body">
                <h4>Karya &amp; Produk Unggulan</h4>
                <p>Rincian produk kreatif yang diajukan serta cerita singkat perjalanan &amp; keunikan produkmu.</p>
              </div>
            </div>

            <div class="reg-pstep">
              <span class="pstep-num">3</span>
              <div class="pstep-body">
                <h4>Foto &amp; Dokumen Kurasi</h4>
                <p>Foto KTP &amp; NIB (khusus verifikasi internal kurator) serta 1–5 foto produk kreatif beresolusi baik.</p>
              </div>
            </div>

            <div class="reg-pstep">
              <span class="pstep-num">4</span>
              <div class="pstep-body">
                <h4>Legalitas &amp; Komitmen Program</h4>
                <p>Legalitas tambahan yang dimiliki (HKI, Halal, dll) serta kesiapan keikutsertaan event Go Ekraf.</p>
              </div>
            </div>
          </div>

          <div class="reg-preview-foot">
            <i class="bi bi-shield-check"></i>
            <span>Data diverifikasi secara aman oleh tim kurator Komite Ekraf Badung.</span>
          </div>
        </div>
      </div>

      {{-- Kolom Kanan: Call to Action (CTA) & Tombol Aksi --}}
      <div class="col-12 col-lg-5">
        <div class="reg-cta-card">
          <div class="reg-cta-badge">
            <i class="bi bi-stars"></i>
            <span>Akses Direktori Resmi</span>
          </div>

          <h3 class="reg-cta-title">Kembangkan Usaha Kreatifmu Bersama Kami</h3>
          <p class="reg-cta-desc">Daftarkan produk dan brand lokalmu agar terhubung dengan jejaring ekonomi kreatif, kurasi event kabupaten, dan publikasi luas.</p>

          <ul class="reg-cta-benefits">
            <li>
              <i class="bi bi-check-circle-fill"></i>
              <div>
                <b>Publikasi Profil Terkurasi</b>
                <span>Tampil di direktori website resmi Ekraf Badung untuk publik &amp; wisatawan.</span>
              </div>
            </li>
            <li>
              <i class="bi bi-check-circle-fill"></i>
              <div>
                <b>Prioritas Kurasi Event</b>
                <span>Kesempatan ikut serta dalam pameran, festival, dan program Go Ekraf Badung.</span>
              </div>
            </li>
            <li>
              <i class="bi bi-check-circle-fill"></i>
              <div>
                <b>Kelola Mandiri Portofolio</b>
                <span>Perbarui deskripsi produk dan jam operasional kapan saja lewat akunmu.</span>
              </div>
            </li>
          </ul>

          <div class="reg-cta-actionbox">
            <div class="reg-cta-note">
              <i class="bi bi-info-circle"></i>
              <span>Untuk menjaga validitas data, pendaftaran dilakukan melalui akun terdaftar.</span>
            </div>
            <div class="reg-cta-buttons">
              <a href="{{ route('login') }}" class="btn btn-forest w-100">
                <i class="bi bi-box-arrow-in-right"></i>&nbsp; Masuk untuk Mendaftar
              </a>
              <a href="{{ route('register') }}" class="btn btn-ghost w-100">
                <i class="bi bi-person-plus"></i>&nbsp; Belum punya akun? Daftar
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@else
  {{-- Tampilan untuk Pengguna Login (@auth): Form Ramping & Compact Langsung Terhubung ke user_id --}}
  <div class="row justify-content-center">
    <div class="col-12 col-lg-9 mx-auto">
      <div class="reg reg-auth" id="daftar-umkm">
        <div class="reg-head">
          <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
            <span class="tag">Formulir Terhubung</span>
            <div class="reg-user-pill">
              <i class="bi bi-person-check-fill"></i>
              <span>Masuk sebagai: <b>{{ auth()->user()->name }}</b></span>
            </div>
          </div>
          <h3>Daftarkan UMKM-mu</h3>
          <p>Lengkapi formulir di bawah ini. Data UMKM akan otomatis terhubung dengan akunmu dan ditinjau oleh tim kurator sebelum tayang di direktori publik.</p>
        </div>

        @if($adalahAdmin)
          <div class="reg-note">Kamu masuk sebagai admin. Kamu dapat mengisi form ini atau mengelola data UMKM dari <a href="{{ route('admin.umkm.index') }}"><b>panel admin</b></a>.</div>
        @endif

        @if($errors->any())
          <div class="reg-alert" role="alert" tabindex="-1">
            <b>Ada isian yang perlu diperbaiki:</b>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
          </div>
        @endif

        <form class="reg-form" method="POST" action="{{ route('umkm.daftar') }}" enctype="multipart/form-data" novalidate data-reg>
          @csrf

          <fieldset>
            <legend><span>1</span> Data usaha</legend>
            <div class="row g-2 g-md-3">
              <div class="col-12 col-md-6 f">
                <label for="r-nama_pelaku">Nama pelaku usaha <i>*</i></label>
                <input id="r-nama_pelaku" name="nama_pelaku" value="{{ old('nama_pelaku', auth()->user()->name) }}" required autocomplete="name" class="@error('nama_pelaku') bad @enderror">
                @error('nama_pelaku')<small class="err">{{ $message }}</small>@enderror
              </div>
              <div class="col-12 col-md-6 f">
                <label for="r-nama_brand">Nama brand <i>*</i></label>
                <input id="r-nama_brand" name="nama_brand" value="{{ old('nama_brand') }}" required class="@error('nama_brand') bad @enderror">
                @error('nama_brand')<small class="err">{{ $message }}</small>@enderror
              </div>
              <div class="col-12 col-md-6 f">
                <label for="r-kecamatan">Kecamatan <i>*</i></label>
                <select id="r-kecamatan" name="kecamatan" required class="@error('kecamatan') bad @enderror">
                  <option value="">Pilih kecamatan di Badung</option>
                  @foreach(config('ekraf.kecamatan') as $k)<option value="{{ $k }}" @selected(old('kecamatan') === $k)>{{ $k }}</option>@endforeach
                </select>
                @error('kecamatan')<small class="err">{{ $message }}</small>@enderror
              </div>
              <div class="col-12 col-md-6 f">
                <label for="r-kategori">Subsektor ekraf</label>
                <select id="r-kategori" name="kategori" class="@error('kategori') bad @enderror">
                  <option value="">Pilih subsektor</option>
                  @foreach(config('ekraf.subsektor') as $s)<option value="{{ $s['name'] }}" @selected(old('kategori') === $s['name'])>{{ $s['name'] }}</option>@endforeach
                </select>
                @error('kategori')<small class="err">{{ $message }}</small>@enderror
              </div>
              <div class="col-12 col-md-6 f">
                <label for="r-no_wa">No. WA <i>*</i></label>
                <input id="r-no_wa" name="no_wa" type="tel" inputmode="tel" placeholder="08xxxxxxxxxx" value="{{ old('no_wa') }}" required autocomplete="tel" class="@error('no_wa') bad @enderror">
                @error('no_wa')<small class="err">{{ $message }}</small>@enderror
              </div>
              <div class="col-12 col-md-6 f">
                <label for="r-jam_buka">Jam buka <em>(opsional)</em></label>
                <input id="r-jam_buka" name="jam_buka" placeholder="Senin – Sabtu, 09.00 – 17.00 WITA" value="{{ old('jam_buka') }}">
              </div>
              <div class="col-12 f">
                <label for="r-alamat">Alamat usaha <i>*</i></label>
                <textarea id="r-alamat" name="alamat" rows="2" required class="@error('alamat') bad @enderror">{{ old('alamat') }}</textarea>
                @error('alamat')<small class="err">{{ $message }}</small>@enderror
              </div>
              <div class="col-12 f">
                <label for="r-media_sosial">Media sosial yang dimiliki</label>
                <textarea id="r-media_sosial" name="media_sosial" rows="2" placeholder="Contoh: Instagram @namabrand, TikTok namabrand">{{ old('media_sosial') }}</textarea>
                @error('media_sosial')<small class="err">{{ $message }}</small>@enderror
              </div>
            </div>
          </fieldset>

          <fieldset>
            <legend><span>2</span> Tentang usaha</legend>
            <div class="row g-2 g-md-3">
              <div class="col-12 f">
                <label for="r-produk">Produk yang diajukan <i>*</i></label>
                <textarea id="r-produk" name="produk" rows="2" required placeholder="Satu produk per baris, mis. Kain tenun, Aksesoris perak" class="@error('produk') bad @enderror">{{ old('produk') }}</textarea>
                @error('produk')<small class="err">{{ $message }}</small>@enderror
              </div>
              <div class="col-12 f">
                <label for="r-cerita_usaha">Ceritakan tentang usaha</label>
                <textarea id="r-cerita_usaha" name="cerita_usaha" rows="3" placeholder="Sejarah singkat, keunikan bahan/desain, dan nilai kearifan lokal yang dibawa.">{{ old('cerita_usaha') }}</textarea>
                @error('cerita_usaha')<small class="err">{{ $message }}</small>@enderror
              </div>
            </div>
          </fieldset>

          <fieldset>
            <legend><span>3</span> Foto &amp; dokumen</legend>
            <p class="hint">Format JPG/PNG (KTP &amp; NIB boleh PDF). KTP &amp; NIB hanya untuk verifikasi internal kurator dan tidak dipublikasikan ke publik. Foto produk tampil pada kartu direktori.</p>
            <div class="row g-2 g-md-3">
              <div class="col-12 col-md-6 f">
                <label for="r-foto_ktp">Foto KTP <i>*</i></label>
                <input class="file @error('foto_ktp') bad @enderror" id="r-foto_ktp" type="file" name="foto_ktp" accept=".jpg,.jpeg,.png,.pdf" required>
                @error('foto_ktp')<small class="err">{{ $message }}</small>@enderror
              </div>
              <div class="col-12 col-md-6 f">
                <label for="r-foto_nib">Foto NIB <i>*</i></label>
                <input class="file @error('foto_nib') bad @enderror" id="r-foto_nib" type="file" name="foto_nib" accept=".jpg,.jpeg,.png,.pdf" required>
                @error('foto_nib')<small class="err">{{ $message }}</small>@enderror
              </div>
              <div class="col-12 f">
                <label for="r-foto_produk">Foto produk <i>*</i> <em>(1–5 foto)</em></label>
                <input class="file @error('foto_produk') bad @enderror" id="r-foto_produk" type="file" name="foto_produk[]" accept=".jpg,.jpeg,.png,.webp" multiple required data-max="5">
                <div class="previews" data-previews="r-foto_produk" aria-live="polite"></div>
                @error('foto_produk')<small class="err">{{ $message }}</small>@enderror
                @foreach($errors->get('foto_produk.*') as $msgs)@foreach($msgs as $m)<small class="err">{{ $m }}</small>@endforeach @endforeach
              </div>
            </div>
          </fieldset>

          <fieldset>
            <legend><span>4</span> Foto legalitas usaha lain yang dimiliki</legend>
            <p class="hint">Centang yang dimiliki, lalu unggah fotonya (HKI, HACCP, Halal, dll).</p>
            <div class="row g-2 row-cols-1 row-cols-sm-2 legal-grid">
              @foreach(config('ekraf.legalitas') as $lg)
                <div class="col">
                  <div class="legal">
                    <label class="opt"><input type="checkbox" name="legalitas[]" value="{{ $lg }}" @checked(in_array($lg, $pilihLegal))> <span>{{ $lg === 'Lainnya' ? 'Legalitas lainnya' : $lg }}</span></label>
                    <input class="file sm @error('foto_legalitas.'.$lg) bad @enderror" type="file" name="foto_legalitas[{{ $lg }}]" accept=".jpg,.jpeg,.png,.pdf" aria-label="Foto {{ $lg }}">
                    @error('foto_legalitas.'.$lg)<small class="err">{{ $message }}</small>@enderror
                  </div>
                </div>
              @endforeach
            </div>
          </fieldset>

          <fieldset>
            <legend><span>5</span> Kesiapan stand &amp; komitmen</legend>
            <div class="opt-list">
              @foreach(config('ekraf.kesiapan') as $i => $k)
                <label class="opt"><input type="checkbox" name="kesiapan[]" value="{{ $k }}" @checked(in_array($k, $pilihSiap))> <span>{{ $k }}</span></label>
              @endforeach
            </div>
          </fieldset>

          <div class="consent">
            <label class="opt"><input type="checkbox" name="setuju_data" value="1" required @checked(old('setuju_data'))>
              <span>Saya menyetujui data yang saya isi dikumpulkan, disimpan, dan diolah oleh Komite Ekonomi Kreatif Kabupaten Badung untuk keperluan kurasi, koordinasi, dan kajian ekonomi kreatif, sesuai UU No. 27 Tahun 2022 tentang Pelindungan Data Pribadi. <i>*</i></span></label>
            @error('setuju_data')<small class="err">{{ $message }}</small>@enderror
            <label class="opt"><input type="checkbox" name="tampilkan_kontak" value="1" @checked(old('tampilkan_kontak'))>
              <span>Izinkan nomor WhatsApp saya tampil di website (tombol WhatsApp pada kartu usaha). Jika tidak dicentang, nomor tidak dipublikasikan.</span></label>
          </div>

          <div class="reg-actions">
            <button type="submit" class="btn btn-forest" data-submit><i class="bi bi-send-fill"></i>&nbsp; Kirim pendaftaran UMKM</button>
            <a href="{{ route('dashboard') }}" class="btn btn-ghost"><i class="bi bi-speedometer2"></i>&nbsp; Panel Dashboard</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endguest
