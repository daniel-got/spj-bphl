<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\EnsurePembuatSpt;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

        $exceptions->report(function (QueryException $e) {
            Log::error('[DB ERROR] Query Exception', [
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings(),
            ]);
        });

        $exceptions->report(function (PDOException $e) {
            Log::critical('[DB ERROR] Database Connectivity/PDO Exception', [
                'error' => $e->getMessage(),
            ]);
        });

        $exceptions->report(function (HttpException $e) {
            if ($e->getStatusCode() === 403) {
                Log::warning('[SECURITY: UNAUTHORIZED] Unauthorized access attempt', [
                    'url' => request()->fullUrl(),
                    'user_id' => auth()->id() ?? 'guest',
                    'ip' => request()->ip(),
                ]);
            }
        });
    })->create();
