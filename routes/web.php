<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;

Route::get('/', [LandingPageController::class, 'index']);

require __DIR__ . '/web/auth.php';
require __DIR__ . '/web/spd.php';
