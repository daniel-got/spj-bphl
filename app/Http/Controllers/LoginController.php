<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Role-Based Redirect — sesuai pola developing_clean.md
            // Masing-masing role diarahkan ke dashboard yang berbeda
            $user = Auth::user();

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            if ($user->isPegawai()) {
                return redirect()->intended(route('user.spd.index'));
            }

            // Default: arahkan ke dashboard umum (akan dibuat nanti per role)
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
