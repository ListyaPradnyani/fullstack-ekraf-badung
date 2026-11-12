{{-- Dipakai di halaman daftar (tambah) dan halaman edit. Variabel: $agenda, $action, $method --}}
<form method="POST" action="{{ $action }}" class="row g-3 align-items-end">
  @csrf
  @if(($method ?? 'POST') !== 'POST') @method($method) @endif
  <div class="col-md-3">
    <label class="form-label req" for="tanggal-{{ $agenda->id ?? 'baru' }}">Tanggal</label>
    <input type="date" id="tanggal-{{ $agenda->id ?? 'baru' }}" name="tanggal" required
           value="{{ old('tanggal', optional($agenda->tanggal)->format('Y-m-d')) }}" class="form-control @error('tanggal') is-invalid @enderror">
    @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label req" for="nama-{{ $agenda->id ?? 'baru' }}">Nama kegiatan</label>
    <input id="nama-{{ $agenda->id ?? 'baru' }}" name="nama" required value="{{ old('nama', $agenda->nama) }}" class="form-control @error('nama') is-invalid @enderror">
    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-2">
    <label class="form-label" for="jam-{{ $agenda->id ?? 'baru' }}">Jam</label>
    <input id="jam-{{ $agenda->id ?? 'baru' }}" name="jam" placeholder="10.00 WITA" value="{{ old('jam', $agenda->jam) }}" class="form-control @error('jam') is-invalid @enderror">
    @error('jam')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-3">
    <label class="form-label" for="lokasi-{{ $agenda->id ?? 'baru' }}">Lokasi</label>
    <input id="lokasi-{{ $agenda->id ?? 'baru' }}" name="lokasi" value="{{ old('lokasi', $agenda->lokasi) }}" class="form-control @error('lokasi') is-invalid @enderror">
    @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-12 d-flex gap-2 justify-content-end">
    @if($agenda->exists)<a href="{{ route('admin.agenda.index') }}" class="btn btn-outline-secondary">Batal</a>@endif
    <button class="btn btn-primary"><i class="bi bi-{{ $agenda->exists ? 'check2-circle' : 'plus-lg' }}"></i> {{ $agenda->exists ? 'Simpan perubahan' : 'Tambah agenda' }}</button>
  </div>
</form>
