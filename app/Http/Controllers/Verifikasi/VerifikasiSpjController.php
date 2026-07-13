<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Verifikasi\UpdateSpjStatusRequest;
use App\Models\Rincian;
use App\Services\Rincian\RincianService;
use Illuminate\Http\Request;

class VerifikasiSpjController extends Controller
{
    public function __construct(
        private RincianService $rincianService
    ) {}

    public function index(Request $request)
    {
        $status = $request->input('status', Rincian::STATUS_SUBMITTED); // Default to 'diajukan'

        $filters = [
            'search' => $request->input('search'),
            'status' => $status,
        ];

        $perPage = (int) $request->input('per_page', 10);

        $rincians = $this->rincianService->getAllLatest($filters, $perPage);
        $counts = $this->rincianService->getCounts();

        return view('pages.verifikasi.spj.index', compact('rincians', 'counts', 'status'));
    }

    public function show($id)
    {
        $rincian = $this->rincianService->getRincianById($id);

        return view('pages.verifikasi.spj.show', compact('rincian'));
    }

    public function updateStatus(UpdateSpjStatusRequest $request, $id)
    {
        $rincian = Rincian::findOrFail($id);

        if ($rincian->status !== Rincian::STATUS_SUBMITTED) {
            abort(403, 'SPJ tidak dalam status diajukan.');
        }

        $this->rincianService->verifySpj(
            $rincian,
            $request->validated('status'),
            $request->validated('catatan_verifikator'),
            auth()->id()
        );

        return redirect()->route('verifikasi.spj.index');
    }
}
