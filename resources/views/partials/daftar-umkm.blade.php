{{-- Form UMKM Directory di landing page. Struktur sesuai slide "Struktur Website": --}}
{{-- nama pelaku, nama brand, kecamatan (6), no. WA, alamat, foto KTP/NIB/produk, media sosial, cerita usaha, legalitas lain. --}}
@php
  $adaAkun = auth()->check();
  $adalahAdmin = $adaAkun && auth()->user()->isAdmin();
  $pilihLegal = old('legalitas', []);
  $pilihSiap = old('kesiapan', []);
@endphp
<div class="row justify-content-center">
  <div class="col-12 col-lg-9 mx-auto">
    <div class="reg" id="daftar-umkm">
      <div class="reg-head">
        <span class="tag">Gabung direktori</span>
        <h3>Daftarkan UMKM&#8209;mu</h3>
        <p>Isi data usahamu di sini. Akun kamu <b>otomatis dibuat</b> saat data terkirim, jadi kamu bisa masuk lagi untuk melihat dan mengedit datamu. Data tampil di website setelah dikurasi admin.</p>
      </div>

      @if($adalahAdmin)
        <div class="reg-note">Kamu masuk sebagai admin. Kelola data UMKM dari <a href="{{ route('admin.umkm.index') }}"><b>panel admin</b></a>.</div>
      @else
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
                <input id="r-nama_pelaku" name="nama_pelaku" value="{{ old('nama_pelaku') }}" required autocomplete="name" class="@error('nama_pelaku') bad @enderror">
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
                  <option value="">Pilih salah satu dari 6 kecamatan di Badung</option>
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
                <textarea id="r-media_sosial" name="media_sosial" rows="2" placeholder="Contoh: Instagram @namabrand, TikTok namabrand, Shopee namatoko">{{ old('media_sosial') }}</textarea>
                @error('media_sosial')<small class="err">{{ $message }}</small>@enderror
              </div>
            </div>
          </fieldset>

          <fieldset>
            <legend><span>2</span> Tentang usaha</legend>
            <div class="row g-2 g-md-3">
              <div class="col-12 f">
                <label for="r-produk">Produk yang diajukan <i>*</i></label>
                <textarea id="r-produk" name="produk" rows="2" required placeholder="Satu produk per baris, mis. Kain endek" class="@error('produk') bad @enderror">{{ old('produk') }}</textarea>
                @error('produk')<small class="err">{{ $message }}</small>@enderror
              </div>
              <div class="col-12 f">
                <label for="r-cerita_usaha">Ceritakan tentang usaha</label>
                <textarea id="r-cerita_usaha" name="cerita_usaha" rows="3" placeholder="Sejarah singkat, keunikan produk, dan nilai yang ingin kamu bawa.">{{ old('cerita_usaha') }}</textarea>
                @error('cerita_usaha')<small class="err">{{ $message }}</small>@enderror
              </div>
            </div>
          </fieldset>

          <fieldset>
            <legend><span>3</span> Foto & dokumen</legend>
            <p class="hint">Format JPG/PNG (KTP & NIB boleh PDF). KTP & NIB hanya dilihat admin dan tidak tampil di website. Foto produk tampil di kartu UMKM.</p>
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
            <legend><span>5</span> Kesiapan stand & komitmen</legend>
            <div class="opt-list">
              @foreach(config('ekraf.kesiapan') as $i => $k)
                <label class="opt"><input type="checkbox" name="kesiapan[]" value="{{ $k }}" @checked(in_array($k, $pilihSiap))> <span>{{ $k }}</span></label>
              @endforeach
            </div>
          </fieldset>

          <fieldset>
            <legend><span>6</span> {{ $adaAkun ? 'Akun' : 'Buat akun untuk masuk nanti' }}</legend>
            @if($adaAkun)
              <p class="hint">Kamu masuk sebagai <b>{{ auth()->user()->name }}</b>. Data ini akan tersimpan di akunmu.</p>
            @else
              <p class="hint">Email & password ini dipakai untuk masuk dan melihat datamu. Kamu hanya bisa melihat data yang kamu isi sendiri.</p>
              <div class="row g-2 g-md-3">
                <div class="col-12 f">
                  <label for="r-email">Email <i>*</i></label>
                  <input id="r-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="@error('email') bad @enderror">
                  @error('email')<small class="err">{{ $message }}</small>@enderror
                </div>
                <div class="col-12 col-md-6 f">
                  <label for="r-password">Password <i>*</i> <em>(min. 8 karakter)</em></label>
                  <input id="r-password" type="password" name="password" required minlength="8" autocomplete="new-password" class="@error('password') bad @enderror">
                  @error('password')<small class="err">{{ $message }}</small>@enderror
                </div>
                <div class="col-12 col-md-6 f">
                  <label for="r-password_confirmation">Ulangi password <i>*</i></label>
                  <input id="r-password_confirmation" type="password" name="password_confirmation" required minlength="8" autocomplete="new-password">
                </div>
              </div>
            @endif
          </fieldset>

          <div class="consent">
            <label class="opt"><input type="checkbox" name="setuju_data" value="1" required @checked(old('setuju_data'))>
              <span>Saya menyetujui data yang saya isi dikumpulkan, disimpan, dan diolah oleh Komite Ekonomi Kreatif Kabupaten Badung untuk keperluan kurasi, koordinasi, dan kajian ekonomi kreatif, sesuai UU No. 27 Tahun 2022 tentang Pelindungan Data Pribadi. <i>*</i></span></label>
            @error('setuju_data')<small class="err">{{ $message }}</small>@enderror
            <label class="opt"><input type="checkbox" name="tampilkan_kontak" value="1" @checked(old('tampilkan_kontak'))>
              <span>Izinkan nomor WhatsApp saya tampil di website (tombol WhatsApp pada kartu usaha). Jika tidak dicentang, nomor tidak dipublikasikan.</span></label>
          </div>

          <div class="reg-actions">
            <button type="submit" class="btn btn-forest" data-submit><i class="bi bi-send"></i>&nbsp; Kirim pendaftaran</button>
            @guest<span>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></span>@endguest
          </div>
        </form>
      @endif
    </div>
  </div>
</div>
