<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;

// Landing Page
Route::get('/', [LandingPageController::class, 'index']);
require __DIR__ . '/web/auth.php';
require __DIR__ . '/web/admin.php';
require __DIR__ . '/web/spd.php';
