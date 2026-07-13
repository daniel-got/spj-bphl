<?php

namespace App\Http\Controllers\PembuatSpt;

use App\Http\Controllers\Controller;
use App\Models\Rincian;
use App\Services\Rincian\RincianService;
use Illuminate\Http\Request;

class SpjSelesaiController extends Controller
{
    public function __construct(
        private RincianService $rincianService
    ) {}

    public function index(Request $request)
    {
        // Force the status filter to 'disetujui' only for this process
        $filters = [
            'search' => $request->input('search'),
            'status' => Rincian::STATUS_APPROVED,
        ];

        $perPage = (int) $request->input('per_page', 10);

        $rincians = $this->rincianService->getAllLatest($filters, $perPage);

        return view('pages.pembuat_spt.spj_selesai.index', compact('rincians'));
    }

    public function show($id)
    {
        $rincian = $this->rincianService->getRincianById($id);

        // Ensure that it is indeed approved to view here
        if ($rincian->status !== Rincian::STATUS_APPROVED) {
            abort(404, 'SPJ belum selesai atau tidak ditemukan.');
        }

        return view('pages.pembuat_spt.spj_selesai.show', compact('rincian'));
    }
}
