<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * CheckRole Middleware — Gatekeeper untuk halaman berdasarkan role.
 *
 * Cara penggunaan di Route:
 *   Route::middleware(['auth', 'role:admin'])->group(...)
 *   Route::middleware(['auth', 'role:verifikator'])->group(...)
 *
 * Middleware ini HANYA bertugas sebagai "penjaga pintu".
 * Tidak ada logika bisnis di sini — sesuai prinsip developing_clean.md.
 */
class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pastikan user sudah login
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Admin bypass - Admin selalu boleh akses semua route yang dijaga middleware ini
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Pastikan role user ada di dalam array $roles yang diizinkan
        $userRoles = $user->roles ?? [];
        $hasAllowedRole = count(array_intersect($userRoles, $roles)) > 0;

        if (! $hasAllowedRole) {
            abort(403, 'Akses Ditolak. Halaman ini butuh hak akses khusus.');
        }

        return $next($request);
    }
}
