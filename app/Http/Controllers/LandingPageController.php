<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Models\User;
use App\Models\Pegawai;

class LandingPageController extends Controller
{
    public function index(): View
    {

        $totalPegawai = User::has('pegawai')->count();
        $totalPegawaiIV = Pegawai::where('golongan', 'IV')->count();
        $totalPegawaiIII = Pegawai::where('golongan', 'III')->count();
        $totalPegawaiII = Pegawai::where('golongan', 'II')->count();

        return view('pages.home', compact('totalPegawai', 'totalPegawaiIV', 'totalPegawaiIII', 'totalPegawaiII'));
    }
}
