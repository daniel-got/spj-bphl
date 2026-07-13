<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\DashboardService;
use Illuminate\Http\JsonResponse;

/**
 * DashboardController — Thin Controller untuk halaman Dashboard Pegawai.
 */
class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {}

    public function index()
    {
        $userId = auth()->id();
        $data = $this->dashboardService->getDashboardData($userId, request('status'));

        return view('pages.user.dashboard', $data);
    }

    public function getDashboardDataAjax(): JsonResponse
    {
        $userId = auth()->id();
        $data = $this->dashboardService->getDashboardData($userId, request('status'));

        return response()->json($data);
    }
}
