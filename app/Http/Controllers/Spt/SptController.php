<?php

namespace App\Http\Controllers\Spt;

use App\Http\Controllers\Controller;
use App\Http\Requests\Spt\StoreSptRequest;
use App\Http\Requests\Spt\UpdateSptRequest;
use App\Models\Pegawai;
use App\Models\Spt;
use App\Services\Spt\SptService;
use Illuminate\Http\Request;

class SptController extends Controller
{
    protected SptService $sptService;

    public function __construct(SptService $sptService)
    {
        $this->sptService = $sptService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->sptService->getIndexPageData($request->all(), true);

        return view('pages.spt.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Spt::class);

        $pegawaiList = Pegawai::orderBy('nama_pegawai')->get();

        // Delegasikan ke Service
        $riwayatSuratDasar = $this->sptService->getRiwayatSuratDasar(50);

        return view('pages.spt.create', compact('pegawaiList', 'riwayatSuratDasar'));
    }

    public function edit(string $id)
    {
        $spt = $this->sptService->getSptById($id);
        $this->authorize('update', $spt);

        if (! in_array($spt->status, [Spt::STATUS_DRAFT, Spt::STATUS_REVISED])) {
            abort(403, 'SPT sudah diajukan dan tidak dapat diubah.');
        }

        $pegawaiList = Pegawai::orderBy('nama_pegawai')->get();

        // Delegasikan ke Service
        $riwayatSuratDasar = $this->sptService->getRiwayatSuratDasar(50);

        return view('pages.spt.edit', compact('spt', 'pegawaiList', 'riwayatSuratDasar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSptRequest $request)
    {
        $this->authorize('create', Spt::class);

        $spt = $this->sptService->createSpt($request->validated(), auth()->id());

        return redirect()
            ->route('user.spt.show', $spt->id)
            ->with('success', 'SPT berhasil dibuat. Silakan periksa detail dan ajukan jika sudah benar.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $spt = $this->sptService->getSptById($id);
        $this->authorize('view', $spt);

        return view('pages.spt.show', compact('spt'));
    }

    /**
     * Generate PDF for the specified SPT.
     */
    public function generatePdf(string $id)
    {
        $spt = $this->sptService->getSptForPdf($id);
        $this->authorize('view', $spt);

        return view('pages.spt.print', compact('spt'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSptRequest $request, string $id)
    {
        $spt = $this->sptService->getSptById($id);
        $this->authorize('update', $spt);

        if (! in_array($spt->status, [Spt::STATUS_DRAFT, Spt::STATUS_REVISED])) {
            abort(403, 'SPT sudah diajukan dan tidak dapat diubah.');
        }
        $this->sptService->updateSpt($spt, $request->validated());

        return redirect()
            ->route('user.spt.show', $spt->id)
            ->with('success', 'SPT berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $spt = $this->sptService->getSptById($id);
        $this->authorize('delete', $spt);

        if (! in_array($spt->status, [Spt::STATUS_DRAFT, Spt::STATUS_REVISED])) {
            abort(403, 'SPT sudah diajukan dan tidak dapat dihapus.');
        }
        $this->sptService->deleteSpt($spt);

        return redirect()
            ->route('user.spt.index')
            ->with('success', 'SPT berhasil dihapus.');
    }

    /**
     * Submit SPT to be verified.
     */
    public function submit(string $id)
    {
        $spt = $this->sptService->getSptById($id);
        $this->authorize('update', $spt);

        if (! in_array($spt->status, [Spt::STATUS_DRAFT, Spt::STATUS_REVISED])) {
            abort(403, 'SPT sudah diajukan atau diproses.');
        }

        $this->sptService->updateSpt($spt, ['status' => Spt::STATUS_WAITING_TU]);

        return back()->with('success', 'SPT berhasil diajukan untuk diverifikasi.');
    }
}
