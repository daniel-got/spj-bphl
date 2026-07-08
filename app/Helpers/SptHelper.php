<?php

namespace App\Helpers;

class SptHelper
{
    /**
     * Ekstrak nama penanggung jawab dan anggota dari array pegawai ditugaskan.
     */
    public static function extractRoles(array $pegawaiList): array
    {
        $pjNames = [];
        $anggotaNames = [];

        foreach ($pegawaiList as $pegawai) {
            $nama = $pegawai['nama'] ?? $pegawai['nama_pegawai'] ?? '';
            $peran = $pegawai['peran'] ?? 'Anggota';

            if ($peran === 'Penanggung Jawab') {
                $pjNames[] = $nama;
            } else {
                $anggotaNames[] = $nama;
            }
        }

        return [
            'penanggung_jawab' => implode(', ', $pjNames) ?: null,
            'anggota' => implode(', ', $anggotaNames) ?: null,
        ];
    }

    /**
     * Hitung total biaya dari array rincian biaya.
     */
    public static function calculateTotalBiaya(array $rincianBiaya): float
    {
        $total = 0;
        foreach ($rincianBiaya as $biaya) {
            $total += ($biaya['transport'] ?? 0);
            $total += ($biaya['penginapan'] ?? 0);
            $total += ($biaya['hotel_ril'] ?? 0);
        }

        return $total;
    }
}
