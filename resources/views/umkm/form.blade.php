@extends('layouts.app')
@php
  $edit = $umkm->exists;
  $admin = auth()->user()->isAdmin();
  $v = fn ($k) => old($k, $umkm->{$k});
  $legalitasDipilih = old('legalitas', $umkm->legalitas ?? []);
  $kesiapanDipilih = old('kesiapan', $umkm->kesiapan ?? []);
  $ktp = $edit ? $umkm->filesOf('ktp') : collect();
  $nib = $edit ? $umkm->filesOf('nib') : collect();
  $produk = $edit ? $umkm->filesOf('produk') : collect();
  $wajib = ! $edit && ! $admin;
@endphp
@section('title', $edit ? 'Edit UMKM' : 'Daftarkan UMKM')
@section('head')
<div class="page-head"><div class="container">
  <h1>{{ $edit ? 'Edit data UMKM' : 'Daftarkan UMKM' }}</h1>
  <p class="text-muted mb-0">Struktur UMKM Directory Ekraf Badung. Isian bertanda <span class="text-danger">*</span> wajib diisi.</p>
</div></div>
@endsection

@section('content')
<div class="container" style="max-width: 920px">
  @if($edit && ! $admin)
    <div class="alert alert-info"><span class="st st-{{ $umkm->status }}">{{ $umkm->statusLabel() }}</span>
      @if($umkm->catatan_admin) &nbsp;<b>Catatan admin:</b> {{ $umkm->catatan_admin }} @endif
      <div class="small mt-1">Setelah kamu menyimpan perubahan, data ditinjau ulang oleh admin sebelum tampil di website.</div>
    </div>
  @endif

  <form method="POST" enctype="multipart/form-data" novalidate
        action="{{ $edit ? route('umkm.update', $umkm) : route('umkm.store') }}">
    @csrf
    @if($edit) @method('PUT') @endif

    {{-- 1. Identitas usaha --}}
    <div class="card mb-4"><div class="card-body p-4">
      <h2 class="card-title-sec"><span class="num">1</span> Identitas usaha</h2>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="nama_pelaku" class="form-label req">Nama pelaku usaha</label>
          <input id="nama_pelaku" name="nama_pelaku" value="{{ $v('nama_pelaku') }}" class="form-control @error('nama_pelaku') is-invalid @enderror" required>
          @error('nama_pelaku')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label for="nama_brand" class="form-label req">Nama brand</label>
          <input id="nama_brand" name="nama_brand" value="{{ $v('nama_brand') }}" class="form-control @error('nama_brand') is-invalid @enderror" required>
          @error('nama_brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label for="kecamatan" class="form-label req">Kecamatan</label>
          <select id="kecamatan" name="kecamatan" class="form-select @error('kecamatan') is-invalid @enderror" required>
            <option value="">— Pilih kecamatan di Badung —</option>
            @foreach(config('ekraf.kecamatan') as $k)
              <option value="{{ $k }}" @selected($v('kecamatan') === $k)>{{ $k }}</option>
            @endforeach
          </select>
          @error('kecamatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label for="kategori" class="form-label">Subsektor ekraf</label>
          <select id="kategori" name="kategori" class="form-select @error('kategori') is-invalid @enderror">
            <option value="">— Pilih subsektor —</option>
            @foreach(config('ekraf.subsektor') as $s)
              <option value="{{ $s['name'] }}" @selected($v('kategori') === $s['name'])>{{ $s['name'] }}</option>
            @endforeach
          </select>
          @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label for="no_wa" class="form-label req">No. WA aktif</label>
          <input id="no_wa" name="no_wa" inputmode="tel" placeholder="08xxxxxxxxxx" value="{{ $v('no_wa') }}" class="form-control @error('no_wa') is-invalid @enderror" required>
          @error('no_wa')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label for="jam_buka" class="form-label">Jam buka <small class="text-muted fw-normal">(opsional)</small></label>
          <input id="jam_buka" name="jam_buka" placeholder="Senin – Sabtu, 09.00 – 17.00 WITA" value="{{ $v('jam_buka') }}" class="form-control @error('jam_buka') is-invalid @enderror">
          @error('jam_buka')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
          <label for="alamat" class="form-label req">Alamat usaha</label>
          <textarea id="alamat" name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror" required>{{ $v('alamat') }}</textarea>
          @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
          <label for="media_sosial" class="form-label">Media sosial yang dimiliki</label>
          <textarea id="media_sosial" name="media_sosial" rows="2" placeholder="Contoh: Instagram: @namabrand, TikTok: namabrand, Shopee: namatoko" class="form-control @error('media_sosial') is-invalid @enderror">{{ $v('media_sosial') }}</textarea>
          @error('media_sosial')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>
    </div></div>

    {{-- 2. Tentang usaha --}}
    <div class="card mb-4"><div class="card-body p-4">
      <h2 class="card-title-sec"><span class="num">2</span> Tentang usaha</h2>
      <div class="mb-3">
        <label for="produk" class="form-label req">Produk yang diajukan</label>
        <textarea id="produk" name="produk" rows="3" placeholder="Satu produk per baris, mis. Kain endek" class="form-control @error('produk') is-invalid @enderror" required>{{ $v('produk') }}</textarea>
        <div class="form-text">Tiap baris tampil sebagai label produk di halaman website.</div>
        @error('produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div>
        <label for="cerita_usaha" class="form-label">Ceritakan tentang usaha</label>
        <textarea id="cerita_usaha" name="cerita_usaha" rows="5" class="form-control @error('cerita_usaha') is-invalid @enderror">{{ $v('cerita_usaha') }}</textarea>
        @error('cerita_usaha')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
    </div></div>

    {{-- 3. Dokumen & foto --}}
    <div class="card mb-4"><div class="card-body p-4">
      <h2 class="card-title-sec"><span class="num">3</span> Foto & dokumen</h2>
      <p class="text-muted small">Format JPG/PNG (KTP & NIB boleh PDF). KTP, NIB, dan legalitas hanya bisa dilihat kamu dan admin, tidak ditampilkan di website.</p>
      <div class="row g-4">
        @foreach([['foto_ktp', 'Foto KTP', $ktp], ['foto_nib', 'Foto NIB', $nib]] as [$field, $label, $ada])
          <div class="col-md-6">
            <label for="{{ $field }}" class="form-label {{ $wajib ? 'req' : '' }}">{{ $label }}</label>
            @foreach($ada as $f)
              <div class="mb-2 d-flex flex-wrap gap-2 align-items-center">
                @if($f->path && $f->isImage())<img src="{{ $f->imageUrl() }}" class="thumb" alt="">@endif
                <a href="{{ $f->openUrl() }}" target="_blank" rel="noopener" class="file-pill"><i class="bi bi-paperclip"></i> {{ $f->nama_asli ?: 'Berkas tersimpan' }}{{ $f->path ? '' : ' (tautan Drive)' }}</a>
                <label class="small text-danger"><input type="checkbox" name="hapus_file[]" value="{{ $f->id }}" class="form-check-input"> hapus</label>
              </div>
            @endforeach
            <input id="{{ $field }}" type="file" name="{{ $field }}" accept=".jpg,.jpeg,.png,.pdf" class="form-control @error($field) is-invalid @enderror">
            @if($ada->isNotEmpty())<div class="form-text">Unggah berkas baru untuk menggantikan yang lama.</div>@endif
            @error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        @endforeach

        <div class="col-12">
          <label for="foto_produk" class="form-label {{ $wajib ? 'req' : '' }}">Foto produk <small class="text-muted fw-normal">(1–5 foto, produk & kemasan)</small></label>
          @if($produk->isNotEmpty())
            <div class="d-flex flex-wrap gap-3 mb-2">
              @foreach($produk as $f)
                <div class="thumb-box">
                  @if($f->imageUrl())<a href="{{ $f->openUrl() }}" target="_blank" rel="noopener"><img src="{{ $f->imageUrl() }}" class="thumb" alt="Foto produk" loading="lazy" onerror="this.style.visibility='hidden'"></a>
                  @else<a href="{{ $f->openUrl() }}" target="_blank" rel="noopener" class="thumb d-flex align-items-center justify-content-center"><i class="bi bi-box-arrow-up-right"></i></a>@endif
                  <label class="text-danger"><input type="checkbox" name="hapus_file[]" value="{{ $f->id }}" class="form-check-input"> hapus</label>
                </div>
              @endforeach
            </div>
          @endif
          <input id="foto_produk" type="file" name="foto_produk[]" multiple accept=".jpg,.jpeg,.png,.webp" class="form-control @error('foto_produk') is-invalid @enderror @error('foto_produk.*') is-invalid @enderror">
          @error('foto_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
          @foreach($errors->get('foto_produk.*') as $msgs)@foreach($msgs as $m)<div class="invalid-feedback d-block">{{ $m }}</div>@endforeach @endforeach
        </div>
      </div>
    </div></div>

    {{-- 4. Legalitas lain --}}
    <div class="card mb-4"><div class="card-body p-4">
      <h2 class="card-title-sec"><span class="num">4</span> Legalitas usaha lain yang dimiliki</h2>
      <p class="text-muted small">Centang yang dimiliki dan unggah fotonya (HKI, HACCP, Halal, dll).</p>
      <div class="row g-3">
        @foreach(config('ekraf.legalitas') as $lg)
          @php($ada = $edit ? $umkm->filesOf('legalitas', $lg) : collect())
          <div class="col-md-6"><div class="legal-box">
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" name="legalitas[]" value="{{ $lg }}" id="lg-{{ $lg }}" @checked(in_array($lg, $legalitasDipilih))>
              <label class="form-check-label fw-bold" for="lg-{{ $lg }}">{{ $lg === 'Lainnya' ? 'Legalitas lainnya' : $lg }}</label>
            </div>
            @foreach($ada as $f)
              <div class="mb-2 d-flex flex-wrap gap-2 align-items-center">
                @if($f->path && $f->isImage())<img src="{{ $f->imageUrl() }}" class="thumb" style="width:56px;height:56px" alt="">@endif
                <a href="{{ $f->openUrl() }}" target="_blank" rel="noopener" class="file-pill"><i class="bi bi-paperclip"></i> {{ $f->nama_asli ?: 'Berkas' }}</a>
                <label class="small text-danger"><input type="checkbox" name="hapus_file[]" value="{{ $f->id }}" class="form-check-input"> hapus</label>
              </div>
            @endforeach
            <input type="file" name="foto_legalitas[{{ $lg }}]" accept=".jpg,.jpeg,.png,.pdf" class="form-control form-control-sm @error('foto_legalitas.'.$lg) is-invalid @enderror" aria-label="Foto {{ $lg }}">
            @error('foto_legalitas.'.$lg)<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div></div>
        @endforeach
      </div>
    </div></div>

    {{-- 5. Kesiapan stand --}}
    <div class="card mb-4"><div class="card-body p-4">
      <h2 class="card-title-sec"><span class="num">5</span> Kesiapan stand & komitmen</h2>
      @foreach(config('ekraf.kesiapan') as $i => $k)
        <div class="form-check mb-2">
          <input class="form-check-input" type="checkbox" name="kesiapan[]" value="{{ $k }}" id="ks-{{ $i }}" @checked(in_array($k, $kesiapanDipilih))>
          <label class="form-check-label" for="ks-{{ $i }}">{{ $k }}</label>
        </div>
      @endforeach
    </div></div>

    {{-- 6. Persetujuan --}}
    <div class="card mb-4"><div class="card-body p-4">
      <h2 class="card-title-sec"><span class="num">6</span> Persetujuan</h2>
      <div class="form-check mb-3">
        <input class="form-check-input @error('setuju_data') is-invalid @enderror" type="checkbox" name="setuju_data" id="setuju_data" value="1" @checked(old('setuju_data', $umkm->setuju_data))>
        <label class="form-check-label" for="setuju_data">Saya menyetujui data yang saya isi dikumpulkan, disimpan, dan diolah oleh Komite Ekonomi Kreatif Kabupaten Badung dan Dekranasda untuk keperluan kurasi peserta, koordinasi dengan perangkat daerah terkait, dan kajian ekonomi kreatif, sesuai UU No. 27 Tahun 2022 tentang Pelindungan Data Pribadi. <span class="text-danger">*</span></label>
        @error('setuju_data')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="tampilkan_kontak" id="tampilkan_kontak" value="1" @checked(old('tampilkan_kontak', $umkm->tampilkan_kontak))>
        <label class="form-check-label" for="tampilkan_kontak">Izinkan nomor WhatsApp saya tampil di halaman website (tombol WhatsApp). Jika tidak dicentang, nomor tidak dipublikasikan.</label>
      </div>
    </div></div>

    @if($admin)
      <div class="card mb-4 border border-warning"><div class="card-body p-4">
        <h2 class="card-title-sec"><span class="num"><i class="bi bi-shield-check"></i></span> Kurasi admin</h2>
        <div class="row g-3">
          <div class="col-md-4">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-select">
              @foreach(\App\Models\Umkm::STATUSES as $k => $label)
                <option value="{{ $k }}" @selected(old('status', $umkm->status ?: 'pending') === $k)>{{ $label }}</option>
              @endforeach
            </select>
            <div class="form-text">Hanya “Disetujui” yang tampil di website.</div>
          </div>
          <div class="col-md-8">
            <label for="catatan_admin" class="form-label">Catatan untuk pelaku usaha</label>
            <textarea id="catatan_admin" name="catatan_admin" rows="2" class="form-control">{{ old('catatan_admin', $umkm->catatan_admin) }}</textarea>
          </div>
        </div>
      </div></div>
    @endif

    <div class="d-flex gap-2 justify-content-end">
      <a href="{{ $admin ? route('admin.umkm.index') : route('umkm.index') }}" class="btn btn-outline-secondary">Batal</a>
      <button class="btn btn-primary"><i class="bi bi-check2-circle"></i> {{ $edit ? 'Simpan perubahan' : 'Kirim pendaftaran' }}</button>
    </div>
  </form>
</div>
@endsection
