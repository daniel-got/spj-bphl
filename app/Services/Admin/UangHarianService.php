<?php

namespace App\Services\Admin;

use App\Models\UangHarian;
use Illuminate\Http\UploadedFile;

class UangHarianService
{
    /**
     * Mengambil daftar uang harian.
     */
    public function getAllPaginated(int $perPage = 10)
    {
        return UangHarian::orderBy('provinsi', 'asc')->paginate($perPage);
    }

    /**
     * Menyimpan data uang harian baru.
     */
    public function createUangHarian(array $data): UangHarian
    {
        return UangHarian::create($data);
    }

    /**
     * Memperbarui data uang harian.
     */
    public function updateUangHarian(UangHarian $uangHarian, array $data): bool
    {
        return $uangHarian->update($data);
    }

    /**
     * Menghapus data uang harian.
     */
    public function deleteUangHarian(UangHarian $uangHarian): ?bool
    {
        return $uangHarian->delete();
    }

    /**
     * Validasi file CSV sebelum benar-benar diimpor (dry-run).
     * Akan menyimpan file sementara dan mengembalikan token serta preview data.
     */
    public function validateCsvOnly(UploadedFile $file): array
    {
        $path = $file->store('temp_imports');
        $fullPath = storage_path('app/'.$path);

        $data = array_map('str_getcsv', file($fullPath));
        if (count($data) < 2) {
            throw new \Exception('File CSV kosong atau tidak memiliki baris data (hanya header).');
        }

        $headers = array_map('strtolower', array_map('trim', $data[0]));

        $requiredHeaders = ['provinsi', 'luar_kota', 'dalam_kota_lebih_8_jam', 'diklat'];
        $headerMap = [];
        foreach ($requiredHeaders as $reqHeader) {
            $idx = array_search($reqHeader, $headers);
            if ($idx === false) {
                throw new \Exception("Kolom '{$reqHeader}' tidak ditemukan di CSV. Pastikan format header benar.");
            }
            $headerMap[$reqHeader] = $idx;
        }

        $berhasil = 0;
        $gagal = 0;
        $errors = [];
        $preview = [];

        for ($i = 1; $i < count($data); $i++) {
            $row = $data[$i];
            if (count($row) < count($headers)) {
                continue;
            }

            $provinsi = trim($row[$headerMap['provinsi']]);
            if (empty($provinsi)) {
                $gagal++;
                $errors[] = 'Baris '.($i + 1).': Provinsi kosong.';

                continue;
            }

            $berhasil++;
            if (count($preview) < 5) {
                $preview[] = [
                    'provinsi' => $provinsi,
                    'luar_kota' => $row[$headerMap['luar_kota']],
                    'dalam_kota_lebih_8_jam' => $row[$headerMap['dalam_kota_lebih_8_jam']],
                    'diklat' => $row[$headerMap['diklat']],
                ];
            }
        }

        return [
            'valid' => $gagal === 0,
            'berhasil' => $berhasil,
            'gagal' => $gagal,
            'errors' => $errors,
            'token' => basename($path),
            'preview' => $preview,
        ];
    }

    /**
     * Memproses import dari token file sementara yang sudah divalidasi.
     */
    public function importFromToken(string $token): array
    {
        $fullPath = storage_path('app/temp_imports/'.$token);

        if (! file_exists($fullPath)) {
            throw new \Exception('File import kadaluarsa atau tidak ditemukan. Silakan ulangi proses upload.');
        }

        $data = array_map('str_getcsv', file($fullPath));
        $headers = array_map('strtolower', array_map('trim', $data[0]));

        $requiredHeaders = ['provinsi', 'luar_kota', 'dalam_kota_lebih_8_jam', 'diklat'];
        $headerMap = [];
        foreach ($requiredHeaders as $reqHeader) {
            $headerMap[$reqHeader] = array_search($reqHeader, $headers);
        }

        $berhasil = 0;

        for ($i = 1; $i < count($data); $i++) {
            $row = $data[$i];
            if (count($row) < count($headers)) {
                continue;
            }

            $provinsi = trim($row[$headerMap['provinsi']]);
            if (empty($provinsi)) {
                continue;
            }

            UangHarian::updateOrCreate(
                ['provinsi' => $provinsi],
                [
                    'luar_kota' => (int) $row[$headerMap['luar_kota']],
                    'dalam_kota_lebih_8_jam' => (int) $row[$headerMap['dalam_kota_lebih_8_jam']],
                    'diklat' => (int) $row[$headerMap['diklat']],
                ]
            );

            $berhasil++;
        }

        // Hapus file sementara setelah diproses
        @unlink($fullPath);

        return [
            'berhasil' => $berhasil,
            'gagal' => 0,
            'errors' => [],
        ];
    }
}
