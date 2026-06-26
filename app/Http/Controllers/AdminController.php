<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data = $this->adminService->getDashboardData();

        return view('dashboard.super_admin.dashboard', $data);
    }
}
