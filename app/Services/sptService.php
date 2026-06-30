<?php

namespace App\Services;

use App\Models\Spt;
use Illuminate\Support\Facades\DB;

class SptService
{
    /**
     * Get statistics count for SPTs (preventing N+1 memory loading).
     */
    public function getCounts(): array
    {
        return [
            'all' => Spt::count(),
            'disetujui' => Spt::where('status', 'disetujui')->count(),
            'direvisi' => Spt::where('status', 'direvisi')->count(),
            'ditolak' => Spt::where('status', 'ditolak')->count(),
        ];
    }

    /**
     * Get all SPT records with optional search and filter.
     */
    public function getAllLatest(array $filters = [], int $perPage = 10)
    {
        $query = Spt::query();

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nomor_spt', 'like', '%'.$search.'%')
                    ->orWhere('pegawai_ditugaskan', 'like', '%'.$search.'%')
                    ->orWhere('tujuan_kegiatan', 'like', '%'.$search.'%')
                    ->orWhere('tempat_tujuan', 'like', '%'.$search.'%');
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get an SPT by ID.
     */
    public function getSptById(string $id)
    {
        return Spt::findOrFail($id);
    }

    /**
     * Create a new SPT.
     */
    public function createSpt(array $data)
    {
        return DB::transaction(function () use ($data) {
            return Spt::create($data);
        });
    }

    /**
     * Update an existing SPT.
     */
    public function updateSpt(Spt $spt, array $data)
    {
        return DB::transaction(function () use ($spt, $data) {
            $spt->update($data);

            return $spt;
        });
    }

    /**
     * Delete an SPT.
     */
    public function deleteSpt(Spt $spt)
    {
        return DB::transaction(function () use ($spt) {
            $spt->delete();

            return true;
        });
    }
}