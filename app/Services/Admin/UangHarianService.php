<?php

namespace App\Services\Admin;

use App\Models\UangHarian;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
        $fullPath = Storage::path($path);

        $lines = file($fullPath);
        if (count($lines) < 2) {
            throw new \Exception('File CSV kosong atau tidak memiliki baris data (hanya header).');
        }

        // Hapus UTF-8 BOM dari baris pertama jika ada
        $lines[0] = preg_replace('/^\xEF\xBB\xBF/', '', $lines[0]);
        $delimiter = strpos($lines[0], ';') !== false ? ';' : ',';

        $data = array_map(function ($line) use ($delimiter) {
            return str_getcsv($line, $delimiter);
        }, $lines);

        $headers = array_map(function ($h) {
            $h = strtolower(trim($h));
            $h = preg_replace('/[^a-z0-9]/', '_', $h);
            $h = preg_replace('/_+/', '_', $h);
            $h = trim($h, '_');
            // Alias map
            if ($h === 'dalam_kota') {
                $h = 'dalam_kota_lebih_8_jam';
            }

            return $h;
        }, $data[0]);

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

            // Skip if row is completely empty
            if (empty(array_filter($row, fn ($v) => trim($v) !== ''))) {
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
        $fullPath = Storage::path('temp_imports/'.$token);

        if (! file_exists($fullPath)) {
            throw new \Exception('File import kadaluarsa atau tidak ditemukan. Silakan ulangi proses upload.');
        }

        $lines = file($fullPath);
        if (count($lines) < 2) {
            throw new \Exception('File CSV kosong atau tidak memiliki baris data (hanya header).');
        }

        $lines[0] = preg_replace('/^\xEF\xBB\xBF/', '', $lines[0]);
        $delimiter = strpos($lines[0], ';') !== false ? ';' : ',';

        $data = array_map(function ($line) use ($delimiter) {
            return str_getcsv($line, $delimiter);
        }, $lines);

        $headers = array_map(function ($h) {
            $h = strtolower(trim($h));
            $h = preg_replace('/[^a-z0-9]/', '_', $h);
            $h = preg_replace('/_+/', '_', $h);
            $h = trim($h, '_');
            if ($h === 'dalam_kota') {
                $h = 'dalam_kota_lebih_8_jam';
            }

            return $h;
        }, $data[0]);

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

            // Skip if row is completely empty
            if (empty(array_filter($row, fn ($v) => trim($v) !== ''))) {
                continue;
            }

            $provinsi = trim($row[$headerMap['provinsi']]);
            if (empty($provinsi)) {
                continue;
            }

            UangHarian::updateOrCreate(
                ['provinsi' => $provinsi],
                [
                    'luar_kota' => (int) preg_replace('/\D/', '', $row[$headerMap['luar_kota']]),
                    'dalam_kota_lebih_8_jam' => (int) preg_replace('/\D/', '', $row[$headerMap['dalam_kota_lebih_8_jam']]),
                    'diklat' => (int) preg_replace('/\D/', '', $row[$headerMap['diklat']]),
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
