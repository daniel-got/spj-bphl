<?php

use App\Http\Controllers\PembuatSpt\DashboardController;
use Illuminate\Support\Facades\Route;

// Halaman khusus Pembuat SPT — hanya bisa diakses oleh role pembuat_spt
Route::middleware(['auth', 'pembuat_spt'])->group(function () {
    Route::get('user/pembuat-spt', [DashboardController::class, 'index'])
        ->name('pembuat_spt.index');
});
