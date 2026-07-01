<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpdRequest;
use App\Http\Requests\UpdateSpdRequest;
use App\Models\Spd;
use App\Models\Pegawai;
use App\Services\SpdService;

class SpdController extends Controller
{
    protected $spdService;

    public function __construct(SpdService $spdService)
    {
        $this->spdService = $spdService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $counts = $this->spdService->getCounts();
        $filters = request()->only(['search', 'jenis_perjalanan', 'status']);
        $perPage = (int) request('per_page', 10);
        $spds = $this->spdService->getAllLatest($filters, $perPage);

        return view('pages.spd.index', compact('spds', 'counts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::orderBy('nama_pegawai', 'asc')->get();
        return view('pages.spd.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpdRequest $request)
    {
        $this->spdService->createSpd($request->validated());

        return redirect()->route('user.spd.index')->with('success', 'Data SPD berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $spd = $this->spdService->getSpdById($id);

        return view('pages.spd.show', compact('spd'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Spd $spd)
    {
        $pegawais = Pegawai::orderBy('nama_pegawai', 'asc')->get();
        return view('pages.spd.edit', compact('spd', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpdRequest $request, Spd $spd)
    {
        $this->spdService->updateSpd($spd, $request->validated());

        return redirect()->route('user.spd.index')->with('success', 'Data SPD berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spd $spd)
    {
        $this->spdService->deleteSpd($spd);

        return redirect()->route('user.spd.index')->with('success', 'Data SPD berhasil dihapus');
    }
}
