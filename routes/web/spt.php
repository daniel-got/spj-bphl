<?php

use App\Http\Controllers\SptController;
use Illuminate\Support\Facades\Route;

// Menggunakan Route Resource tanpa tambahan ->prefix() atau ->name() di dalam sini
// Ini otomatis membuat URL: 127.0.0.1:8000/user/spt/create
Route::middleware(['auth'])->group(function () {
    // Only pembuat_spt and admin can access create/store/edit/update/destroy
    Route::middleware(['pembuat_spt'])->group(function () {
        Route::get('user/spt/create', [SptController::class, 'create'])->name('user.spt.create');
        Route::post('user/spt', [SptController::class, 'store'])->name('user.spt.store');
        Route::get('user/spt/{spt}/edit', [SptController::class, 'edit'])->name('user.spt.edit');
        Route::put('user/spt/{spt}', [SptController::class, 'update'])->name('user.spt.update');
        Route::delete('user/spt/{spt}', [SptController::class, 'destroy'])->name('user.spt.destroy');
    });

    // All authenticated users can access index and show
    Route::get('user/spt', [SptController::class, 'index'])->name('user.spt.index');
    Route::get('user/spt/{spt}', [SptController::class, 'show'])->name('user.spt.show');
});