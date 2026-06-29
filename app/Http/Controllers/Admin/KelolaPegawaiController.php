<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function store(\App\Http\Requests\Admin\StorePegawaiRequest $request)
    {
        $this->kelolaPegawaiService->createPegawai($request->validated());

        return redirect()->route('admin.kelolaPegawai')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function update(\App\Http\Requests\Admin\UpdatePegawaiRequest $request, \App\Models\Pegawai $pegawai)
    {
        $this->kelolaPegawaiService->updatePegawai($pegawai, $request->validated());

        return redirect()->route('admin.kelolaPegawai')->with('success', 'Data Pegawai berhasil diperbarui.');
    }

    public function destroy(\App\Models\Pegawai $pegawai)
    {
        $this->kelolaPegawaiService->deletePegawai($pegawai);

        return redirect()->route('admin.kelolaPegawai')->with('success', 'Data Pegawai berhasil dihapus.');
    }

    public function import(\App\Http\Requests\Admin\ImportPegawaiRequest $request)
    {
        try {
            $result = $this->kelolaPegawaiService->importCsv($request->file('file'));

            if ($result['gagal'] > 0) {
                return redirect()->route('admin.kelolaPegawai')->with('warning', "Import selesai. Berhasil: {$result['berhasil']}, Gagal: {$result['gagal']}. Error: " . implode(' | ', $result['errors']));
            }

            return redirect()->route('admin.kelolaPegawai')->with('success', "Import berhasil. {$result['berhasil']} data ditambahkan.");
        } catch (\Exception $e) {
            return redirect()->route('admin.kelolaPegawai')->with('error', $e->getMessage());
        }
    }

}
