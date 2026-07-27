<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spd;
use App\Services\Spd\SpdService;

/**
 * KelolaSpdController — Thin Controller untuk Admin melihat & mengelola SEMUA data SPD di sistem.
 */
class KelolaSpdController extends Controller
{
    public function __construct(
        private SpdService $spdService
    ) {}

    /**
     * Tampilkan daftar semua SPD di sistem (tanpa filter kepemilikan).
     */
    public function index()
    {
        $filters = request()->only(['search', 'jenis_perjalanan', 'status']);
        $perPage = (int) request('per_page', 15);

        // Admin melihat SEMUA SPD, tidak dibatasi kepemilikan (strictPersonal = false)
        $spds = $this->spdService->getAllLatest($filters, $perPage, false);

        return view('pages.admin.spd.index', compact('spds'));
    }

    /**
     * Tampilkan detail satu SPD (termasuk rincian terkait).
     */
    public function show(Spd $spd)
    {
        $spd->load(['spt', 'pembuat', 'pegawai', 'rincian']);

        return view('pages.admin.spd.show', compact('spd'));
    }

    /**
     * Hapus SPD beserta rincian terkait.
     */
    public function destroy(Spd $spd)
    {
        $this->spdService->deleteSpd($spd);

        return redirect()->route('admin.kelola-spd.index')->with('success', 'Data SPD berhasil dihapus.');
    }
}
