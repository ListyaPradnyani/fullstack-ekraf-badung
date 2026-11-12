@extends('layouts.app')
@section('title', 'UMKM Saya')
@section('head')
<div class="page-head"><div class="container d-flex flex-wrap justify-content-between align-items-center gap-3">
  <div><h1>UMKM saya</h1><p class="text-muted mb-0">Data usaha yang kamu daftarkan. Klik “Edit” kapan saja untuk memperbarui.</p></div>
  <a href="{{ route('umkm.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Daftarkan UMKM</a>
</div></div>
@endsection
@section('content')
<div class="container">
  @forelse($umkms as $u)
    @php($foto = $u->filesOf('produk')->map->imageUrl()->filter()->first())
    <div class="card mb-3"><div class="card-body d-flex flex-wrap gap-3 align-items-center">
      @if($foto)<img src="{{ $foto }}" class="thumb" alt="">@else<div class="thumb d-flex align-items-center justify-content-center"><i class="bi bi-image fs-3 text-muted"></i></div>@endif
      <div class="flex-grow-1">
        <h2 class="h5 mb-1">{{ $u->nama_brand }} <span class="st st-{{ $u->status }} ms-1">{{ $u->statusLabel() }}</span></h2>
        <div class="text-muted small">{{ $u->nama_pelaku }} · {{ $u->kecamatan ?: '—' }} · diajukan {{ optional($u->submitted_at)->translatedFormat('d M Y') ?: '—' }}</div>
        @if($u->catatan_admin)<div class="mt-2 small"><i class="bi bi-chat-left-text"></i> <b>Catatan admin:</b> {{ $u->catatan_admin }}</div>@endif
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('umkm.edit', $u) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Edit</a>
        <form method="POST" action="{{ route('umkm.destroy', $u) }}" onsubmit="return confirm('Hapus data {{ addslashes($u->nama_brand) }}? Tindakan ini tidak bisa dibatalkan.')">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
        </form>
      </div>
    </div></div>
  @empty
    <div class="card"><div class="card-body text-center py-5">
      <i class="bi bi-shop fs-1 text-muted"></i>
      <h2 class="h4 mt-2">Belum ada UMKM</h2>
      <p class="text-muted">Daftarkan usahamu agar bisa tampil di UMKM Directory Ekraf Badung.</p>
      <a href="{{ route('umkm.create') }}" class="btn btn-primary">Daftarkan UMKM</a>
    </div></div>
  @endforelse
</div>
@endsection
