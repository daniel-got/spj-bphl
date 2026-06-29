<?php

use App\Http\Controllers\SpdController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // Dashboard
        // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Kelola Pegawai
        // Route::get('/kelolaPegawai', [KelolaPegawaiController::class, 'index'])->name('kelolaPegawai');
        // Route::post('/kelolaPegawai', [KelolaPegawaiController::class, 'store'])->name('kelolaPegawai.store');
        // Route::put('/kelolaPegawai/{pegawai}', [KelolaPegawaiController::class, 'update'])->name('kelolaPegawai.update');
        // Route::delete('/kelolaPegawai/{pegawai}', [KelolaPegawaiController::class, 'destroy'])->name('kelolaPegawai.destroy');
        // Route::post('/kelolaPegawai/import', [KelolaPegawaiController::class, 'import'])->name('kelolaPegawai.import');
        // Route::post('/kelolaPegawai/validate-import', [KelolaPegawaiController::class, 'validateImport'])->name('kelolaPegawai.validateImport');
        Route::resource('spd', SpdController::class);
    });
