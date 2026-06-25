<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class LandingPageController extends Controller
{
    public function index(): View
    {
        $totalPegawai = 120;
        $totalSPT = 120;
        $totalSPD = 120;

        return view('pages.home', compact('totalPegawai', 'totalSPT', 'totalSPD'));
    }
}
