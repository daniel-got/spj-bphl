<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;

/**
 * DashboardController — Thin Controller untuk halaman Dashboard Admin.
 *
 * Sesuai prinsip developing_clean.md:
 * - Tidak ada query Eloquent di sini
 * - Tidak ada logika bisnis di sini
 * - Hanya: terima request → panggil service → kembalikan view
 */
class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {}

    public function index()
    {
        // Delegasi seluruh logika ke Service
        $data = $this->dashboardService->getDashboardData();

        // Kembalikan view dengan data yang sudah disiapkan Service
        return view('pages.admin.dashboard', $data);
    }
}
