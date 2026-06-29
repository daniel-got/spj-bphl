<?php

namespace App\Http\Controllers;

use App\Models\Spd;
use App\Http\Requests\StoreSpdRequest;
use App\Http\Requests\UpdateSpdRequest;
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
        $allSpds = $this->spdService->getAllLatest();
        $filters = request()->only(['search', 'jenis_perjalanan', 'status']);
        $spds = $this->spdService->getAllLatest($filters);
        
        return view('pages.spd.index', compact('spds', 'allSpds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.spd.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpdRequest $request)
    {
        $this->spdService->createSpd($request->validated());

        return redirect()->route('spd.index')->with('success', 'Data SPD berhasil ditambahkan');
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
        return view('pages.spd.edit', compact('spd'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpdRequest $request, Spd $spd)
    {
        $this->spdService->updateSpd($spd, $request->validated());

        return redirect()->route('spd.index')->with('success', 'Data SPD berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spd $spd)
    {
        $this->spdService->deleteSpd($spd);

        return redirect()->route('spd.index')->with('success', 'Data SPD berhasil dihapus');
    }
}