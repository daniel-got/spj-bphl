<?php

namespace App\Services\Spd;

use App\Models\Pegawai;
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
        $query = Spd::query();
        $this->applyRoleFilter($query);

        return [
            'all' => (clone $query)->count(),
            'disetujui' => (clone $query)->where('status', 'disetujui')->count(),
            'direvisi' => (clone $query)->where('status', 'direvisi')->count(),
            'ditolak' => (clone $query)->where('status', 'ditolak')->count(),
        ];
    }

    /**
     * Get all SPD records with optional search and filter.
     */
    public function getAllLatest(array $filters = [], int $perPage = 10)
    {
        $query = Spd::query();
        $this->applyRoleFilter($query);

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
     * Terapkan filter berdasarkan role agar pegawai biasa hanya bisa melihat
     * SPD miliknya sendiri (atau yang ia buat), dan pembuat_spt bisa melihat
     * yang ia buat dan ditugaskan kepadanya.
     */
    protected function applyRoleFilter($query): void
    {
        $user = auth()->user();

        // Jika user adalah admin atau role monitoring/verifikator, lihat semua
        if (! $user || ! in_array($user->role, ['user', 'pembuat_spt'])) {
            return;
        }

        $pegawai = Pegawai::where('user_id', $user->id)->first();
        $pegawaiNip = $pegawai?->nip;

        $query->where(function ($q) use ($user, $pegawaiNip) {
            $q->where('pembuat_id', $user->id);

            if ($pegawaiNip) {
                $q->orWhere('nip_pegawai', $pegawaiNip);
            }
        });
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
            // Default status SPD adalah draft
            $data['status'] = $data['status'] ?? 'draft';

            $spd = Spd::create($data);

            session()->flash('success', 'SPD berhasil dibuat sebagai Draft.');

            return $spd;
        });
    }

    /**
     * Update an existing SPD.
     */
    public function updateSpd(Spd $spd, array $data)
    {
        return DB::transaction(function () use ($spd, $data) {
            $spd->update($data);

            session()->flash('success', 'SPD berhasil diperbarui.');

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

            session()->flash('success', 'SPD berhasil dihapus.');

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

        return [
            'id' => $spt->id,
            'nomor_spt' => $spt->nomor_spt,
            'tujuan_kegiatan' => $spt->tujuan_kegiatan,
            'tempat_tujuan' => $spt->tempat_tujuan,
            'tgl_berangkat' => $spt->tgl_berangkat ? $spt->tgl_berangkat->format('Y-m-d') : null,
            'tgl_kembali' => $spt->tgl_kembali ? $spt->tgl_kembali->format('Y-m-d') : null,
            'lama_kegiatan' => $spt->lama_kegiatan,
            'kode_mak' => $spt->kode_mak,
            'pegawai_list' => $spt->pegawai_ditugaskan,
        ];
    }
}
