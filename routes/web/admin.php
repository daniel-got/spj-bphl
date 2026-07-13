<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KelolaPegawaiController;
use App\Http\Controllers\Admin\UangHarianController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Route Admin — Khusus role 'admin'
|--------------------------------------------------------------------------
| Semua route di sini dilindungi oleh dua middleware:
|   1. 'auth'       → user wajib sudah login
|   2. 'role:admin' → user wajib memiliki role admin (via CheckRole middleware)
|
| Penamaan menggunakan prefix 'admin.' agar bisa dipanggil:
|   route('admin.dashboard')
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Kelola Pegawai
        Route::get('/kelolaPegawai', [KelolaPegawaiController::class, 'index'])->name('kelolaPegawai');
        Route::post('/kelolaPegawai', [KelolaPegawaiController::class, 'store'])->name('kelolaPegawai.store');
        Route::put('/kelolaPegawai/{pegawai}', [KelolaPegawaiController::class, 'update'])->name('kelolaPegawai.update');
        Route::delete('/kelolaPegawai/{pegawai}', [KelolaPegawaiController::class, 'destroy'])->name('kelolaPegawai.destroy');
        Route::post('/kelolaPegawai/import', [KelolaPegawaiController::class, 'import'])->name('kelolaPegawai.import');
        Route::post('/kelolaPegawai/validate-import', [KelolaPegawaiController::class, 'validateImport'])->name('kelolaPegawai.validateImport');

        // Master Uang Harian
        Route::get('/uang-harian', [UangHarianController::class, 'index'])->name('uang-harian.index');
        Route::post('/uang-harian', [UangHarianController::class, 'store'])->name('uang-harian.store');
        Route::put('/uang-harian/{uangHarian}', [UangHarianController::class, 'update'])->name('uang-harian.update');
        Route::delete('/uang-harian/{uangHarian}', [UangHarianController::class, 'destroy'])->name('uang-harian.destroy');
        Route::post('/uang-harian/import', [UangHarianController::class, 'import'])->name('uang-harian.import');
        Route::post('/uang-harian/validate-import', [UangHarianController::class, 'validateImport'])->name('uang-harian.validateImport');

        // Kelola PPK
        Route::get('/ppk', function () {
            return view('pages.admin.ppk');
        })->name('ppk');
    });
