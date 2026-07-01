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

    /**
     * Search SPT for autocomplete/Select2.
     */
    public function searchSpt()
    {
        $search = request('q');
        $spts = \App\Models\Spt::where('nomor_spt', 'like', "%{$search}%")
            ->orWhere('tujuan_kegiatan', 'like', "%{$search}%")
            ->limit(15)
            ->get();

        $results = [];
        foreach ($spts as $spt) {
            $results[] = [
                'id' => $spt->id,
                'text' => $spt->nomor_spt,
            ];
        }

        return response()->json(['results' => $results]);
    }

    /**
     * Get single SPT data via AJAX.
     */
    public function getSptAjax($id)
    {
        $spt = \App\Models\Spt::findOrFail($id);

        $pegawaiList = is_string($spt->pegawai_ditugaskan)
            ? json_decode($spt->pegawai_ditugaskan, true)
            : $spt->pegawai_ditugaskan;

        return response()->json([
            'id' => $spt->id,
            'nomor_spt' => $spt->nomor_spt,
            'tujuan_kegiatan' => $spt->tujuan_kegiatan,
            'tempat_tujuan' => $spt->tempat_tujuan,
            'tgl_berangkat' => $spt->tgl_berangkat ? $spt->tgl_berangkat->format('Y-m-d') : null,
            'tgl_kembali' => $spt->tgl_kembali ? $spt->tgl_kembali->format('Y-m-d') : null,
            'lama_kegiatan' => $spt->lama_kegiatan,
            'kode_mak' => $spt->kode_mak,
            'pegawai_list' => $pegawaiList,
        ]);
    }
}
