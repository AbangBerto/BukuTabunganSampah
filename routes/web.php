<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;

// ==========================================
// 1. Jalur Publik (Warga Cek Saldo Langsung)
// ==========================================
Route::get('/', [PublicController::class, 'index'])->name('public.index');

Route::post('/cek-saldo', [PublicController::class, 'checkSaldo'])->name('public.checkSaldo');

// Rute ini yang bertugas menampilkan halaman Saldo & Riwayat (Buku Tabungan)
Route::get('/warga/{id}/riwayat', [PublicController::class, 'getHistory'])->name('public.history');


// ==========================================
// 2. Jalur Autentikasi (Admin Login)
// ==========================================
Route::get('/login', [AuthController::class, 'getLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post')->middleware('guest');
Route::post('/logout', [AuthController::class, 'postLogout'])->name('logout');

// Rute Google Login (Opsional, jika Admin menggunakan Google)
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');


// ==========================================
// 3. Jalur Data Warga (Wajib Login Admin)
// ==========================================
// Semua rute di dalam grup ini dikunci, hanya admin yang bisa mengakses
Route::middleware('auth')->group(function () {
    Route::get('/nasabah', [NasabahController::class, 'index'])->name('nasabah.index');
    Route::post('/nasabah', [NasabahController::class, 'store'])->name('nasabah.store');
    Route::get('/nasabah/{id}/edit', [NasabahController::class, 'edit'])->name('nasabah.edit');
    Route::put('/nasabah/{id}', [NasabahController::class, 'update'])->name('nasabah.update');
    Route::delete('/nasabah/{id}', [NasabahController::class, 'destroy'])->name('nasabah.destroy');
});


// ==========================================
// 4. Jalur Panel Admin (Wajib Login)
// ==========================================
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'getDashboard'])->name('admin.dashboard');
    Route::get('/bersihkan-cache', [AdminController::class, 'getClearCache'])->name('admin.clearCache');
    
    Route::post('/transaksi', [AdminController::class, 'postTransaksi'])->name('admin.storeTransaksi');
    Route::post('/tarik-uang', [AdminController::class, 'postTarikUang'])->name('admin.storeTarikUang');
    Route::delete('/transaksi/{id}', [AdminController::class, 'destroyTransaksi'])->name('admin.destroyTransaksi');
    Route::get('/laporan', [AdminController::class, 'getLaporan'])->name('admin.laporan');
    

    Route::prefix('superadmin')->group(function () {
        // Karena sudah pakai prefix, '/' di sini otomatis menjadi '/superadmin'
        Route::get('/', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');
        Route::post('/tambah-admin', [SuperAdminController::class, 'storeAdmin'])->name('superadmin.storeAdmin');
        Route::delete('/hapus-admin/{id}', [SuperAdminController::class, 'destroyAdmin'])->name('superadmin.destroyAdmin');
    });

});