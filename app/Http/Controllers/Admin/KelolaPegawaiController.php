<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\KelolaPegawaiService;

/**
 * KelolaPegawaiController — Thin Controller untuk manajemen pegawai di role Admin.
 */
class KelolaPegawaiController extends Controller
{
    public function __construct(
        private KelolaPegawaiService $kelolaPegawaiService
    ) {}

    public function index()
    {
        // Delegasi pengambilan data ke Service
        $data = $this->kelolaPegawaiService->getPegawaiData();

        return view('pages.admin.kelolaPegawai', $data);
    }
}
