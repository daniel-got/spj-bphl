<?php

namespace App\Http\Controllers\Spd;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Spd\StoreSpdRequest;
use App\Http\Requests\Spd\UpdateSpdRequest;
use App\Models\Pegawai;
use App\Models\Rincian;
use App\Models\Spd;
use App\Models\User;
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
        $filters = request()->only(['search', 'jenis_perjalanan']);
        $perPage = (int) request('per_page', 10);
        $spds = $this->spdService->getAllLatest($filters, $perPage);

        return view('pages.spd.index', compact('spds'));
    }

    private function getPpkData()
    {
        $roles = [
            UserRole::PPK1->label() => UserRole::PPK1->value,
            UserRole::PPK2->label() => UserRole::PPK2->value,
            UserRole::PPK3->label() => UserRole::PPK3->value,
            UserRole::BENDAHARA->label() => UserRole::BENDAHARA->value,
        ];

        $ppkData = [];
        foreach ($roles as $label => $roleValue) {
            $user = User::where('role', $roleValue)->with('pegawai')->first();
            $ppkData[$label] = [
                'nama' => $user?->pegawai?->nama_pegawai ?? $user?->name ?? '',
                'nip' => $user?->pegawai?->nip ?? '',
            ];
        }

        return $ppkData;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // SPD dibuat per akun: identitas pegawai otomatis dari akun yang login.
        $myPegawai = Pegawai::where('user_id', auth()->id())->first();
        $ppkData = $this->getPpkData();

        return view('pages.spd.create', compact('myPegawai', 'ppkData'));
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
        $this->authorize('view', $spd);

        return view('pages.spd.show', compact('spd'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Spd $spd)
    {
        $this->authorize('update', $spd);
        if ($spd->rincian && ! in_array($spd->rincian->status, [Rincian::STATUS_DRAFT, Rincian::STATUS_REVISED])) {
            abort(403, 'SPD ini sudah terikat dengan SPJ yang diajukan dan tidak dapat diubah.');
        }

        // Identitas pegawai pada SPD tetap mengikuti akun pemilik (tidak dapat diubah).
        $spd->load('pegawai');
        $ppkData = $this->getPpkData();

        return view('pages.spd.edit', compact('spd', 'ppkData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpdRequest $request, Spd $spd)
    {
        $this->authorize('update', $spd);
        if ($spd->rincian && ! in_array($spd->rincian->status, [Rincian::STATUS_DRAFT, Rincian::STATUS_REVISED])) {
            abort(403, 'SPD ini sudah terikat dengan SPJ yang diajukan dan tidak dapat diubah.');
        }

        $this->spdService->updateSpd($spd, $request->validated());

        return redirect()->route('user.spd.index')->with('success', 'Data SPD berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spd $spd)
    {
        $this->authorize('delete', $spd);
        if ($spd->rincian && ! in_array($spd->rincian->status, [Rincian::STATUS_DRAFT, Rincian::STATUS_REVISED])) {
            abort(403, 'SPD ini sudah terikat dengan SPJ yang diajukan dan tidak dapat dihapus.');
        }

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
