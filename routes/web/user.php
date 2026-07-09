<?php

use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('user/dashboard', [DashboardController::class, 'index'])
        ->name('user.dashboard');
});
