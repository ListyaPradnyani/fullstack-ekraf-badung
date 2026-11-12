@extends('layouts.app')
@section('title', 'Masuk')
@section('inline-errors', '1')
@section('content')
<div class="auth-wrap">
  <div class="card auth-card"><div class="card-body p-4 p-md-5">
    <div class="text-center mb-4">
      <img src="{{ asset('assets/images/logo-ekraf-badung.jpg') }}" alt="Ekraf Badung">
      <h1 class="h3 mt-3 mb-1">Masuk</h1>
      <p class="text-muted mb-0">Kelola data UMKM Directory Ekraf Badung.</p>
    </div>
    <form method="POST" action="{{ url('/login') }}" novalidate>
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus autocomplete="username">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label" for="remember">Ingat saya</label>
      </div>
      <button class="btn btn-primary w-100">Masuk</button>
    </form>
    <p class="text-center mt-4 mb-0 small">Belum punya akun? <a href="{{ route('register') }}" class="fw-bold">Daftar sebagai pelaku usaha</a></p>
  </div></div>
</div>
@endsection
