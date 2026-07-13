<?php

namespace App\Http\Controllers\Spd;

use App\Http\Controllers\Controller;
use App\Http\Requests\Spd\StoreSpdRequest;
use App\Http\Requests\Spd\UpdateSpdRequest;
use App\Models\Pegawai;
use App\Models\Spd;
use App\Services\Spd\SpdService;
use Illuminate\Http\Request;

class SpdController extends Controller
{
    public function __construct(
        private SpdService $spdService
    ) {}

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

    /**
     * Search SPT for autocomplete/Select2.
     */
    public function searchSpt(Request $request)
    {
        return response()->json([
            'results' => $this->spdService->searchSpt($request->q),
        ]);
    }

    /**
     * Get single SPT data via AJAX.
     */
    public function getSptAjax($id)
    {
        return response()->json(
            $this->spdService->getSptAjax($id)
        );
    }

    /**
     * Print the specified SPD resource.
     */
    public function print(string $id)
    {
        $spd = $this->spdService->getSpdById($id);

        return view('pages.spd.print', compact('spd'));
    }
}
