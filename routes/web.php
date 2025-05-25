<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/', [AuthController::class, 'loginForm'])->name('login');
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // Login routes with role selection
    Route::get('/login/admin', [AuthController::class, 'adminLoginForm'])->name('login.admin');
    Route::get('/login/siswa', [AuthController::class, 'siswaLoginForm'])->name('login.siswa');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Buku Routes - available to all authenticated users
    Route::resource('buku', BukuController::class);

    // Peminjaman Routes - for both roles
    Route::resource('peminjaman', PeminjamanController::class);

    // Admin Only Routes
    Route::middleware('admin')->group(function () {
        // Pengunjung Routes
        Route::resource('pengunjung', PengunjungController::class);

        // Petugas Routes
        Route::resource('petugas', PetugasController::class);

        // Admin Peminjaman Routes
        Route::get('/admin/peminjaman', [PeminjamanController::class, 'adminIndex'])
            ->name('peminjaman.admin.index');
        Route::get('/admin/peminjaman/create', [PeminjamanController::class, 'adminCreate'])
            ->name('peminjaman.admin.create');

        // PDF Generation
        Route::get('/admin/peminjaman/pdf', [PeminjamanController::class, 'generatePdf'])
            ->name('peminjaman.pdf');
    });
});
