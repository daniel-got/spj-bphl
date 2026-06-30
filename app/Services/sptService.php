<?php

namespace App\Services;

use App\Models\Spt;
use Illuminate\Support\Facades\DB;

class SptService
{
    /**
     * Get all structured data needed for the SPT Index page.
     */
    public function getIndexPageData(array $requestData): array
    {
        $counts = $this->getCounts();

        $filters = [
            'search' => $requestData['search'] ?? null,
            'status' => $requestData['status'] ?? null,
        ];

        $perPage = isset($requestData['per_page']) ? (int) $requestData['per_page'] : 10;
        $spts = $this->getAllLatest($filters, $perPage);

        return compact('counts', 'spts');
    }

    /**
     * Get statistics count for SPTs.
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
     * Create a new SPT with internal data sanitization.
     */
    public function createSpt(array $data, int $authId)
    {
        return DB::transaction(function () use ($data, $authId) {
            $data['pembuat_id'] = $authId;
            $data['status'] = $data['status'] ?? 'draft';

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