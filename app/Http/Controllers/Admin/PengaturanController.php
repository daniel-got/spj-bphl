<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePengaturanR2Request;
use App\Services\Admin\PengaturanService;

/**
 * PengaturanController — Thin Controller untuk kelola pengaturan sistem di role Admin.
 */
class PengaturanController extends Controller
{
    public function __construct(
        private PengaturanService $pengaturanService
    ) {}

    /**
     * Tampilkan halaman pengaturan sistem.
     */
    public function index()
    {
        $r2Config = $this->pengaturanService->getR2Config();

        return view('pages.admin.pengaturan', compact('r2Config'));
    }

    /**
     * Perbarui konfigurasi Cloudflare R2.
     */
    public function updateR2(UpdatePengaturanR2Request $request)
    {
        $this->pengaturanService->updateR2Config($request->validated());

        return redirect()->route('admin.pengaturan')->with('success', 'Konfigurasi Cloudflare R2 berhasil diperbarui.');
    }
}
