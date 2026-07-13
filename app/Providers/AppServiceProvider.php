<?php

namespace App\Providers;

use Illuminate\Auth\Events\Failed;
use Illuminate\Database\Events\TransactionRolledBack;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(function (Failed $event) {
            Log::warning('[SECURITY: FAILED LOGIN] Failed login attempt', [
                'user' => $event->credentials['email'] ?? 'unknown',
                'ip' => request()->ip(),
            ]);
        });

        Event::listen(function (TransactionRolledBack $event) {
            Log::warning('[DB TRANSACTION] Transaction rollback occurred', [
                'connection' => $event->connectionName,
            ]);
        });
    }
}
