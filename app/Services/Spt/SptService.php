<?php

namespace App\Services\Spt;

use App\Helpers\SptHelper;
use App\Models\Pegawai;
use App\Models\Spt;
use App\Models\SuratDasar;
use Illuminate\Support\Collection;
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
            'diajukan' => (clone $query)->where('status', 'diajukan')->count(),
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

        // Jika user adalah admin atau role monitoring, mereka bisa melihat semua (return tanpa filter)
        if (! $user || $user->isAdmin() || $user->isMonitoring()) {
            return;
        }

        // Jika role user biasa / pembuat_spt, filter berdasarkan pegawai_id mereka di json pegawai_ditugaskan
        $pegawaiId = (int) Pegawai::where('user_id', $user->id)->value('id');

        if ($pegawaiId) {
            $query->where(function ($q) use ($user, $pegawaiId) {
                $q->where('pembuat_id', $user->id)
                    ->orWhere(function ($subQ) use ($pegawaiId) {
                        $subQ->where(function ($jsonQ) use ($pegawaiId) {
                            $jsonQ->whereJsonContains('pegawai_ditugaskan', [['pegawai_id' => (string) $pegawaiId]])
                                ->orWhereJsonContains('pegawai_ditugaskan', [['pegawai_id' => $pegawaiId]]);
                        })->whereIn('status', ['disetujui', 'selesai']);
                    });
            });
        } else {
            // Jika user tidak punya data pegawai, setidaknya mereka bisa lihat yang mereka buat
            $query->where('pembuat_id', $user->id);
        }
    }

    /**
     * Get an SPT by ID with relations.
     */
    public function getSptById(string $id)
    {
        return Spt::with(['spds.rincian'])->findOrFail($id);
    }

    /**
     * Create a new SPT with internal data sanitization.
     */
    public function createSpt(array $data, int $authId)
    {
        return DB::transaction(function () use ($data, $authId) {
            $data['pembuat_id'] = $authId;
            // Status default ke draft
            $data['status'] = $data['status'] ?? Spt::STATUS_DRAFT;

            // Mengantisipasi jika input dari form dikirim dalam bentuk array (sudah di-handle Request)
            $pegawaiData = $data['pegawai_ditugaskan'] ?? [];

            // Ekstrak peran Penanggung Jawab & Anggota untuk kolom flat database
            $processed = SptHelper::extractRoles($pegawaiData);
            $data['penanggung_jawab'] = $processed['penanggung_jawab'];
            $data['anggota'] = $processed['anggota'];
            $data['pegawai_ditugaskan'] = $pegawaiData;

            $spt = Spt::create($data);

            // Sinkron surat_dasar ke tabel master jika diisi
            if (! empty($data['surat_dasar'])) {
                SuratDasar::firstOrCreate(
                    ['teks' => $data['surat_dasar']],
                    ['aktif' => true]
                );
            }

            session()->flash('success', 'SPT berhasil dibuat dan disimpan sebagai Draft.');

            return $spt;
        });
    }

    /**
     * Update an existing SPT.
     */
    public function updateSpt(Spt $spt, array $data)
    {
        return DB::transaction(function () use ($spt, $data) {
            // Mengantisipasi jika input dari form dikirim dalam bentuk array (sudah di-handle Request)
            $pegawaiData = $data['pegawai_ditugaskan'] ?? [];

            // Ekstrak peran Penanggung Jawab & Anggota
            $processed = SptHelper::extractRoles($pegawaiData);
            $data['penanggung_jawab'] = $processed['penanggung_jawab'];
            $data['anggota'] = $processed['anggota'];
            $data['pegawai_ditugaskan'] = $pegawaiData;

            // Jika status berubah menjadi disetujui, beri notifikasi khusus
            if (isset($data['status']) && $data['status'] === Spt::STATUS_APPROVED && $spt->status !== Spt::STATUS_APPROVED) {
                session()->flash('success', 'SPT telah disetujui. Pegawai yang ditugaskan akan menerima notifikasi.');
            }

            $spt->update($data);

            // Sinkron surat_dasar ke tabel master jika diisi
            if (! empty($data['surat_dasar'])) {
                SuratDasar::firstOrCreate(
                    ['teks' => $data['surat_dasar']],
                    ['aktif' => true]
                );
            }

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

            session()->flash('success', 'SPT berhasil dihapus.');

            return true;
        });
    }

    /**
     * Memproses verifikasi SPT (Approve/Reject/Revise) oleh TU/Pimpinan.
     */
    public function verifySpt(Spt $spt, string $status, ?string $catatan, int $verifikatorId)
    {
        return DB::transaction(function () use ($spt, $status, $catatan, $verifikatorId) {
            $spt->update([
                'status' => $status,
                'catatan_verifikator' => $catatan,
                'verifikator_id' => $verifikatorId,
            ]);

            $message = match ($status) {
                Spt::STATUS_APPROVED => 'SPT berhasil disetujui.',
                Spt::STATUS_REVISED => 'SPT dikembalikan untuk direvisi.',
                Spt::STATUS_REJECTED => 'SPT telah ditolak.',
                default => 'Status SPT berhasil diperbarui.',
            };

            session()->flash('success', $message);

            return $spt;
        });
    }

    /**
     * Ambil riwayat surat dasar dari tabel master.
     * Jika tabel master kosong, fallback ke data_spt untuk kompatibilitas mundur.
     */
    public function getRiwayatSuratDasar(int $limit = 100): Collection
    {
        $fromMaster = SuratDasar::aktif()->orderBy('teks')->take($limit)->pluck('teks');

        if ($fromMaster->isNotEmpty()) {
            return $fromMaster;
        }

        // Fallback ke data_spt jika tabel master masih kosong
        return DB::table('data_spt')
            ->whereNotNull('surat_dasar')
            ->where('surat_dasar', '!=', '')
            ->distinct()
            ->orderBy('surat_dasar', 'asc')
            ->take($limit)
            ->pluck('surat_dasar');
    }

    /**
     * Siapkan data SPT beserta relasi pegawai untuk kebutuhan cetak PDF.
     * Menangani kasus di mana pegawai tidak ditemukan di DB (dummy fallback).
     */
    public function getSptForPdf(string $id): Spt
    {
        $spt = Spt::findOrFail($id);

        $pegawaiData = $spt->pegawai_ditugaskan;
        if (is_string($pegawaiData)) {
            $pegawaiData = json_decode($pegawaiData, true);
        }

        $pegawais = collect();
        if (is_array($pegawaiData)) {
            foreach ($pegawaiData as $p) {
                $pegawaiModel = Pegawai::find($p['pegawai_id'] ?? null);
                if ($pegawaiModel) {
                    $pegawaiModel->peran = $p['peran'] ?? 'Anggota';
                    $pegawais->push($pegawaiModel);
                } else {
                    $dummy = new Pegawai([
                        'nama_pegawai' => $p['nama_pegawai'] ?? $p['nama'] ?? '-',
                        'nip' => $p['nip'] ?? '-',
                        'pangkat' => $p['pangkat'] ?? '-',
                        'golongan' => $p['golongan'] ?? '',
                        'jabatan' => $p['jabatan'] ?? '-',
                    ]);
                    $dummy->id = $p['pegawai_id'] ?? 0;
                    $dummy->peran = $p['peran'] ?? 'Anggota';
                    $pegawais->push($dummy);
                }
            }
        }

        $spt->setRelation('pegawais', $pegawais);

        return $spt;
    }
}
