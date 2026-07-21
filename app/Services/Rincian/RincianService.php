<?php

namespace App\Services\Rincian;

use App\Models\Pegawai;
use App\Models\Rincian;
use App\Models\Spd;
use App\Models\UangHarian;
use App\Models\UangPenginapan;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class RincianService
{
    /**
     * Get statistics count for Rincian.
     */
    public function getCounts(bool $strictPersonal = false): array
    {
        $query = Rincian::query();
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
     * Get all Rincian records with optional search and filter.
     */
    public function getAllLatest(array $filters = [], int $perPage = 10, bool $strictPersonal = false)
    {
        $query = Rincian::query();
        $this->applyRoleFilter($query, $strictPersonal);

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('spd', function ($sq) use ($search) {
                    $sq->where('nomor_spd', 'like', '%'.$search.'%')
                        ->orWhere('nip_pegawai', 'like', '%'.$search.'%');
                })
                    ->orWhereHas('spd.spt', function ($stq) use ($search) {
                        $stq->where('tujuan_kegiatan', 'like', '%'.$search.'%')
                            ->orWhere('tempat_tujuan', 'like', '%'.$search.'%');
                    });
            });
        }

        if (! empty($filters['jenis_perjalanan'])) {
            $query->where('jenis_perjalanan', $filters['jenis_perjalanan']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->with(['spd.spt', 'spd.pegawai'])->latest()->paginate($perPage);
    }

    /**
     * Terapkan filter berdasarkan role agar pegawai biasa hanya bisa melihat
     * Rincian miliknya sendiri (atau yang ia buat), dan pembuat_spt bisa melihat
     * yang ia buat dan ditugaskan kepadanya.
     */
    protected function applyRoleFilter($query, bool $strictPersonal = false): void
    {
        $user = auth()->user();

        // Jika strictPersonal tidak aktif dan user adalah admin, verifikator, atau role monitoring, lihat semua
        if (! $strictPersonal && (! $user || $user->isAdmin() || $user->isVerifikator() || $user->isMonitoring())) {
            return;
        }

        $pegawai = Pegawai::where('user_id', $user->id)->first();
        $pegawaiNip = $pegawai?->nip;

        $query->where(function ($q) use ($user, $pegawaiNip) {
            $q->where('pembuat_id', $user->id);

            if ($pegawaiNip) {
                $q->orWhereHas('spd', function ($query) use ($pegawaiNip) {
                    $query->where('nip_pegawai', $pegawaiNip);
                });
            }
        });
    }

    /**
     * Get a Rincian by ID with full chain relations (Bundel SPJ).
     */
    public function getRincianById(string $id)
    {
        return Rincian::with(['spd.spt', 'spd.pegawai', 'pembuat', 'verifikator'])->findOrFail($id);
    }

    /**
     * Create a new Rincian by copying data from Spd.
     */
    public function createRincian(array $data, int $authId)
    {
        return DB::transaction(function () use ($data, $authId) {
            $user = auth()->user();

            // Validasi keamanan: Pastikan SPD yang dipilih boleh diakses oleh user
            if ($user && ! $user->isAdmin() && ! $user->isMonitoring() && ! $user->isVerifikator()) {
                $pegawai = Pegawai::where('user_id', $user->id)->first();
                $nip = $pegawai?->nip;

                $isValidSpd = Spd::where('id', $data['spd_id'])
                    ->where(function ($q) use ($user, $nip) {
                        $q->where('pembuat_id', $user->id);
                        if ($nip) {
                            $q->orWhere('nip_pegawai', $nip);
                        }
                    })->exists();

                if (! $isValidSpd) {
                    throw ValidationException::withMessages([
                        'spd_id' => 'Anda tidak memiliki akses untuk membuat Rincian dari SPD ini.',
                    ]);
                }
            }

            // Pastikan belum ada rincian untuk SPD ini
            $existingRincian = Rincian::where('spd_id', $data['spd_id'])->exists();
            if ($existingRincian) {
                throw ValidationException::withMessages([
                    'spd_id' => 'Rincian untuk SPD ini sudah ada.',
                ]);
            }

            // Proses file lampiran dinamis
            $rincianBiayaProcessed = $this->processRincianBiayaFiles($data['rincian_biaya'] ?? []);

            $rincian = Rincian::create([
                'spd_id' => $data['spd_id'],
                'rincian_biaya' => $rincianBiayaProcessed,
                'status' => Rincian::STATUS_DRAFT,
                'pembuat_id' => $authId,
                'lampiran' => null, // Kolom lampiran lama dikosongkan
            ]);

            session()->flash('success', 'Rincian biaya berhasil disimpan sebagai Draft.');

            return $rincian;
        });
    }

    /**
     * Update an existing Rincian.
     */
    public function updateRincian(Rincian $rincian, array $data)
    {
        return DB::transaction(function () use ($rincian, $data) {
            // Proses file lampiran dinamis
            $newRincianBiaya = $this->processRincianBiayaFiles(
                $data['rincian_biaya'] ?? $rincian->rincian_biaya,
                $rincian->rincian_biaya
            );

            $updateData = [
                'rincian_biaya' => $newRincianBiaya,
                'status' => $data['status'] ?? $rincian->status,
                'lampiran' => null, // Hapus lampiran lama di root jika ada
            ];

            // Jika status berubah menjadi diajukan, beri notifikasi khusus untuk verifikator
            if (isset($data['status']) && $data['status'] === Rincian::STATUS_SUBMITTED && $rincian->status !== Rincian::STATUS_SUBMITTED) {
                session()->flash('success', 'Bundel SPJ telah diajukan ke Verifikator.');
            } else {
                session()->flash('success', 'Rincian biaya berhasil diperbarui.');
            }

            $rincian->update($updateData);

            return $rincian;
        });
    }

    /**
     * Delete a Rincian.
     */
    public function deleteRincian(Rincian $rincian)
    {
        return DB::transaction(function () use ($rincian) {
            // Hapus lampiran lama di kolom tunggal jika ada
            if ($rincian->lampiran) {
                Storage::disk(config('filesystems.default', 'public'))->delete($rincian->lampiran);
            }

            // Hapus semua file lampiran di dalam rincian_biaya
            $disk = config('filesystems.default', 'public');
            $rb = $rincian->rincian_biaya;
            if (is_array($rb)) {
                if (isset($rb['transport']) && is_array($rb['transport'])) {
                    foreach ($rb['transport'] as $kategori => $items) {
                        foreach ($items as $item) {
                            if (! empty($item['lampiran'])) {
                                Storage::disk($disk)->delete($item['lampiran']);
                            }
                        }
                    }
                }
                if (isset($rb['penginapan']) && is_array($rb['penginapan'])) {
                    foreach ($rb['penginapan'] as $item) {
                        if (! empty($item['lampiran'])) {
                            Storage::disk($disk)->delete($item['lampiran']);
                        }
                    }
                }
            }

            $rincian->delete();

            session()->flash('success', 'Rincian biaya berhasil dihapus.');

            return true;
        });
    }

    /**
     * Memproses upload file dalam rincian biaya dinamis
     */
    protected function processRincianBiayaFiles(array $rincianBiaya, ?array $oldRincianBiaya = null): array
    {
        $disk = config('filesystems.default', 'public');

        if (isset($rincianBiaya['transport']) && is_array($rincianBiaya['transport'])) {
            foreach ($rincianBiaya['transport'] as $kategori => &$items) {
                foreach ($items as $index => &$item) {
                    if (isset($item['lampiran']) && $item['lampiran'] instanceof UploadedFile) {
                        // Hapus lampiran lama jika diupload ulang
                        if ($oldRincianBiaya && isset($oldRincianBiaya['transport'][$kategori][$index]['lampiran'])) {
                            Storage::disk($disk)->delete($oldRincianBiaya['transport'][$kategori][$index]['lampiran']);
                        }
                        $item['lampiran'] = $item['lampiran']->store('lampiran_spj', $disk);
                    } elseif ($oldRincianBiaya && isset($oldRincianBiaya['transport'][$kategori][$index]['lampiran'])) {
                        // Pertahankan lampiran lama jika tidak ada file baru
                        $item['lampiran'] = $oldRincianBiaya['transport'][$kategori][$index]['lampiran'];
                    }
                }
            }
        }

        if (isset($rincianBiaya['penginapan']) && is_array($rincianBiaya['penginapan'])) {
            foreach ($rincianBiaya['penginapan'] as $index => &$item) {
                if (isset($item['lampiran']) && $item['lampiran'] instanceof UploadedFile) {
                    // Hapus lampiran lama jika diupload ulang
                    if ($oldRincianBiaya && isset($oldRincianBiaya['penginapan'][$index]['lampiran'])) {
                        Storage::disk($disk)->delete($oldRincianBiaya['penginapan'][$index]['lampiran']);
                    }
                    $item['lampiran'] = $item['lampiran']->store('lampiran_spj', $disk);
                } elseif ($oldRincianBiaya && isset($oldRincianBiaya['penginapan'][$index]['lampiran'])) {
                    $item['lampiran'] = $oldRincianBiaya['penginapan'][$index]['lampiran'];
                }
            }
        }

        return $rincianBiaya;
    }

    /**
     * Memproses verifikasi SPJ (Approve/Reject/Revise) oleh Verifikator Keuangan.
     */
    public function verifySpj(Rincian $rincian, string $status, ?string $catatan, int $verifikatorId)
    {
        return DB::transaction(function () use ($rincian, $status, $catatan, $verifikatorId) {
            $rincian->update([
                'status' => $status,
                'catatan_verifikator' => $catatan,
                'verifikator_id' => $verifikatorId,
            ]);

            $message = match ($status) {
                Rincian::STATUS_APPROVED => 'Bundel SPJ berhasil disetujui.',
                Rincian::STATUS_REVISED => 'Bundel SPJ dikembalikan untuk direvisi.',
                Rincian::STATUS_REJECTED => 'Bundel SPJ telah ditolak.',
                default => 'Status Bundel SPJ berhasil diperbarui.',
            };

            session()->flash('success', $message);

            return $rincian;
        });
    }

    public function searchSpd($query = '')
    {
        $user = auth()->user();
        $q = Spd::query();

        // Jangan tampilkan SPD yang sudah memiliki rincian
        $q->whereDoesntHave('rincian');

        if ($user && ! $user->isAdmin() && ! $user->isMonitoring() && ! $user->isVerifikator()) {
            $pegawai = Pegawai::where('user_id', $user->id)->first();
            $nip = $pegawai?->nip;

            $q->where(function ($queryBuilder) use ($user, $nip) {
                $queryBuilder->where('pembuat_id', $user->id);
                if ($nip) {
                    $queryBuilder->orWhere('nip_pegawai', $nip);
                }
            });
        }

        return $q->when($query, function ($q) use ($query) {
            $q->where('nomor_spd', 'like', "%{$query}%");
        })
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($spd) {
                return [
                    'id' => $spd->id,
                    'text' => $spd->nomor_spd,
                ];
            });
    }

    public function getSpdAjax($id)
    {
        $user = auth()->user();
        $q = Spd::with(['spt', 'pegawai']);

        if ($user && ! $user->isAdmin() && ! $user->isMonitoring() && ! $user->isVerifikator()) {
            $pegawai = Pegawai::where('user_id', $user->id)->first();
            $nip = $pegawai?->nip;

            $q->where(function ($queryBuilder) use ($user, $nip) {
                $queryBuilder->where('pembuat_id', $user->id);
                if ($nip) {
                    $queryBuilder->orWhere('nip_pegawai', $nip);
                }
            });
        }

        $spd = $q->find($id);

        if (! $spd) {
            return [];
        }

        // Determine rate penginapan
        $penginapanRate = $this->calculatePenginapanRate($spd);

        return [
            'nomor_spd' => $spd->nomor_spd,
            'tgl_spd' => $spd->tgl_spd?->format('Y-m-d'),
            // SPD dibuat per akun: pegawai yang ditugaskan adalah satu orang (nama dari data_pegawai via nip).
            'pegawai_ditugaskan' => $spd->pegawai_ditugaskan,
            'nip_pegawai' => $spd->nip_pegawai,
            'tujuan_kegiatan' => $spd->tujuan_kegiatan,
            'berangkat_dari' => $spd->berangkat_dari,
            'tempat_tujuan' => is_array($spd->tempat_tujuan) ? implode(', ', $spd->tempat_tujuan) : $spd->tempat_tujuan,
            'lama_kegiatan' => $spd->lama_kegiatan,
            'jenis_perjalanan' => $spd->jenis_perjalanan,
            'alat_angkut' => is_array($spd->alat_angkut) ? implode(', ', $spd->alat_angkut) : $spd->alat_angkut,
            'kode_mak' => $spd->kode_mak,
            'ppk' => $spd->ppk,
            'nama_ppk' => $spd->nama_ppk,
            'nip_ppk' => $spd->nip_ppk,
            'penginapan_rate' => $penginapanRate,
        ];
    }

    public function calculatePenginapanRate(Spd $spd)
    {
        $penginapanRate = 0;
        if ($spd->pegawai && $spd->tempat_tujuan) {
            $golongan = $spd->pegawai->golongan;
            $tempatTujuans = is_array($spd->tempat_tujuan) ? $spd->tempat_tujuan : [$spd->tempat_tujuan];

            // Ambil seluruh data dari cache, lalu cari kecocokan in-memory (tanpa query DB)
            $allPenginapan = UangPenginapan::getCachedAll();

            // Cari exact match berdasarkan provinsi
            $uangPenginapan = $allPenginapan->whereIn('provinsi', $tempatTujuans)->first();

            // Jika tidak ditemukan, coba fuzzy match
            if (! $uangPenginapan) {
                foreach ($tempatTujuans as $tujuan) {
                    $tujuanLower = strtolower(trim($tujuan));

                    $uangPenginapan = $allPenginapan->first(function ($item) use ($tujuanLower) {
                        $provinsiLower = strtolower($item->provinsi);

                        return str_contains($tujuanLower, $provinsiLower) || str_contains($provinsiLower, $tujuanLower);
                    });

                    if ($uangPenginapan) {
                        break;
                    }
                }
            }

            if ($uangPenginapan) {
                if (in_array(strtoupper($golongan), ['IV/A', 'IV/B', 'IV/C', 'IV/D', 'IV/E', 'IV'])) {
                    $penginapanRate = $uangPenginapan->gol_iv;
                } else {
                    $penginapanRate = $uangPenginapan->gol_iii_ii_i;
                }
            }
        }

        return $penginapanRate;
    }

    public function calculateUangHarianRate(Spd $spd)
    {
        $rate = 0;
        if ($spd->tempat_tujuan) {
            $tempatTujuans = is_array($spd->tempat_tujuan) ? $spd->tempat_tujuan : [$spd->tempat_tujuan];

            // Ambil seluruh data dari cache, lalu cari kecocokan in-memory
            $allUangHarian = UangHarian::getCachedAll();

            $uangHarian = $allUangHarian->whereIn('provinsi', $tempatTujuans)->first();

            if (! $uangHarian) {
                foreach ($tempatTujuans as $tujuan) {
                    $tujuanLower = strtolower(trim($tujuan));

                    $uangHarian = $allUangHarian->first(function ($item) use ($tujuanLower) {
                        $provinsiLower = strtolower($item->provinsi);

                        return str_contains($tujuanLower, $provinsiLower) || str_contains($provinsiLower, $tujuanLower);
                    });

                    if ($uangHarian) {
                        break;
                    }
                }
            }

            if ($uangHarian) {
                if ($spd->jenis_perjalanan == 'Dalam Kota') {
                    $rate = $uangHarian->dalam_kota_lebih_8_jam;
                } elseif ($spd->jenis_perjalanan == 'Diklat') {
                    $rate = $uangHarian->diklat;
                } else {
                    $rate = $uangHarian->luar_kota;
                }
            }
        }

        return (int) $rate;
    }
}
