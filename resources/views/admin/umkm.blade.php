@extends('layouts.app')
@section('title', 'Data UMKM')
@section('head')
<div class="page-head"><div class="container d-flex flex-wrap justify-content-between align-items-center gap-3">
  <div><h1>Data UMKM</h1><p class="text-muted mb-0">{{ $umkms->total() }} data. Centang beberapa baris untuk kurasi sekaligus.</p></div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.umkm.export', request()->query()) }}" class="btn btn-outline-primary"><i class="bi bi-download"></i> Ekspor CSV</a>
    <a href="{{ route('umkm.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>
  </div>
</div></div>
@endsection
@section('content')
<div class="container">
  <form method="GET" class="row g-2 mb-3">
    <div class="col-md-4"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari brand, pemilik, atau no. WA…"></div>
    <div class="col-md-3"><select name="kecamatan" class="form-select"><option value="">Semua kecamatan</option>
      @foreach(config('ekraf.kecamatan') as $k)<option @selected(request('kecamatan') === $k)>{{ $k }}</option>@endforeach</select></div>
    <div class="col-md-3"><select name="status" class="form-select"><option value="">Semua status</option>
      @foreach(\App\Models\Umkm::STATUSES as $k => $l)<option value="{{ $k }}" @selected(request('status') === $k)>{{ $l }}</option>@endforeach</select></div>
    <div class="col-md-2"><button class="btn btn-primary w-100">Filter</button></div>
  </form>

  <form method="POST" action="{{ route('admin.umkm.bulk') }}" id="bulk">
    @csrf
    <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
      <select name="aksi" class="form-select w-auto" required>
        <option value="">Aksi untuk yang dipilih…</option>
        <option value="approved">Setujui (tampil di website)</option>
        <option value="rejected">Tolak</option>
        <option value="pending">Kembalikan ke menunggu</option>
        <option value="hapus">Hapus</option>
      </select>
      <button class="btn btn-sun" onclick="return this.form.aksi.value !== 'hapus' || confirm('Hapus data terpilih beserta berkasnya?')">Terapkan</button>
    </div>

    <div class="table-wrap"><div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light"><tr>
          <th style="width:36px"><input type="checkbox" class="form-check-input" id="all" aria-label="Pilih semua"></th>
          <th>Foto</th><th>Brand</th><th>Pemilik</th><th>Kecamatan</th><th>No. WA</th><th>Status</th><th></th>
        </tr></thead>
        <tbody>
        @forelse($umkms as $u)
          <tr>
            <td><input type="checkbox" class="form-check-input row-cb" name="ids[]" value="{{ $u->id }}"></td>
            <td>@php($f = $u->filesOf('produk')->map->imageUrl()->filter()->first())
              @if($f)<img src="{{ $f }}" class="thumb" style="width:56px;height:56px;border-radius:10px" alt="" loading="lazy" onerror="this.style.visibility='hidden'">@else<span class="text-muted small">—</span>@endif</td>
            <td><b>{{ $u->nama_brand }}</b><div class="small text-muted">{{ $u->kategori ?: 'Subsektor belum diisi' }}</div></td>
            <td>{{ $u->nama_pelaku }}</td>
            <td>{{ $u->kecamatan ?: '—' }}</td>
            <td>{{ $u->no_wa ?: '—' }}</td>
            <td><span class="st st-{{ $u->status }}">{{ $u->statusLabel() }}</span></td>
            <td class="text-end text-nowrap">
              <a href="{{ route('umkm.edit', $u) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Edit</a>
              <button type="submit" form="del-{{ $u->id }}" class="btn btn-sm btn-outline-danger" aria-label="Hapus {{ $u->nama_brand }}"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
        @empty
          <tr><td colspan="8" class="text-center text-muted py-5">Tidak ada data.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div></div>
  </form>
  @foreach($umkms as $u)
    <form id="del-{{ $u->id }}" method="POST" action="{{ route('umkm.destroy', $u) }}" onsubmit="return confirm('Hapus {{ addslashes($u->nama_brand) }} beserta semua berkasnya?')">@csrf @method('DELETE')</form>
  @endforeach
  <div class="mt-3">{{ $umkms->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
@push('scripts')
<script>
  document.getElementById('all')?.addEventListener('change', e =>
    document.querySelectorAll('.row-cb').forEach(c => c.checked = e.target.checked));
</script>
@endpush
