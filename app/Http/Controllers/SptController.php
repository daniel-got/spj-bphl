<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSptRequest;
use App\Http\Requests\UpdateSptRequest;
use App\Models\Pegawai;
use App\Models\Spt;
use App\Services\SptService;
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
        $counts = $this->sptService->getCounts();

        $filters = [
            'search' => $request->input('search'),
            'status' => $request->input('status'),
        ];

        $spts = $this->sptService->getAllLatest($filters, (int) $request->input('per_page', 10));

        return view('pages.spt.index', compact('counts', 'spts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawaiList = Pegawai::orderBy('nama_pegawai')->get();

        return view('pages.spt.create', compact('pegawaiList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSptRequest $request)
    {
        $data = $request->validated();
        $data['pembuat_id'] = auth()->id();
        $data['status'] = $data['status'] ?? 'draft';

        $this->sptService->createSpt($data);

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

        return view('pages.spt.show', compact('spt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $spt = $this->sptService->getSptById($id);
        $pegawaiList = Pegawai::orderBy('nama_pegawai')->get();

        return view('pages.spt.edit', compact('spt', 'pegawaiList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSptRequest $request, string $id)
    {
        $spt = $this->sptService->getSptById($id);
        $data = $request->validated();

        $this->sptService->updateSpt($spt, $data);

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

        $this->sptService->deleteSpt($spt);

        return redirect()
            ->route('user.spt.index')
            ->with('success', 'SPT berhasil dihapus.');
    }
}