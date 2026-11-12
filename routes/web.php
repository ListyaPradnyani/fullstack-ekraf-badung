<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PublicUmkmController;
use App\Http\Controllers\UmkmController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');

// Form pendaftaran UMKM di landing page (tamu otomatis dibuatkan akun)
Route::post('/umkm/daftar', [PublicUmkmController::class, 'store'])->middleware('throttle:20,1')->name('umkm.daftar');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register'])->middleware('throttle:10,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', fn () => redirect()->route(auth()->user()->isAdmin() ? 'admin.dashboard' : 'umkm.index'))
        ->name('dashboard');

    // Form UMKM Directory (pelaku usaha: data sendiri, admin: semua)
    Route::resource('umkm', UmkmController::class)->except(['show']);
    Route::get('/berkas/{file}', [FileController::class, 'show'])->name('files.show');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/umkm', [AdminController::class, 'umkm'])->name('umkm.index');
        Route::get('/umkm/export', [AdminController::class, 'export'])->name('umkm.export');
        Route::post('/umkm/bulk', [AdminController::class, 'bulk'])->name('umkm.bulk');
        Route::resource('agenda', AgendaController::class)->except(['show', 'create']);
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::patch('/users/{user}', [AdminController::class, 'updateRole'])->name('users.role');
    });
});
