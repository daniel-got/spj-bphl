<?php

use App\Http\Controllers\Spd\SpdController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('spt/search', [SpdController::class, 'searchSpt'])->name('spt.search');
        Route::get('spt/{id}/ajax', [SpdController::class, 'getSptAjax'])->name('spt.ajax');
        Route::resource('spd', SpdController::class);
    });
