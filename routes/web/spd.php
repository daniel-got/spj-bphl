<?php

use App\Http\Controllers\Spd\SpdController;
use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard/data', [DashboardController::class, 'getDashboardDataAjax'])->name('dashboard.data');
        Route::get('spt/search', [SpdController::class, 'searchSpt'])->name('spt.search');
        Route::get('spt/{id}/ajax', [SpdController::class, 'getSptAjax'])->name('spt.ajax');
        Route::get('spd/{id}/print', [SpdController::class, 'print'])->name('spd.print');
        Route::resource('spd', SpdController::class);
    });
