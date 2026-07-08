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

        // KUNCI PERBAIKAN: Gunakan strtolower() agar mengecek role tanpa peduli huruf besar atau kecilnya
        $roleUser = strtolower($user->role);

        // Sekarang 'PEMBUAT_SPT', 'pembuat_spt', 'ADMIN', atau 'admin' semuanya akan terbaca dengan benar
        if ($roleUser !== 'pembuat_spt' && $roleUser !== 'admin') {
            abort(403, 'Akses Ditolak. Halaman ini hanya dapat diakses oleh Pembuat SPT.');
        }

        return $next($request);
    }
}
