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
require __DIR__.'/web/user.php';
require __DIR__.'/web/verifikasi.php';

use Illuminate\Support\Facades\Storage;

Route::get('/s3-proxy/{path}', function ($path) {
    if (!Storage::disk('s3')->exists($path)) {
        abort(404);
    }
    return Storage::disk('s3')->response($path);
})->where('path', '.*')->middleware('auth')->name('s3.proxy');
