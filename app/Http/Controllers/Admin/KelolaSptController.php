<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Spt\SptService;
use Illuminate\Http\Request;

class KelolaSptController extends Controller
{
    protected SptService $sptService;

    public function __construct(SptService $sptService)
    {
        $this->sptService = $sptService;
    }

    public function index(Request $request)
    {
        // Admin melihat SEMUA SPT (strictPersonal = false)
        $data = $this->sptService->getIndexPageData($request->all(), false);

        return view('pages.admin.spt.index', $data);
    }
}
