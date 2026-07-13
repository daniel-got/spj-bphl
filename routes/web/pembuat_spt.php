<?php

use App\Http\Controllers\PembuatSpt\DashboardController;
use App\Http\Controllers\PembuatSpt\KelolaSptController;
use App\Http\Controllers\PembuatSpt\SpjSelesaiController;
use Illuminate\Support\Facades\Route;

// Halaman khusus Pembuat SPT — hanya bisa diakses oleh role pembuat_spt
Route::middleware(['auth', 'pembuat_spt'])->group(function () {
    Route::get('user/pembuat-spt', [DashboardController::class, 'index'])
        ->name('pembuat_spt.index');

    // Kelola SPT Pegawai (Operasional)
    Route::get('user/spt/kelola', [KelolaSptController::class, 'index'])->name('user.spt.kelola');

    // SPJ Selesai (Proses Akhir oleh Staf PPK)
    Route::prefix('user/pembuat-spt/spj-selesai')->name('pembuat_spt.spj_selesai.')->group(function () {
        Route::get('/', [SpjSelesaiController::class, 'index'])->name('index');
        Route::get('/{id}', [SpjSelesaiController::class, 'show'])->name('show');
    });
});
