<?php

use App\Http\Controllers\Spt\SptController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    // Gunakan middleware bawaan asli tim kamu ('pembuat_spt') agar semua SptTest.php kembali lulus hijau
    Route::middleware(['pembuat_spt'])->group(function () {
        Route::get('user/spt/create', [SptController::class, 'create'])->name('user.spt.create');
        Route::post('user/spt', [SptController::class, 'store'])->name('user.spt.store');
        Route::get('user/spt/{spt}/edit', [SptController::class, 'edit'])->name('user.spt.edit');
        Route::put('user/spt/{spt}', [SptController::class, 'update'])->name('user.spt.update');
        Route::delete('user/spt/{spt}', [SptController::class, 'destroy'])->name('user.spt.destroy');
    });

    // Semua user yang sudah login bisa melihat daftar (index) dan detail (show) SPT
    Route::get('user/spt', [SptController::class, 'index'])->name('user.spt.index');
    Route::get('user/spt/{spt}', [SptController::class, 'show'])->name('user.spt.show');

    // =========================================================================
    // TAMBAHKAN BARIS INI: Rute untuk Generate PDF / Print Preview SPT
    // =========================================================================
    Route::get('user/spt/{spt}/generate-pdf', [SptController::class, 'generatePdf'])->name('user.spt.generatePdf');
});
