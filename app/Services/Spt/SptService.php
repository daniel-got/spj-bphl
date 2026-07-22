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
    public function getIndexPageData(array $requestData, bool $strictPersonal = false): array
    {
        $counts = $this->getCounts($strictPersonal);

        $filters = [
            'search' => $requestData['search'] ?? null,
            'status' => $requestData['status'] ?? null,
        ];

        $perPage = isset($requestData['per_page']) ? (int) $requestData['per_page'] : 10;
        $spts = $this->getAllLatest($filters, $perPage, $strictPersonal);

        return compact('counts', 'spts');
    }

    /**
     * Get statistics count for SPTs.
     */
    public function getCounts(bool $strictPersonal = false): array
    {
        $query = Spt::query();
        $this->applyRoleFilter($query, $strictPersonal);

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
    public function getAllLatest(array $filters = [], int $perPage = 10, bool $strictPersonal = false)
    {
        $query = Spt::query();
        $this->applyRoleFilter($query, $strictPersonal);

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

    protected function applyRoleFilter($query, bool $strictPersonal = false): void
    {
        $user = auth()->user();

        // Bypass filter untuk admin, monitoring, dan verifikator, kecuali jika dalam mode "SPT Saya" (strictPersonal)
        if (! $strictPersonal && (! $user || $user->isAdmin() || $user->isMonitoring() || $user->isVerifikator())) {
            return;
        }

        $pegawaiId = (int) Pegawai::where('user_id', $user->id)->value('id');

        if ($strictPersonal) {
            // Mode "SPT Saya": hanya tampilkan SPT yang user ini DITUGASKAN padanya.
            if ($pegawaiId) {
                $query->where(function ($q) use ($pegawaiId) {
                    // Gunakan LIKE sebagai pencocokan universal untuk menghindari masalah tipe data
                    // integer vs string pada kolom jsonb di PostgreSQL
                    $q->where('pegawai_ditugaskan', 'like', '%"pegawai_id":'.$pegawaiId.'%')
                        ->orWhere('pegawai_ditugaskan', 'like', '%"pegawai_id":"'.$pegawaiId.'"%');
                })->whereIn('status', ['disetujui', 'selesai']);
            } else {
                // Tidak punya profil pegawai — tidak bisa melihat SPT siapapun
                $query->whereRaw('1 = 0');
            }
        } else {
            // Mode non-strict (misal: pembuat_spt di halaman umum):
            // Tampilkan SPT miliknya sendiri (pembuat_id) OR ditugaskan padanya (disetujui/selesai).
            $query->where(function ($q) use ($user, $pegawaiId) {
                $q->where('pembuat_id', $user->id);

                if ($pegawaiId) {
                    $q->orWhere(function ($subQ) use ($pegawaiId) {
                        $subQ->where(function ($jsonQ) use ($pegawaiId) {
                            $jsonQ->where('pegawai_ditugaskan', 'like', '%"pegawai_id":'.$pegawaiId.'%')
                                ->orWhere('pegawai_ditugaskan', 'like', '%"pegawai_id":"'.$pegawaiId.'"%');
                        })->whereIn('status', ['disetujui', 'selesai']);
                    });
                }
            });
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

            // Sinkronisasi poin acuan surat_dasar ke tabel master secara otomatis
            $this->syncSuratDasarMaster($data['surat_dasar'] ?? null, $data['jenis_tugas'] ?? null);

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
            // Hanya proses dan timpa data pegawai jika key 'pegawai_ditugaskan' memang dikirimkan.
            // Ini mencegah operasi lain seperti submit() (yang hanya mengirim ['status'=>...])
            // menghapus data pegawai yang sudah tersimpan.
            if (array_key_exists('pegawai_ditugaskan', $data)) {
                $pegawaiData = $data['pegawai_ditugaskan'] ?? [];
                $processed = SptHelper::extractRoles($pegawaiData);
                $data['penanggung_jawab'] = $processed['penanggung_jawab'];
                $data['anggota'] = $processed['anggota'];
                $data['pegawai_ditugaskan'] = $pegawaiData;
            }

            // Jika status berubah menjadi disetujui, beri notifikasi khusus
            if (isset($data['status']) && $data['status'] === Spt::STATUS_APPROVED && $spt->status !== Spt::STATUS_APPROVED) {
                session()->flash('success', 'SPT telah disetujui. Pegawai yang ditugaskan akan menerima notifikasi.');
            }

            $spt->update($data);

            // Sinkronisasi poin acuan surat_dasar ke tabel master secara otomatis
            $this->syncSuratDasarMaster($spt->surat_dasar, $spt->jenis_tugas);

            return $spt;
        });
    }

    /**
     * Sinkronisasi setiap poin acuan ke tabel master data jika belum ada.
     */
    private function syncSuratDasarMaster(?string $suratDasarText, ?string $jenisSpt): void
    {
        if (empty($suratDasarText)) {
            return;
        }

        $customJsonPath = database_path('seeders/custom_surat_dasar.json');
        $customPoints = file_exists($customJsonPath)
            ? json_decode(file_get_contents($customJsonPath), true) ?: []
            : [];

        $jsonChanged = false;
        $points = explode("\n", $suratDasarText);

        foreach ($points as $point) {
            $cleanPoint = trim(preg_replace('/^\d+\.\s*/', '', $point));
            if ($cleanPoint === '') {
                continue;
            }

            $record = SuratDasar::firstOrCreate(
                [
                    'teks' => $cleanPoint,
                    'jenis_spt' => $jenisSpt,
                ],
                [
                    'aktif' => true,
                ]
            );

            if ($record->wasRecentlyCreated) {
                // Tambahkan ke file persistence json agar tidak hilang saat migrate:fresh
                $alreadyInJson = collect($customPoints)->contains(function ($item) use ($cleanPoint, $jenisSpt) {
                    return ($item['teks'] ?? '') === $cleanPoint && ($item['jenis_spt'] ?? null) === $jenisSpt;
                });

                if (! $alreadyInJson) {
                    $customPoints[] = [
                        'teks' => $cleanPoint,
                        'jenis_spt' => $jenisSpt,
                        'aktif' => true,
                    ];
                    $jsonChanged = true;
                }
            }
        }

        if ($jsonChanged) {
            file_put_contents($customJsonPath, json_encode(array_values($customPoints), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
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
