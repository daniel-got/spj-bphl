<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePembuatSpt
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Hanya role 'pembuat_spt' (dan 'admin') yang diizinkan mengakses pembuatan SPT
        if ($user->role !== 'pembuat_spt' && $user->role !== 'admin') {
            abort(403, 'Akses Ditolak. Halaman ini hanya dapat diakses oleh Pembuat SPT.');
        }

        return $next($request);
    }
}
