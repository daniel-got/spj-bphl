<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class LandingPageController extends Controller
{
    public function index(): View
    {
        $totalPegawai = 120;

        return view('welcome', compact('totalPegawai'));
    }
}
