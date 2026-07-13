<?php

namespace App\Http\Controllers\Spt;

use App\Http\Controllers\Controller;
use App\Http\Requests\Spt\StoreSptRequest;
use App\Http\Requests\Spt\UpdateSptRequest;
use App\Models\Pegawai;
use App\Models\Spt;
use App\Services\Spt\SptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $data = $this->sptService->getIndexPageData($request->all());
        return view('pages.spt.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $pegawaiList = Pegawai::orderBy('nama_pegawai')->get();
    
    // Delegasikan ke Service
    $riwayatSuratDasar = $this->sptService->getRiwayatSuratDasar(50); 

    return view('pages.spt.create', compact('pegawaiList', 'riwayatSuratDasar'));
}

public function edit(string $id)
{
    $spt = $this->sptService->getSptById($id);
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
        return view('pages.spt.show', compact('spt'));
    }

    /**
     * Generate PDF for the specified SPT.
     */
    public function generatePdf($id)
    {
        $spt = Spt::findOrFail($id);

        $pegawaiData = $spt->pegawai_ditugaskan;
        if (is_string($pegawaiData)) {
            $pegawaiData = json_decode($pegawaiData, true);
        }

        $pegawais = collect();
        if (is_array($pegawaiData)) {
            foreach ($pegawaiData as $p) {
                $pegawaiModel = Pegawai::find($p['pegawai_id'] ?? null);
                if ($pegawaiModel) {
                    $pegawaiModel->peran = $p['peran'] ?? 'Anggota';
                    $pegawaiModel->setRelation('pegawai', $pegawaiModel);
                    $pegawais->push($pegawaiModel);
                } else {
                    $dummy = new Pegawai([
                        'nama_pegawai' => $p['nama_pegawai'] ?? $p['nama'] ?? '-',
                        'nip' => $p['nip'] ?? '-',
                        'pangkat' => $p['pangkat'] ?? '-',
                        'golongan' => $p['golongan'] ?? '',
                        'jabatan' => $p['jabatan'] ?? '-',
                    ]);
                    $dummy->id = $p['pegawai_id'] ?? 0;
                    $dummy->peran = $p['peran'] ?? 'Anggota';
                    $dummy->setRelation('pegawai', $dummy);
                    $pegawais->push($dummy);
                }
            }
        }
        $spt->setRelation('pegawais', $pegawais);

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
        $this->sptService->deleteSpt($spt);

        return redirect()
            ->route('user.spt.index')
            ->with('success', 'SPT berhasil dihapus.');
    }
}