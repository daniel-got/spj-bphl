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

    /**
     * Driver-aware query filter for pegawai_ditugaskan JSON column.
     */
    public static function queryPegawaiDitugaskan($query, $pegawaiId, $boolean = 'and')
    {
        $callback = function($q) use ($pegawaiId) {
            if (config('database.default') === 'sqlite') {
                $q->where('pegawai_ditugaskan', 'like', '%"pegawai_id":"' . $pegawaiId . '"%')
                  ->orWhere('pegawai_ditugaskan', 'like', '%"pegawai_id": "' . $pegawaiId . '"%')
                  ->orWhere('pegawai_ditugaskan', 'like', '%"pegawai_id":' . $pegawaiId . '%')
                  ->orWhere('pegawai_ditugaskan', 'like', '%"pegawai_id": ' . $pegawaiId . '%');
            } else {
                $q->whereJsonContains('pegawai_ditugaskan', [['pegawai_id' => (string) $pegawaiId]])
                  ->orWhereJsonContains('pegawai_ditugaskan', [['pegawai_id' => (int) $pegawaiId]]);
            }
        };

        return $boolean === 'or' ? $query->orWhere($callback) : $query->where($callback);
    }
}
