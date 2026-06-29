<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KelolaPegawaiController;

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
    });
