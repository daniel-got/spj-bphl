<?php

namespace App\Services\Admin;

use App\Models\Pengaturan;
use Illuminate\Support\Facades\Crypt;

class PengaturanService
{
    /**
     * Ambil konfigurasi R2 untuk ditampilkan di form.
     * Secret key dikembalikan sebagai null agar tidak ditampilkan di form.
     *
     * @return array<string, string|null|bool>
     */
    public function getR2Config(): array
    {
        $config = Pengaturan::getCategory('r2');

        return [
            'r2_endpoint' => $config['endpoint'] ?? null,
            'r2_bucket' => $config['bucket'] ?? null,
            'r2_access_key' => $config['access_key'] ?? null,
            // Jangan kembalikan nilai secret yang sudah terenkripsi ke form
            'r2_has_secret' => isset($config['secret_key']) && ! empty($config['secret_key']),
        ];
    }

    /**
     * Simpan konfigurasi R2.
     * Enkripsi secret key sebelum disimpan ke database.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateR2Config(array $data): void
    {
        Pengaturan::setValue('r2', 'endpoint', $data['r2_endpoint']);
        Pengaturan::setValue('r2', 'bucket', $data['r2_bucket']);
        Pengaturan::setValue('r2', 'access_key', $data['r2_access_key']);

        // Hanya simpan secret key jika ada input baru (tidak kosong)
        if (! empty($data['r2_secret_key'])) {
            Pengaturan::setValue('r2', 'secret_key', Crypt::encryptString($data['r2_secret_key']));
        }
    }
}
