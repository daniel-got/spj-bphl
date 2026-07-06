<?php

use App\Http\Controllers\Spt\SptController;
use Illuminate\Support\Facades\Route;

// Menggunakan Route Resource tanpa tambahan ->prefix() atau ->name() di dalam sini
// Ini otomatis membuat URL: 127.0.0.1:8000/user/spt/create
Route::middleware(['auth'])->group(function () {
    Route::resource('user/spt', SptController::class)->names([
        'index' => 'user.spt.index',
        'create' => 'user.spt.create',
        'store' => 'user.spt.store',
        'show' => 'user.spt.show',
        'edit' => 'user.spt.edit',
        'update' => 'user.spt.update',
        'destroy' => 'user.spt.destroy',
    ]);
});
