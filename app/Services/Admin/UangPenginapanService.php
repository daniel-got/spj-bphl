<?php

namespace App\Services\Admin;

use App\Models\UangPenginapan;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UangPenginapanService
{
    /**
     * Mengambil daftar uang penginapan.
     */
    public function getAllPaginated(int $perPage = 10)
    {
        return UangPenginapan::orderBy('provinsi', 'asc')->paginate($perPage);
    }

    /**
     * Menyimpan data uang penginapan baru.
     */
    public function createUangPenginapan(array $data): UangPenginapan
    {
        return UangPenginapan::create($data);
    }

    /**
     * Memperbarui data uang penginapan.
     */
    public function updateUangPenginapan(UangPenginapan $uangPenginapan, array $data): bool
    {
        return $uangPenginapan->update($data);
    }

    /**
     * Menghapus data uang penginapan.
     */
    public function deleteUangPenginapan(UangPenginapan $uangPenginapan): ?bool
    {
        return $uangPenginapan->delete();
    }

    /**
     * Validasi file CSV sebelum benar-benar diimpor (dry-run).
     */
    public function validateCsvOnly(UploadedFile $file): array
    {
        $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\RawDataImport, $file);
        if (empty($sheets) || empty($sheets[0])) {
            throw new \Exception('File kosong atau format tidak didukung.');
        }

        $data = $sheets[0];
        if (count($data) < 2) {
            throw new \Exception('File kosong atau tidak memiliki baris data (hanya header).');
        }

        $headers = array_map(function ($h) {
            $h = strtolower(trim($h));
            $h = preg_replace('/[^a-z0-9]/', '_', $h);
            $h = preg_replace('/_+/', '_', $h);

            return trim($h, '_');
        }, $data[0]);

        $requiredHeaders = ['provinsi', 'gol_iv', 'gol_iii_ii_i'];
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
            $row = array_pad($row, count($headers), null);
            if (count($row) > count($headers)) {
                $row = array_slice($row, 0, count($headers));
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
                    'gol_iv' => $row[$headerMap['gol_iv']],
                    'gol_iii_ii_i' => $row[$headerMap['gol_iii_ii_i']],
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

    public function importFromToken(string $token): array
    {
        $fullPath = Storage::path('temp_imports/'.$token);

        if (! file_exists($fullPath)) {
            throw new \Exception('File import kadaluarsa atau tidak ditemukan. Silakan ulangi proses upload.');
        }
        
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
        $mimeType = match($extension) {
            'csv' => 'text/csv',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xls' => 'application/vnd.ms-excel',
            default => 'application/octet-stream',
        };
        $uploadedFile = new UploadedFile($fullPath, basename($fullPath), $mimeType, null, true);

        $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\RawDataImport, $uploadedFile);
        if (empty($sheets) || empty($sheets[0])) {
            throw new \Exception('File kosong atau format tidak didukung.');
        }

        $data = $sheets[0];
        if (count($data) < 2) {
            throw new \Exception('File kosong atau tidak memiliki baris data (hanya header).');
        }

        $headers = array_map(function ($h) {
            $h = strtolower(trim($h));
            $h = preg_replace('/[^a-z0-9]/', '_', $h);
            $h = preg_replace('/_+/', '_', $h);

            return trim($h, '_');
        }, $data[0]);

        $requiredHeaders = ['provinsi', 'gol_iv', 'gol_iii_ii_i'];
        $headerMap = [];
        foreach ($requiredHeaders as $reqHeader) {
            $headerMap[$reqHeader] = array_search($reqHeader, $headers);
        }

        $berhasil = 0;

        for ($i = 1; $i < count($data); $i++) {
            $row = $data[$i];
            $row = array_pad($row, count($headers), null);
            if (count($row) > count($headers)) {
                $row = array_slice($row, 0, count($headers));
            }

            // Skip if row is completely empty
            if (empty(array_filter($row, fn ($v) => trim($v) !== ''))) {
                continue;
            }

            $provinsi = trim($row[$headerMap['provinsi']]);
            if (empty($provinsi)) {
                continue;
            }

            UangPenginapan::updateOrCreate(
                ['provinsi' => $provinsi],
                [
                    'gol_iv' => (int) preg_replace('/\D/', '', $row[$headerMap['gol_iv']]),
                    'gol_iii_ii_i' => (int) preg_replace('/\D/', '', $row[$headerMap['gol_iii_ii_i']]),
                ]
            );

            $berhasil++;
        }

        @unlink($fullPath);

        return [
            'berhasil' => $berhasil,
            'gagal' => 0,
            'errors' => [],
        ];
    }
}
