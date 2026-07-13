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
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (! $user->isPembuatSpt() && ! $user->isAdmin()) {
            abort(403, 'Akses Ditolak. Halaman ini hanya dapat diakses oleh Pembuat SPT.');
        }

        return $next($request);
    }
}
