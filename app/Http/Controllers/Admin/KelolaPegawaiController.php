<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImportPegawaiRequest;
use App\Http\Requests\Admin\StorePegawaiRequest;
use App\Http\Requests\Admin\UpdatePegawaiRequest;
use App\Models\Pegawai;
use App\Services\Admin\KelolaPegawaiService;

/**
 * KelolaPegawaiController — Thin Controller untuk manajemen pegawai di role Admin.
 */
class KelolaPegawaiController extends Controller
{
    public function __construct(
        private KelolaPegawaiService $kelolaPegawaiService
    ) {}

    public function index()
    {
        // Delegasi pengambilan data ke Service
        $data = $this->kelolaPegawaiService->getPegawaiData();

        return view('pages.admin.kelolaPegawai', $data);
    }

    public function store(StorePegawaiRequest $request)
    {
        $this->kelolaPegawaiService->createPegawai($request->validated());

        return redirect()->route('admin.kelolaPegawai')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function update(UpdatePegawaiRequest $request, Pegawai $pegawai)
    {
        $this->kelolaPegawaiService->updatePegawai($pegawai, $request->validated());

        return redirect()->route('admin.kelolaPegawai')->with('success', 'Data Pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $this->kelolaPegawaiService->deletePegawai($pegawai);

        return redirect()->route('admin.kelolaPegawai')->with('success', 'Data Pegawai berhasil dihapus.');
    }

    public function import(ImportPegawaiRequest $request)
    {
        try {
            // Import dari token (file sementara hasil validasi)
            if ($request->filled('import_token')) {
                $result = $this->kelolaPegawaiService->importFromToken($request->input('import_token'));
            } else {
                $result = $this->kelolaPegawaiService->importCsv($request->file('file'));
            }

            if ($result['gagal'] > 0) {
                return redirect()->route('admin.kelolaPegawai')->with('warning', "Import selesai. Berhasil: {$result['berhasil']}, Gagal: {$result['gagal']}. Error: ".implode(' | ', $result['errors']));
            }

            return redirect()->route('admin.kelolaPegawai')->with('success', "Import berhasil. {$result['berhasil']} data ditambahkan.");
        } catch (\Exception $e) {
            return redirect()->route('admin.kelolaPegawai')->with('error', $e->getMessage());
        }
    }

    /**
     * Validasi CSV tanpa menyimpan ke DB (dry-run). Mengembalikan JSON.
     */
    public function validateImport(ImportPegawaiRequest $request)
    {
        try {
            $result = $this->kelolaPegawaiService->validateCsvOnly($request->file('file'));

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'valid' => false,
                'berhasil' => 0,
                'gagal' => 0,
                'errors' => [$e->getMessage()],
                'token' => null,
                'preview' => [],
            ], 422);
        }
    }
}
