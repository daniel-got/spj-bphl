<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class FirstLoginPasswordController extends Controller
{
    public function show()
    {
        // Jika tidak perlu ganti password, arahkan kembali ke tempat seharusnya
        if (!auth()->user()->must_change_password) {
            return redirect('/dashboard'); // Atau route default lain
        }

        return view('pages.auth.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = auth()->user();
        
        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        // Arahkan ke dashboard yang sesuai role-nya
        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'))->with('success', 'Password berhasil diubah.');
        }

        if ($user->isVerifikator() || $user->isPegawai() || $user->isMonitoring()) {
            return redirect()->intended(route('user.dashboard'))->with('success', 'Password berhasil diubah.');
        }

        if ($user->isPembuatSpt()) {
            return redirect()->intended(route('pembuat_spt.index'))->with('success', 'Password berhasil diubah.');
        }

        return redirect('/dashboard')->with('success', 'Password berhasil diubah.');
    }
}
