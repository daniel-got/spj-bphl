<?php

namespace App\Services\Spt;

use App\Models\Pegawai;
use App\Models\Spt;
use Illuminate\Support\Facades\Auth;

class PembuatSptService
{
    /**
     * Ambil semua data untuk halaman index Pembuat SPT.
     *
     * @param  array<string, mixed>  $requestData
     * @return array<string, mixed>
     */
    public function getIndexPageData(array $requestData): array
    {
        $userId = Auth::id();

        $counts = $this->getCounts($userId);

        $filters = [
            'search' => $requestData['search'] ?? null,
            'status' => $requestData['status'] ?? null,
        ];

        $perPage = isset($requestData['per_page']) ? (int) $requestData['per_page'] : 10;

        $spts = $this->getRiwayatSpt($userId, $filters, $perPage);

        return compact('counts', 'spts');
    }

    /**
     * Hitung statistik SPT milik pembuat ini:
     * - Dibuat oleh user ini (pembuat_id)
     * - Ditugaskan kepada user ini (ada di JSON pegawai_ditugaskan)
     *
     * @return array<string, int>
     */
    public function getCounts(int $userId): array
    {
        $pegawai = Pegawai::where('user_id', $userId)->first();
        $pegawaiId = $pegawai?->id;

        $baseQuery = Spt::where(function ($q) use ($userId, $pegawaiId) {
            $q->where('pembuat_id', $userId);
            if ($pegawaiId) {
                $q->orWhere(function ($subQ) use ($pegawaiId) {
                    $subQ->where(function ($jsonQ) use ($pegawaiId) {
                        $jsonQ->whereJsonContains('pegawai_ditugaskan', ['pegawai_id' => (string) $pegawaiId])
                            ->orWhereJsonContains('pegawai_ditugaskan', ['pegawai_id' => $pegawaiId]);
                    })->whereIn('status', ['disetujui', 'selesai']);
                });
            }
        });

        $sptIds = (clone $baseQuery)->pluck('id');

        return [
            'dibuat' => Spt::where('pembuat_id', $userId)->count(),
            'disetujui' => Spt::whereIn('id', $sptIds)->where('status', 'disetujui')->count(),
            'ditolak' => Spt::whereIn('id', $sptIds)->where('status', 'ditolak')->count(),
            'selesai' => Spt::whereIn('id', $sptIds)->where('status', 'selesai')->count(),
        ];
    }

    /**
     * Ambil riwayat SPT yang dibuat atau yang menugaskan user ini.
     *
     * @param  array<string, mixed>  $filters
     */
    public function getRiwayatSpt(int $userId, array $filters = [], int $perPage = 10)
    {
        $pegawai = Pegawai::where('user_id', $userId)->first();
        $pegawaiId = $pegawai?->id;

        $query = Spt::where(function ($q) use ($userId, $pegawaiId) {
            $q->where('pembuat_id', $userId);
            if ($pegawaiId) {
                $q->orWhere(function ($subQ) use ($pegawaiId) {
                    $subQ->where(function ($jsonQ) use ($pegawaiId) {
                        $jsonQ->whereJsonContains('pegawai_ditugaskan', ['pegawai_id' => (string) $pegawaiId])
                            ->orWhereJsonContains('pegawai_ditugaskan', ['pegawai_id' => $pegawaiId]);
                    })->whereIn('status', ['disetujui', 'selesai']);
                });
            }
        });

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nomor_spt', 'like', '%'.$search.'%')
                    ->orWhere('tujuan_kegiatan', 'like', '%'.$search.'%')
                    ->orWhere('tempat_tujuan', 'like', '%'.$search.'%');
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->paginate($perPage);
    }
}
