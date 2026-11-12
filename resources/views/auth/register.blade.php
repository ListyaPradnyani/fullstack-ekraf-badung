@extends('layouts.app')
@section('title', 'Daftar')
@section('inline-errors', '1')
@section('content')
<div class="auth-wrap">
  <div class="card auth-card"><div class="card-body p-4 p-md-5">
    <div class="text-center mb-4">
      <img src="{{ asset('assets/images/logo-ekraf-badung.jpg') }}" alt="Ekraf Badung">
      <h1 class="h3 mt-3 mb-1">Buat akun</h1>
      <p class="text-muted mb-0">Daftarkan UMKM kreatifmu ke direktori Ekraf Badung.</p>
    </div>
    <form method="POST" action="{{ url('/daftar') }}" novalidate>
      @csrf
      <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required autofocus autocomplete="name">
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autocomplete="username">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password <small class="text-muted fw-normal">(min. 8 karakter)</small></label>
        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-4">
        <label for="password_confirmation" class="form-label">Ulangi password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
      </div>
      <button class="btn btn-primary w-100">Daftar</button>
    </form>
    <p class="text-center mt-4 mb-0 small">Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold">Masuk</a></p>
  </div></div>
</div>
@endsection
