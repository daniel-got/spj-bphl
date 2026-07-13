<?php

namespace App\Services\Spt;

use App\Models\Spt;

class SptService
{
    /**
     * Ambil data untuk halaman index beserta filter.
     */
    public function getIndexPageData(array $filters)
    {
        $query = Spt::query();

        if (request()->routeIs('admin.*')) {
            $query->with('pembuat');
        } else {
            $query->where('pembuat_id', auth()->id());
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nomor_spt', 'like', "%{$search}%")
                  ->orWhere('tujuan_kegiatan', 'like', "%{$search}%");
            });
        }

        return [
            'spts' => $query->orderBy('created_at', 'desc')->paginate(10),
        ];
    }

    /**
     * Ambil data SPT berdasarkan ID.
     */
    public function getSptById(string $id): Spt
    {
        return Spt::findOrFail($id);
    }

    /**
     * Membuat data SPT Baru.
     */
    public function createSpt(array $data, int $authId): Spt
    {
        if (isset($data['pegawai_ditugaskan']) && is_array($data['pegawai_ditugaskan'])) {
            $data['pegawai_ditugaskan'] = json_encode($data['pegawai_ditugaskan']);
        }

        $data['pembuat_id'] = $authId;
        $data['status'] = $data['status'] ?? 'draft';

        return Spt::create($data);
    }

    /**
     * Memperbarui data SPT.
     */
    public function updateSpt(Spt $spt, array $data): bool
    {
        if (isset($data['pegawai_ditugaskan']) && is_array($data['pegawai_ditugaskan'])) {
            $data['pegawai_ditugaskan'] = json_encode($data['pegawai_ditugaskan']);
        }

        return $spt->update($data);
    }

    /**
     * Menghapus data SPT.
     */
    public function deleteSpt(Spt $spt): bool
    {
        return $spt->delete();
    }

    public function getRiwayatSuratDasar(int $limit = 50): \Illuminate\Support\Collection
{
    return \Illuminate\Support\Facades\DB::table('data_spt')
        ->whereNotNull('surat_dasar')
        ->where('surat_dasar', '!=', '')
        ->distinct()
        ->orderBy('surat_dasar', 'asc')
        ->take($limit)
        ->pluck('surat_dasar');
}
}