<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImportUangPenginapanRequest;
use App\Http\Requests\Admin\StoreUangPenginapanRequest;
use App\Http\Requests\Admin\UpdateUangPenginapanRequest;
use App\Models\UangPenginapan;
use App\Services\Admin\UangPenginapanService;

class UangPenginapanController extends Controller
{
    public function __construct(
        private UangPenginapanService $uangPenginapanService
    ) {}

    public function index()
    {
        $uangPenginapans = $this->uangPenginapanService->getAllPaginated();

        return view('pages.admin.uang-penginapan', compact('uangPenginapans'));
    }

    public function store(StoreUangPenginapanRequest $request)
    {
        $this->uangPenginapanService->createUangPenginapan($request->validated());

        return redirect()->route('admin.uang-penginapan.index')->with('success', 'Data Uang Penginapan berhasil ditambahkan.');
    }

    public function update(UpdateUangPenginapanRequest $request, UangPenginapan $uangPenginapan)
    {
        $this->uangPenginapanService->updateUangPenginapan($uangPenginapan, $request->validated());

        return redirect()->route('admin.uang-penginapan.index')->with('success', 'Data Uang Penginapan berhasil diperbarui.');
    }

    public function destroy(UangPenginapan $uangPenginapan)
    {
        $this->uangPenginapanService->deleteUangPenginapan($uangPenginapan);

        return redirect()->route('admin.uang-penginapan.index')->with('success', 'Data Uang Penginapan berhasil dihapus.');
    }

    public function validateImport(ImportUangPenginapanRequest $request)
    {
        try {
            $result = $this->uangPenginapanService->validateCsvOnly($request->file('file'));

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

    public function import(ImportUangPenginapanRequest $request)
    {
        try {
            $result = $this->uangPenginapanService->importFromToken($request->input('import_token'));

            if ($result['gagal'] > 0) {
                return redirect()->route('admin.uang-penginapan.index')->with('warning', "Import selesai. Berhasil: {$result['berhasil']}, Gagal: {$result['gagal']}. Error: ".implode(' | ', $result['errors']));
            }

            return redirect()->route('admin.uang-penginapan.index')->with('success', "Import berhasil. {$result['berhasil']} data ditambahkan/diperbarui.");
        } catch (\Exception $e) {
            return redirect()->route('admin.uang-penginapan.index')->with('error', $e->getMessage());
        }
    }
}
