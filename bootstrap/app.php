<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\EnsurePembuatSpt;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Daftarkan alias middleware 'role' untuk digunakan di route group
        // Contoh pemakaian: Route::middleware(['auth', 'role:admin'])->...
        $middleware->alias([
            'role' => CheckRole::class,
            'pembuat_spt' => EnsurePembuatSpt::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
