<?php

use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [LandingPageController::class, 'index']);
require __DIR__.'/web/auth.php';
require __DIR__.'/web/admin.php';
require __DIR__.'/web/spd.php';
require __DIR__.'/web/pembuat_spt.php';
require __DIR__.'/web/spt.php';
require __DIR__.'/web/rincian.php';
require __DIR__.'/web/verifikasi.php';
