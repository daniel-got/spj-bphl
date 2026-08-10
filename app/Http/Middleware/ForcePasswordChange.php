<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Check if user must change password
            if ($user->must_change_password) {
                // Allow them to access the change password form, submit it, or logout
                $allowedRoutes = ['password.change.show', 'password.change.update', 'logout'];
                
                if (!in_array($request->route()->getName(), $allowedRoutes)) {
                    return redirect()->route('password.change.show');
                }
            }
        }

        return $next($request);
    }
}
