<?php

namespace App\Services;

use App\Models\Spd;
use Illuminate\Support\Facades\DB;

class SpdService
{
    /**
     * Get all SPD records with optional search and filter.
     */
    public function getAllLatest(array $filters = [])
    {
        $query = Spd::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('nomor_spd', 'like', '%' . $search . '%')
                  ->orWhere('pegawai_ditugaskan', 'like', '%' . $search . '%')
                  ->orWhere('tujuan_kegiatan', 'like', '%' . $search . '%')
                  ->orWhere('tempat_tujuan', 'like', '%' . $search . '%');
            });
        }

        if (!empty($filters['jenis_perjalanan'])) {
            $query->where('jenis_perjalanan', $filters['jenis_perjalanan']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->get();
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
}
