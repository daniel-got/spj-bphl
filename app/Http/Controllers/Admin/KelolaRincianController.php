<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rincian;
use App\Services\Rincian\RincianService;

/**
 * KelolaRincianController — Thin Controller untuk Admin melihat & mengelola SEMUA data Rincian SPJ.
 */
class KelolaRincianController extends Controller
{
    public function __construct(
        private RincianService $rincianService
    ) {}

    /**
     * Tampilkan daftar semua Rincian SPJ di sistem (tanpa filter kepemilikan).
     */
    public function index()
    {
        $filters = request()->only(['search', 'status', 'jenis_perjalanan']);
        $perPage = (int) request('per_page', 15);

        // Admin melihat SEMUA Rincian, tidak dibatasi kepemilikan (strictPersonal = false)
        $rincians = $this->rincianService->getAllLatest($filters, $perPage, false);
        $counts = $this->rincianService->getCounts(false);

        return view('pages.admin.rincian.index', compact('rincians', 'counts'));
    }

    /**
     * Tampilkan detail satu Rincian SPJ beserta data SPD-nya.
     */
    public function show(Rincian $rincian)
    {
        $rincian->load(['spd.spt', 'spd.pegawai', 'pembuat', 'verifikator', 'kwitansi']);

        return view('pages.admin.rincian.show', compact('rincian'));
    }

    /**
     * Hapus Rincian SPJ.
     */
    public function destroy(Rincian $rincian)
    {
        $this->rincianService->deleteRincian($rincian);

        return redirect()->route('admin.kelola-rincian.index')->with('success', 'Data Rincian SPJ berhasil dihapus.');
    }
}
