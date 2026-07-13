<?php

namespace App\Http\Controllers\Rincian;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rincian\StoreRincianRequest;
use App\Http\Requests\Rincian\UpdateRincianRequest;
use App\Models\Rincian;
use App\Services\Rincian\RincianService;
use Illuminate\Http\Request;

class RincianController extends Controller
{
    protected $rincianService;

    public function __construct(RincianService $rincianService)
    {
        $this->rincianService = $rincianService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $counts = $this->rincianService->getCounts();
        $filters = request()->only(['search', 'jenis_perjalanan', 'status']);
        $perPage = (int) request('per_page', 10);
        $rincians = $this->rincianService->getAllLatest($filters, $perPage);

        return view('pages.rincian.index', compact('rincians', 'counts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.rincian.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRincianRequest $request)
    {
        $this->rincianService->createRincian($request->validated(), auth()->id());

        return redirect()->route('user.rincian.index')->with('success', 'Data Rincian berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rincian = $this->rincianService->getRincianById($id);
        $this->authorize('view', $rincian);

        return view('pages.rincian.show', compact('rincian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rincian = $this->rincianService->getRincianById($id);
        $this->authorize('update', $rincian);

        if (! in_array($rincian->status, [Rincian::STATUS_DRAFT, Rincian::STATUS_REVISED])) {
            abort(403, 'Rincian SPJ sudah diajukan dan tidak dapat diubah.');
        }

        return view('pages.rincian.edit', compact('rincian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRincianRequest $request, string $id)
    {
        $rincian = $this->rincianService->getRincianById($id);
        $this->authorize('update', $rincian);

        if (! in_array($rincian->status, [Rincian::STATUS_DRAFT, Rincian::STATUS_REVISED])) {
            abort(403, 'Rincian SPJ sudah diajukan dan tidak dapat diubah.');
        }

        $this->rincianService->updateRincian($rincian, $request->validated());

        return redirect()->route('user.rincian.index')->with('success', 'Data Rincian berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rincian = $this->rincianService->getRincianById($id);
        $this->authorize('delete', $rincian);

        if (! in_array($rincian->status, [Rincian::STATUS_DRAFT, Rincian::STATUS_REVISED])) {
            abort(403, 'Rincian SPJ sudah diajukan dan tidak dapat dihapus.');
        }

        $this->rincianService->deleteRincian($rincian);

        return redirect()->route('user.rincian.index')->with('success', 'Data Rincian berhasil dihapus');
    }

    /**
     * Print the specified resource.
     */
    public function print(string $id)
    {
        $rincian = $this->rincianService->getRincianById($id);
        $this->authorize('view', $rincian);

        return view('pages.rincian.print', compact('rincian'));
    }

    public function searchSpd(Request $request)
    {
        return response()->json([
            'results' => $this->rincianService->searchSpd($request->q),
        ]);
    }

    public function getSpdAjax($id)
    {
        return response()->json(
            $this->rincianService->getSpdAjax($id)
        );
    }

    /**
     * Submit Rincian SPJ to be verified.
     */
    public function submit(string $id)
    {
        $rincian = $this->rincianService->getRincianById($id);
        $this->authorize('update', $rincian);

        if (! in_array($rincian->status, [Rincian::STATUS_DRAFT, Rincian::STATUS_REVISED])) {
            abort(403, 'SPJ sudah diajukan atau diproses.');
        }

        $this->rincianService->updateRincian($rincian, ['status' => Rincian::STATUS_SUBMITTED]);

        return back()->with('success', 'SPJ berhasil diajukan untuk diverifikasi.');
    }
}
