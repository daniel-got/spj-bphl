<?php

namespace App\Services\Kwitansi;

use App\Models\Kwitansi;
use App\Models\Pegawai;

class KwitansiService
{
    /**
     * Get all Kwitansi records with optional search and filter.
     */
    public function getAllLatest(array $filters = [], int $perPage = 10, bool $strictPersonal = false)
    {
        $query = Kwitansi::with(['rincian.spd.spt', 'rincian.spd.pegawai', 'rincian.pembuat']);
        
        $this->applyRoleFilter($query, $strictPersonal);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nomor_kwitansi', 'ilike', "%{$search}%")
                    ->orWhereHas('rincian.spd', function ($sq) use ($search) {
                        $sq->where('nomor_spd', 'ilike', "%{$search}%")
                            ->orWhereHas('pegawai', function ($pq) use ($search) {
                                $pq->where('nama_pegawai', 'ilike', "%{$search}%");
                            });
                    });
            });
        }

        return $query->latest()->paginate($perPage);
    }

    protected function applyRoleFilter($query, bool $strictPersonal = false): void
    {
        $user = auth()->user();

        // Bypass filter untuk admin dan monitoring, kecuali jika dalam mode strictPersonal
        if (! $strictPersonal && (! $user || $user->isAdmin() || $user->isMonitoring())) {
            return;
        }

        if ($user) {
            $pegawaiNip = Pegawai::where('user_id', $user->id)->value('nip');

            $query->whereHas('rincian', function ($q) use ($user, $pegawaiNip) {
                $q->where(function ($query) use ($user, $pegawaiNip) {
                    $query->where('pembuat_id', $user->id);
                    if ($pegawaiNip) {
                        $query->orWhereHas('spd', function ($sq) use ($pegawaiNip) {
                            $sq->where('nip_pegawai', $pegawaiNip);
                        });
                    }
                });
            });
        }
    }
}
