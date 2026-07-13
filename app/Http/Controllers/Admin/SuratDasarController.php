<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSuratDasarRequest;
use App\Http\Requests\Admin\UpdateSuratDasarRequest;
use App\Models\SuratDasar;
use App\Services\Admin\SuratDasarService;
use Illuminate\Http\Request;

class SuratDasarController extends Controller
{
    public function __construct(
        private SuratDasarService $suratDasarService
    ) {}

    /**
     * Tampilkan daftar semua surat dasar.
     */
    public function index(Request $request)
    {
        $suratDasars = $this->suratDasarService->getAllPaginated(
            $request->input('search'),
            (int) $request->input('per_page', 15)
        );

        return view('pages.admin.surat-dasar.index', compact('suratDasars'));
    }

    /**
     * Simpan surat dasar baru.
     */
    public function store(StoreSuratDasarRequest $request)
    {
        $this->suratDasarService->createOrUpdate($request->validated());

        return redirect()
            ->route('admin.surat-dasar.index')
            ->with('success', 'Surat dasar berhasil ditambahkan.');
    }

    /**
     * Perbarui surat dasar yang sudah ada.
     */
    public function update(UpdateSuratDasarRequest $request, SuratDasar $suratDasar)
    {
        $this->suratDasarService->update($suratDasar, $request->validated());

        return redirect()
            ->route('admin.surat-dasar.index')
            ->with('success', 'Surat dasar berhasil diperbarui.');
    }

    /**
     * Hapus surat dasar.
     */
    public function destroy(SuratDasar $suratDasar)
    {
        $this->suratDasarService->delete($suratDasar);

        return redirect()
            ->route('admin.surat-dasar.index')
            ->with('success', 'Surat dasar berhasil dihapus.');
    }

    /**
     * Toggle status aktif/nonaktif via AJAX atau redirect.
     */
    public function toggle(SuratDasar $suratDasar)
    {
        $this->suratDasarService->toggleAktif($suratDasar);

        return redirect()
            ->route('admin.surat-dasar.index')
            ->with('success', 'Status surat dasar berhasil diubah.');
    }

    /**
     * Sinkronisasi surat dasar dari data SPT lama yang sudah ada.
     */
    public function sinkron()
    {
        $imported = $this->suratDasarService->sinkronDariSpt();

        return redirect()
            ->route('admin.surat-dasar.index')
            ->with('success', "Sinkronisasi selesai. {$imported} surat dasar baru ditambahkan dari data SPT.");
    }
}
