<?php

namespace App\Http\Controllers\PembuatSpt;

use App\Http\Controllers\Controller;
use App\Services\Spt\PembuatSptService;
use Illuminate\Http\Request;

class KelolaSptController extends Controller
{
    public function __construct(protected PembuatSptService $service) {}

    public function index(Request $request)
    {
        $data = $this->service->getIndexPageData($request->all());

        return view('pages.spt.kelola', $data);
    }
}
