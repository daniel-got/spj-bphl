<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class LandingPageController extends Controller
{
    public function index(): View
    {

        $totalPegawai = 55;
        $totalPegawaiIV = 10;
        $totalPegawaiIII = 32;
        $totalPegawaiII = 6;

        return view('pages.home', compact('totalPegawai', 'totalPegawaiIV', 'totalPegawaiIII', 'totalPegawaiII'));
    }
}
