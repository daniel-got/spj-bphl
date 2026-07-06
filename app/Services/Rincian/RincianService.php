<?php

namespace App\Services\Rincian;

use App\Models\Rincian;
use App\Models\Spd;
use Illuminate\Support\Facades\DB;

class RincianService
{
    /**
     * Get statistics count for Rincian.
     */
    public function getCounts(): array
    {
        return [
            'all' => Rincian::count(),
            'disetujui' => Rincian::where('status', 'disetujui')->count(),
            'direvisi' => Rincian::where('status', 'direvisi')->count(),
            'ditolak' => Rincian::where('status', 'ditolak')->count(),
        ];
    }

    /**
     * Get all Rincian records with optional search and filter.
     */
    public function getAllLatest(array $filters = [], int $perPage = 10)
    {
        $query = Rincian::query();

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nomor_spd', 'like', '%'.$search.'%')
                    ->orWhere('pegawai_ditugaskan', 'like', '%'.$search.'%')
                    ->orWhere('tujuan_kegiatan', 'like', '%'.$search.'%')
                    ->orWhere('tempat_tujuan', 'like', '%'.$search.'%');
            });
        }

        if (! empty($filters['jenis_perjalanan'])) {
            $query->where('jenis_perjalanan', $filters['jenis_perjalanan']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get a Rincian by ID.
     */
    public function getRincianById(string $id)
    {
        return Rincian::findOrFail($id);
    }

    /**
     * Create a new Rincian by copying data from Spd.
     */
    public function createRincian(array $data, int $authId)
    {
        return DB::transaction(function () use ($data, $authId) {
            $spd = Spd::findOrFail($data['spd_id']);

            $rincianData = [
                'nomor_spd' => $spd->nomor_spd,
                'tgl_spd' => $spd->tgl_spd,
                'pegawai_ditugaskan' => $spd->pegawai_ditugaskan,
                'nip_pegawai' => $spd->nip_pegawai,
                'tujuan_kegiatan' => $spd->tujuan_kegiatan,
                'berangkat_dari' => $spd->berangkat_dari,
                'tempat_tujuan' => is_array($spd->tempat_tujuan) ? implode(', ', $spd->tempat_tujuan) : $spd->tempat_tujuan,
                'lama_kegiatan' => $spd->lama_kegiatan,
                'jenis_perjalanan' => $spd->jenis_perjalanan,
                'alat_angkut' => is_array($spd->alat_angkut) ? implode(', ', $spd->alat_angkut) : $spd->alat_angkut,
                'kode_mak' => $spd->kode_mak,
                'ppk' => $spd->ppk,
                'nama_ppk' => $spd->nama_ppk,
                'nip_ppk' => $spd->nip_ppk,

                // Manual inputs
                'rincian_biaya' => $data['rincian_biaya'] ?? null,

                'status' => 'draft',
                'pembuat_id' => $authId,
            ];

            return Rincian::create($rincianData);
        });
    }

    /**
     * Update an existing Rincian.
     */
    public function updateRincian(Rincian $rincian, array $data)
    {
        return DB::transaction(function () use ($rincian, $data) {
            $rincian->update($data);

            return $rincian;
        });
    }

    /**
     * Delete a Rincian.
     */
    public function deleteRincian(Rincian $rincian)
    {
        return DB::transaction(function () use ($rincian) {
            $rincian->delete();

            return true;
        });
    }

    public function searchSpd($query = '')
    {
        return Spd::when($query, function ($q) use ($query) {
            $q->where('nomor_spd', 'like', "%{$query}%");
        })
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($spd) {
                return [
                    'id' => $spd->id,
                    'text' => $spd->nomor_spd,
                ];
            });
    }

    public function getSpdAjax($id)
    {
        $spd = Spd::find($id);

        if (! $spd) {
            return [];
        }

        return [
            'nomor_spd' => $spd->nomor_spd,
            'tgl_spd' => $spd->tgl_spd,
            'pegawai_ditugaskan' => $spd->pegawai_ditugaskan,
            'nip_pegawai' => $spd->nip_pegawai,
            'tujuan_kegiatan' => $spd->tujuan_kegiatan,
            'berangkat_dari' => $spd->berangkat_dari,
            'tempat_tujuan' => is_array($spd->tempat_tujuan) ? implode(', ', $spd->tempat_tujuan) : $spd->tempat_tujuan,
            'lama_kegiatan' => $spd->lama_kegiatan,
            'jenis_perjalanan' => $spd->jenis_perjalanan,
            'alat_angkut' => is_array($spd->alat_angkut) ? implode(', ', $spd->alat_angkut) : $spd->alat_angkut,
            'kode_mak' => $spd->kode_mak,
            'ppk' => $spd->ppk,
            'nama_ppk' => $spd->nama_ppk,
            'nip_ppk' => $spd->nip_ppk,
        ];
    }
}
