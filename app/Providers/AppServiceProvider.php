<?php

namespace App\Providers;

use App\Models\Pengaturan;
use Illuminate\Auth\Events\Failed;
use Illuminate\Database\Events\TransactionRolledBack;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
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
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

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

        // Injeksi konfigurasi Cloudflare R2 secara dinamis dari database.
        // Nilai dari database akan menimpa konfigurasi dari .env jika ada.
        $this->bootDynamicR2Config();
    }

    /**
     * Baca konfigurasi R2 dari tabel data_pengaturan dan terapkan ke runtime config.
     * Jika tabel belum ada (misal saat migrasi pertama), proses ini dilewati dengan aman.
     */
    private function bootDynamicR2Config(): void
    {
        try {
            $r2 = Pengaturan::getCategory('r2');

            if (empty($r2)) {
                return;
            }

            $secretKey = null;
            if (! empty($r2['secret_key'])) {
                $secretKey = Crypt::decryptString($r2['secret_key']);
            }

            config([
                'filesystems.disks.s3.endpoint' => $r2['endpoint'] ?? config('filesystems.disks.s3.endpoint'),
                'filesystems.disks.s3.bucket' => $r2['bucket'] ?? config('filesystems.disks.s3.bucket'),
                'filesystems.disks.s3.key' => $r2['access_key'] ?? config('filesystems.disks.s3.key'),
                'filesystems.disks.s3.secret' => $secretKey ?? config('filesystems.disks.s3.secret'),
            ]);
        } catch (\Throwable $e) {
            // Jangan crash aplikasi jika tabel belum ada atau data corrupt.
            // Ini aman terjadi saat migrasi pertama atau saat tabel belum ada.
            Log::warning('[CONFIG] Dynamic R2 config could not be loaded: '.$e->getMessage());
        }
    }
}
