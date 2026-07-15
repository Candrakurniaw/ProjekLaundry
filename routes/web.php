<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan');
Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
Route::put('/pelanggan/{pelanggan}', [PelangganController::class, 'update'])->name('pelanggan.update');
Route::delete('/pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
Route::post('/pengaturan/layanan', [PengaturanController::class, 'storeLayanan'])->name('pengaturan.layanan.store');
Route::put('/pengaturan/layanan/{layanan}', [PengaturanController::class, 'updateLayanan'])->name('pengaturan.layanan.update');
Route::delete('/pengaturan/layanan/{layanan}', [PengaturanController::class, 'destroyLayanan'])->name('pengaturan.layanan.destroy');
