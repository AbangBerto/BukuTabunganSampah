<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Jalur Publik (Tanpa Login)
Route::get('/', [PublicController::class, 'getHome'])->name('public.index');
Route::get('/warga/{id}', [PublicController::class, 'getHistory'])->name('public.history');

// Jalur Autentikasi Admin
Route::get('/login', [AuthController::class, 'getLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post')->middleware('guest');
Route::post('/logout', [AuthController::class, 'postLogout'])->name('logout');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login')->middleware('guest');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->middleware('guest');

// Jalur Panel Admin (Wajib Login)
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'getDashboard'])->name('admin.dashboard');
    Route::get('/bersihkan-cache', [AdminController::class, 'getClearCache'])->name('admin.clearCache');
    
    Route::post('/kk', [AdminController::class, 'postKK'])->name('admin.storeKK');
    Route::post('/transaksi', [AdminController::class, 'postTransaksi'])->name('admin.storeTransaksi');
    Route::post('/tarik-uang', [AdminController::class, 'postTarikUang'])->name('admin.storeTarikUang');
});