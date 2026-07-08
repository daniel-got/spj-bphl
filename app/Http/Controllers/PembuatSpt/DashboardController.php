<?php

namespace App\Http\Controllers\PembuatSpt;

use App\Http\Controllers\Controller;
use App\Services\Spt\PembuatSptService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected PembuatSptService $service) {}

    /**
     * Halaman dashboard / index khusus Pembuat SPT.
     * Menampilkan statistik dan riwayat SPT yang dibuat atau ditugaskan.
     */
    public function index(Request $request)
    {
        $data = $this->service->getIndexPageData($request->all());

        return view('pages.pembuat_spt.index', $data);
    }
}
