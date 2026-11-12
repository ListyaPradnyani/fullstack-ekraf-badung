<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Ekraf Badung') · Ekraf Badung</title>
  <meta name="theme-color" content="#0b4a38">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght,SOFT@9..144,400..700,100&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
  <nav class="navbar navbar-expand-lg app-nav">
    <div class="container">
      <a class="navbar-brand" href="{{ route('home') }}" aria-label="Beranda Ekraf Badung">
        <img src="{{ asset('assets/images/logo-ekraf-badung.jpg') }}" alt="Logo Ekraf Badung">
      </a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-label="Menu">
        <i class="bi bi-list text-white fs-2"></i>
      </button>
      <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Website</a></li>
          @auth
            @if(auth()->user()->isAdmin())
              <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.umkm.*') ? 'active' : '' }}" href="{{ route('admin.umkm.index') }}">Data UMKM</a></li>
              <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.agenda.*') ? 'active' : '' }}" href="{{ route('admin.agenda.index') }}">Agenda</a></li>
              <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">Pengguna</a></li>
            @else
              <li class="nav-item"><a class="nav-link {{ request()->routeIs('umkm.index') ? 'active' : '' }}" href="{{ route('umkm.index') }}">UMKM Saya</a></li>
              <li class="nav-item"><a class="nav-link {{ request()->routeIs('umkm.create') ? 'active' : '' }}" href="{{ route('umkm.create') }}">Daftarkan UMKM</a></li>
            @endif
          @endauth
        </ul>
        <div class="d-flex align-items-center gap-2 text-white">
          @auth
            <span class="small"><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
              <span class="badge text-bg-warning">{{ auth()->user()->role }}</span></span>
            <form method="POST" action="{{ route('logout') }}">@csrf
              <button class="btn btn-sm btn-outline-light">Keluar</button>
            </form>
          @else
            <a class="btn btn-sm btn-outline-light" href="{{ route('login') }}">Masuk</a>
            <a class="btn btn-sm btn-sun" href="{{ route('register') }}">Daftar</a>
          @endauth
        </div>
      </div>
    </div>
  </nav>

  @yield('head')

  <main class="pb-5">
    <div class="container mt-3">
      @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('ok') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button></div>
      @endif
      @if($errors->any() && ! View::hasSection('inline-errors'))
        <div class="alert alert-danger" role="alert">
          <b>Ada isian yang perlu diperbaiki:</b>
          <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
      @endif
    </div>
    @yield('content')
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
