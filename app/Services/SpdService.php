<?php

namespace App\Services;

use App\Models\Spd;
use App\Models\Spt;
use Illuminate\Support\Facades\DB;

class SpdService
{
    /**
     * Get statistics count for SPDs (preventing N+1 memory loading).
     */
    public function getCounts(): array
    {
        return [
            'all' => Spd::count(),
            'disetujui' => Spd::where('status', 'disetujui')->count(),
            'direvisi' => Spd::where('status', 'direvisi')->count(),
            'ditolak' => Spd::where('status', 'ditolak')->count(),
        ];
    }

    /**
     * Get all SPD records with optional search and filter.
     */
    public function getAllLatest(array $filters = [], int $perPage = 10)
    {
        $query = Spd::query();

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
     * Get an SPD by ID.
     */
    public function getSpdById(string $id)
    {
        return Spd::findOrFail($id);
    }

    /**
     * Create a new SPD.
     */
    public function createSpd(array $data)
    {
        return DB::transaction(function () use ($data) {
            $data['pembuat_id'] = $data['pembuat_id'] ?? auth()->id();
            return Spd::create($data);
        });
    }

    /**
     * Update an existing SPD.
     */
    public function updateSpd(Spd $spd, array $data)
    {
        return DB::transaction(function () use ($spd, $data) {
            $spd->update($data);

            return $spd;
        });
    }

    /**
     * Delete an SPD.
     */
    public function deleteSpd(Spd $spd)
    {
        return DB::transaction(function () use ($spd) {
            $spd->delete();

            return true;
        });
    }

    /**
     * Search SPT for autocomplete/Select2.
     */
    public function searchSpt(?string $search): array
    {
        return Spt::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nomor_spt', 'like', "%{$search}%")
                      ->orWhere('tujuan_kegiatan', 'like', "%{$search}%");
            })
            ->limit(15)
            ->get()
            ->map(fn ($spt) => [
                'id' => $spt->id,
                'text' => $spt->nomor_spt,
            ])
            ->toArray();
    }

    /**
     * Get single SPT data via AJAX.
     */
    public function getSptAjax(string $id): array
    {
        $spt = Spt::findOrFail($id);

        $pegawaiList = is_string($spt->pegawai_ditugaskan)
            ? json_decode($spt->pegawai_ditugaskan, true)
            : $spt->pegawai_ditugaskan;

        return [
            'id' => $spt->id,
            'nomor_spt' => $spt->nomor_spt,
            'tujuan_kegiatan' => $spt->tujuan_kegiatan,
            'tempat_tujuan' => $spt->tempat_tujuan,
            'tgl_berangkat' => $spt->tgl_berangkat ? $spt->tgl_berangkat->format('Y-m-d') : null,
            'tgl_kembali' => $spt->tgl_kembali ? $spt->tgl_kembali->format('Y-m-d') : null,
            'lama_kegiatan' => $spt->lama_kegiatan,
            'kode_mak' => $spt->kode_mak,
            'pegawai_list' => $pegawaiList,
        ];
    }
}
