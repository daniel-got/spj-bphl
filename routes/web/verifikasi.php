<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    // Role yang diizinkan untuk verifikasi (Kepala & Verifikator)
    $verifikasiRoles = [
        'verifikator',
        'kepala_balai',
        'kepala_tu',
        'kepala_seksi_pephphl',
        'kepala_seksi_ppphphl'
    ];

    Route::middleware(['role:' . implode(',', $verifikasiRoles)])->prefix('verifikasi')->name('verifikasi.')->group(function () {
        // Verifikasi SPT
        Route::get('/spt', function () {
            return view('pages.verifikasi.spt');
        })->name('spt');

        // Verifikasi SPJ
        Route::get('/spj', function () {
            return view('pages.verifikasi.spj');
        })->name('spj');
    });
});
