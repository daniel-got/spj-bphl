<?php

namespace App\Http\Controllers\Verifikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Verifikasi\UpdateSptStatusRequest;
use App\Models\Spt;
use App\Services\Spt\SptService;
use Illuminate\Http\Request;

class VerifikasiSptController extends Controller
{
    public function __construct(
        private SptService $sptService
    ) {}

    public function index(Request $request)
    {
        $status = $request->input('status', Spt::STATUS_WAITING_TU); // Default to 'diajukan'

        $filters = [
            'search' => $request->input('search'),
            'status' => $status,
        ];

        $perPage = (int) $request->input('per_page', 10);

        // Use the service to get paginated results
        $spts = $this->sptService->getAllLatest($filters, $perPage);

        // We get stats as well
        $counts = $this->sptService->getCounts();

        return view('pages.verifikasi.spt.index', compact('spts', 'counts', 'status'));
    }

    public function show($id)
    {
        $spt = $this->sptService->getSptById($id);

        return view('pages.verifikasi.spt.show', compact('spt'));
    }

    public function updateStatus(UpdateSptStatusRequest $request, $id)
    {
        $spt = Spt::findOrFail($id);

        if ($spt->status !== Spt::STATUS_WAITING_TU) {
            abort(403, 'SPT tidak dalam status diajukan.');
        }

        $this->sptService->verifySpt(
            $spt,
            $request->validated('status'),
            $request->validated('catatan_verifikator'),
            auth()->id()
        );

        return redirect()->route('verifikasi.spt.index');
    }
}
