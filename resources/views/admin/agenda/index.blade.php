@extends('layouts.app')
@section('title', 'Agenda Kalender')
@section('inline-errors', '1')
@section('head')
<div class="page-head"><div class="container">
  <h1>Agenda kalender</h1>
  <p class="text-muted mb-0">Agenda di sini langsung tampil di bagian “Calendar Ekraf” website utama. Hanya admin yang bisa mengubahnya.</p>
</div></div>
@endsection
@section('content')
<div class="container">
  <div class="card mb-4"><div class="card-body p-4">
    <h2 class="h4 mb-3">Tambah agenda</h2>
    @include('admin.agenda._form', ['action' => route('admin.agenda.store'), 'method' => 'POST'])
  </div></div>

  <form method="GET" class="d-flex flex-wrap gap-2 mb-3 align-items-center">
    <label for="bulan" class="fw-semibold">Bulan</label>
    <input type="month" id="bulan" name="bulan" value="{{ $bulan }}" class="form-control w-auto">
    <button class="btn btn-primary btn-sm">Tampilkan</button>
    @if($bulan)<a href="{{ route('admin.agenda.index') }}" class="btn btn-outline-secondary btn-sm">Semua</a>@endif
  </form>

  <div class="table-wrap"><div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead class="table-light"><tr><th>Tanggal</th><th>Kegiatan</th><th>Jam</th><th>Lokasi</th><th></th></tr></thead>
      <tbody>
      @forelse($agendas as $a)
        <tr>
          <td class="text-nowrap"><b>{{ $a->tanggal->translatedFormat('d M Y') }}</b></td>
          <td>{{ $a->nama }}</td>
          <td>{{ $a->jam ?: '—' }}</td>
          <td>{{ $a->lokasi ?: '—' }}</td>
          <td class="text-end text-nowrap">
            <a href="{{ route('admin.agenda.edit', $a) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Edit</a>
            <form method="POST" action="{{ route('admin.agenda.destroy', $a) }}" class="d-inline" onsubmit="return confirm('Hapus agenda ini?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center text-muted py-5">Belum ada agenda.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div></div>
  <div class="mt-3">{{ $agendas->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
