@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('head')
<div class="page-head"><div class="container"><h1>Dashboard admin</h1><p class="text-muted mb-0">Ringkasan kurasi UMKM Directory.</p></div></div>
@endsection
@section('content')
<div class="container">
  <div class="row g-3 mb-4">
    @foreach([['Total UMKM', $stat['total'], 'var(--ink)'], ['Menunggu kurasi', $stat['pending'], '#8a5a00'], ['Disetujui', $stat['approved'], '#14673d'], ['Ditolak', $stat['rejected'], '#a1281c'], ['Akun pelaku usaha', $stat['users'], 'var(--leaf)']] as [$l, $n, $c])
      <div class="col-6 col-lg"><div class="stat"><b style="color:{{ $c }}">{{ $n }}</b><span>{{ $l }}</span></div></div>
    @endforeach
  </div>
  <div class="row g-4">
    <div class="col-lg-7">
      <div class="card"><div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="h4 mb-0">Menunggu kurasi</h2>
          <a href="{{ route('admin.umkm.index', ['status' => 'pending']) }}" class="small fw-bold">Lihat semua</a>
        </div>
        @forelse($terbaru as $u)
          <div class="d-flex justify-content-between align-items-center py-2 border-top">
            <div><b>{{ $u->nama_brand }}</b><div class="small text-muted">{{ $u->nama_pelaku }} · {{ $u->kecamatan ?: '—' }}</div></div>
            <a href="{{ route('umkm.edit', $u) }}" class="btn btn-sm btn-outline-primary">Tinjau</a>
          </div>
        @empty
          <p class="text-muted mb-0">Tidak ada data yang menunggu. 🎉</p>
        @endforelse
      </div></div>
    </div>
    <div class="col-lg-5">
      <div class="card"><div class="card-body p-4">
        <h2 class="h4 mb-3">UMKM per kecamatan</h2>
        @php($maks = max(1, $perKecamatan->max() ?? 1))
        @foreach(config('ekraf.kecamatan') as $k)
          @php($n = $perKecamatan[$k] ?? 0)
          <div class="mb-2">
            <div class="d-flex justify-content-between small"><span>{{ $k }}</span><b>{{ $n }}</b></div>
            <div class="progress" style="height:8px"><div class="progress-bar" style="width:{{ $n / $maks * 100 }}%;background:var(--leaf)"></div></div>
          </div>
        @endforeach
      </div></div>
    </div>
  </div>
</div>
@endsection
