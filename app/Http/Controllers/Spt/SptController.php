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
        // Semua filter, pencarian, dan kalkulasi dipindah ke Service
        $data = $this->sptService->getIndexPageData($request->all());

        return view('pages.spt.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya mengambil data referensi untuk view dropdown
        $pegawaiList = Pegawai::orderBy('nama_pegawai')->get();

        return view('pages.spt.create', compact('pegawaiList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSptRequest $request)
    {
        // Penentuan status default dan pembuat_id ditangani di dalam Service
        $this->sptService->createSpt($request->validated(), auth()->id());

        return redirect()
            ->route('user.spt.index')
            ->with('success', 'SPT berhasil ditambahkan.');
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $spt = $this->sptService->getSptById($id);
        $this->authorize('update', $spt);

        if (! in_array($spt->status, [Spt::STATUS_DRAFT, Spt::STATUS_REVISED])) {
            abort(403, 'SPT sudah diajukan dan tidak dapat diubah.');
        }

        $pegawaiList = Pegawai::orderBy('nama_pegawai')->get();

        return view('pages.spt.edit', compact('spt', 'pegawaiList'));
    }

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
            ->route('user.spt.index')
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
