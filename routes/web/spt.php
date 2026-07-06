<?php

use App\Http\Controllers\Spt\SptController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    
    // 1. Amankan fitur Create, Store, Edit, Update, Destroy dengan middleware pembuat_spt
    Route::middleware(['pembuat_spt'])->group(function () {
        Route::get('user/spt/create', [SptController::class, 'create'])->name('user.spt.create');
        Route::post('user/spt', [SptController::class, 'store'])->name('user.spt.store');
        Route::get('user/spt/{spt}/edit', [SptController::class, 'edit'])->name('user.spt.edit');
        Route::put('user/spt/{spt}', [SptController::class, 'update'])->name('user.spt.update');
        Route::delete('user/spt/{spt}', [SptController::class, 'destroy'])->name('user.spt.destroy');
    });

    // 2. Semua user yang sudah login bisa melihat daftar (index) dan detail (show) SPT
    Route::get('user/spt', [SptController::class, 'index'])->name('user.spt.index');
    Route::get('user/spt/{spt}', [SptController::class, 'show'])->name('user.spt.show');
});