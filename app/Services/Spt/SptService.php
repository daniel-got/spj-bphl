<?php

namespace App\Services\Spt;

use App\Models\Pegawai;
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
        $query = Spt::query();
        $this->applyRoleFilter($query);

        return [
            'all' => (clone $query)->count(),
            'disetujui' => (clone $query)->where('status', 'disetujui')->count(),
            'direvisi' => (clone $query)->where('status', 'direvisi')->count(),
            'ditolak' => (clone $query)->where('status', 'ditolak')->count(),
        ];
    }

    /**
     * Get all SPT records with optional search and filter.
     */
    public function getAllLatest(array $filters = [], int $perPage = 10)
    {
        $query = Spt::query();
        $this->applyRoleFilter($query);

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
     * Terapkan filter berdasarkan role agar pegawai biasa (dan pembuat_spt di menu umum)
     * hanya bisa melihat SPT di mana mereka ditugaskan.
     */
    protected function applyRoleFilter($query): void
    {
        $user = auth()->user();

        // Jika user adalah admin atau role monitoring/verifikator, mereka bisa melihat semua (return tanpa filter)
        if (! $user || ! in_array($user->role, ['user', 'pembuat_spt'])) {
            return;
        }

        // Jika role user biasa / pembuat_spt, filter berdasarkan pegawai_id mereka di json pegawai_ditugaskan
        $pegawaiId = (int) Pegawai::where('user_id', $user->id)->value('id');

        if ($pegawaiId) {
            $query->whereJsonContains('pegawai_ditugaskan', [['pegawai_id' => (string) $pegawaiId]])
                  ->orWhereJsonContains('pegawai_ditugaskan', [['pegawai_id' => $pegawaiId]]);
        } else {
            // Jika user tidak punya data pegawai (harusnya tidak terjadi), sembunyikan semua SPT
            $query->whereRaw('1 = 0');
        }
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

            // Mengantisipasi jika input dari form dikirim dalam bentuk array, bukan string JSON
            $pegawaiData = $data['pegawai_ditugaskan'] ?? '[]';
            if (is_array($pegawaiData)) {
                $pegawaiData = json_encode($pegawaiData);
            }

            // Ekstrak peran Penanggung Jawab & Anggota untuk kolom flat database
            $processed = $this->extractRolesFromPegawaiJson($pegawaiData);
            $data['penanggung_jawab'] = $processed['penanggung_jawab'];
            $data['anggota'] = $processed['anggota'];
            $data['pegawai_ditugaskan'] = json_decode($pegawaiData, true);

            return Spt::create($data);
        });
    }

    /**
     * Update an existing SPT.
     */
    public function updateSpt(Spt $spt, array $data)
    {
        return DB::transaction(function () use ($spt, $data) {
            // Mengantisipasi jika input dari form dikirim dalam bentuk array
            $pegawaiData = $data['pegawai_ditugaskan'] ?? '[]';
            if (is_array($pegawaiData)) {
                $pegawaiData = json_encode($pegawaiData);
            }

            // Ekstrak peran Penanggung Jawab & Anggota
            $processed = $this->extractRolesFromPegawaiJson($pegawaiData);
            $data['penanggung_jawab'] = $processed['penanggung_jawab'];
            $data['anggota'] = $processed['anggota'];
            $data['pegawai_ditugaskan'] = json_decode($pegawaiData, true);

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

    /**
     * Helper untuk memisahkan nama penanggung jawab dan anggota dari string JSON front-end.
     */
    private function extractRolesFromPegawaiJson(string $jsonString): array
    {
        $pegawaiList = json_decode($jsonString, true) ?? [];
        $pjNames = [];
        $anggotaNames = [];

        foreach ($pegawaiList as $pegawai) {
            // Mengantisipasi perbedaan penamaan field ('nama' atau 'nama_pegawai') dari payload test
            $nama = $pegawai['nama_pegawai'] ?? $pegawai['nama'] ?? '';
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
}
