<?php

use App\Http\Controllers\Verifikasi\VerifikasiSpjController;
use App\Http\Controllers\Verifikasi\VerifikasiSptController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    // Role yang diizinkan untuk verifikasi (Kepala & Verifikator)
    $verifikasiRoles = [
        'verifikator',
        'kepala_balai',
        'kepala_tu',
        'kepala_seksi_pephphl',
        'kepala_seksi_ppphphl',
    ];

    Route::middleware(['role:'.implode(',', $verifikasiRoles)])->prefix('verifikasi')->name('verifikasi.')->group(function () {
        // Verifikasi SPT
        Route::prefix('spt')->name('spt.')->group(function () {
            Route::get('/', [VerifikasiSptController::class, 'index'])->name('index');
            Route::get('/{id}', [VerifikasiSptController::class, 'show'])->name('show');
            Route::put('/{id}/status', [VerifikasiSptController::class, 'updateStatus'])->name('update-status');
        });

        // Verifikasi SPJ
        Route::prefix('spj')->name('spj.')->group(function () {
            Route::get('/', [VerifikasiSpjController::class, 'index'])->name('index');
            Route::get('/{id}', [VerifikasiSpjController::class, 'show'])->name('show');
            Route::put('/{id}/status', [VerifikasiSpjController::class, 'updateStatus'])->name('update-status');
        });
    });
});
