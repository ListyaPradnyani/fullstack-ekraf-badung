@extends('layouts.app')
@section('title', 'Pengguna')
@section('head')
<div class="page-head"><div class="container"><h1>Pengguna</h1><p class="text-muted mb-0">Atur siapa yang menjadi admin.</p></div></div>
@endsection
@section('content')
<div class="container">
  <div class="table-wrap"><div class="table-responsive">
    <table class="table mb-0">
      <thead class="table-light"><tr><th>Nama</th><th>Email</th><th>UMKM</th><th>Role</th></tr></thead>
      <tbody>
      @foreach($users as $u)
        <tr>
          <td><b>{{ $u->name }}</b> @if($u->id === auth()->id())<span class="badge text-bg-secondary">kamu</span>@endif</td>
          <td>{{ $u->email }}</td>
          <td>{{ $u->umkms_count }}</td>
          <td>
            <form method="POST" action="{{ route('admin.users.role', $u) }}" class="d-flex gap-2">
              @csrf @method('PATCH')
              <select name="role" class="form-select form-select-sm w-auto" @disabled($u->id === auth()->id())>
                <option value="user" @selected($u->role === 'user')>user</option>
                <option value="admin" @selected($u->role === 'admin')>admin</option>
              </select>
              @if($u->id !== auth()->id())<button class="btn btn-sm btn-outline-primary">Simpan</button>@endif
            </form>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div></div>
</div>
@endsection
