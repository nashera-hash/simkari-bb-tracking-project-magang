<?php

use App\Http\Controllers\RiwayatLokasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangBuktiController;
use App\Http\Controllers\PerkaraController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\RakController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('/dashboard'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('master')->group(function () {
        Route::resource('gudang', GudangController::class)->except('show');
        Route::resource('rak', RakController::class)->except('show');
    });

    Route::resource('perkara', PerkaraController::class)->except('show');
    Route::resource('barang-bukti', BarangBuktiController::class);
    Route::get('riwayat-lokasi', [RiwayatLokasiController::class, 'index'])->name('riwayat-lokasi.index');
    Route::get('barang-bukti/{barang_bukti}/pindah', [BarangBuktiController::class, 'pindahForm'])->name('barang-bukti.pindah');
    Route::post('barang-bukti/{barang_bukti}/pindah', [BarangBuktiController::class, 'pindahSimpan']);
});