<?php

namespace App\Services\Admin;

use App\Models\Pegawai;

class KelolaPegawaiService
{
    /**
     * Mendapatkan data pegawai untuk ditampilkan di halaman kelola pegawai.
     */
    public function getPegawaiData(): array
    {
        // Contoh sederhana, bisa disesuaikan dengan kebutuhan (misal pagination atau eager loading)
        $pegawais = Pegawai::with('user')->latest()->paginate(10);

        return [
            'pegawais' => $pegawais,
        ];
    }
}
