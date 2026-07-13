<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImportUangHarianRequest;
use App\Http\Requests\Admin\StoreUangHarianRequest;
use App\Http\Requests\Admin\UpdateUangHarianRequest;
use App\Models\UangHarian;
use App\Services\Admin\UangHarianService;

class UangHarianController extends Controller
{
    public function __construct(
        private UangHarianService $uangHarianService
    ) {}

    public function index()
    {
        $uangHarians = $this->uangHarianService->getAllPaginated();

        return view('pages.admin.uang-harian', compact('uangHarians'));
    }

    public function store(StoreUangHarianRequest $request)
    {
        $this->uangHarianService->createUangHarian($request->validated());

        return redirect()->route('admin.uang-harian.index')->with('success', 'Data Uang Harian berhasil ditambahkan.');
    }

    public function update(UpdateUangHarianRequest $request, UangHarian $uangHarian)
    {
        $this->uangHarianService->updateUangHarian($uangHarian, $request->validated());

        return redirect()->route('admin.uang-harian.index')->with('success', 'Data Uang Harian berhasil diperbarui.');
    }

    public function destroy(UangHarian $uangHarian)
    {
        $this->uangHarianService->deleteUangHarian($uangHarian);

        return redirect()->route('admin.uang-harian.index')->with('success', 'Data Uang Harian berhasil dihapus.');
    }

    public function validateImport(ImportUangHarianRequest $request)
    {
        try {
            $result = $this->uangHarianService->validateCsvOnly($request->file('file'));

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

    public function import(ImportUangHarianRequest $request)
    {
        try {
            $result = $this->uangHarianService->importFromToken($request->input('import_token'));

            if ($result['gagal'] > 0) {
                return redirect()->route('admin.uang-harian.index')->with('warning', "Import selesai. Berhasil: {$result['berhasil']}, Gagal: {$result['gagal']}. Error: ".implode(' | ', $result['errors']));
            }

            return redirect()->route('admin.uang-harian.index')->with('success', "Import berhasil. {$result['berhasil']} data ditambahkan/diperbarui.");
        } catch (\Exception $e) {
            return redirect()->route('admin.uang-harian.index')->with('error', $e->getMessage());
        }
    }
}
