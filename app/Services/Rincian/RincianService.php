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
                    throw new \Exception('Anda tidak memiliki akses untuk membuat Rincian dari SPD ini.');
                }
            }

            // Pastikan belum ada rincian untuk SPD ini
            $existingRincian = Rincian::where('spd_id', $data['spd_id'])->exists();
            if ($existingRincian) {
                throw new \Exception('Rincian untuk SPD ini sudah ada.');
            }

            // Jika ada file lampiran
            $lampiranPath = null;
            if (isset($data['lampiran']) && $data['lampiran'] instanceof UploadedFile) {
                $lampiranPath = $data['lampiran']->store('lampiran_spj', 'public');
            }

            $rincian = Rincian::create([
                'spd_id' => $data['spd_id'],
                'rincian_biaya' => $data['rincian_biaya'] ?? [],
                'status' => Rincian::STATUS_DRAFT,
                'pembuat_id' => $authId,
                'lampiran' => $lampiranPath,
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
            $updateData = [
                'rincian_biaya' => $data['rincian_biaya'] ?? $rincian->rincian_biaya,
                'status' => $data['status'] ?? $rincian->status,
            ];

            // Update lampiran jika ada file baru
            if (isset($data['lampiran']) && $data['lampiran'] instanceof UploadedFile) {
                // Hapus lampiran lama jika ada
                if ($rincian->lampiran) {
                    Storage::disk('public')->delete($rincian->lampiran);
                }
                $updateData['lampiran'] = $data['lampiran']->store('lampiran_spj', 'public');
            }

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
            // Hapus lampiran jika ada
            if ($rincian->lampiran) {
                Storage::disk('public')->delete($rincian->lampiran);
            }

            $rincian->delete();

            session()->flash('success', 'Rincian biaya berhasil dihapus.');

            return true;
        });
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

            // Try to find the matching province
            $uangPenginapan = UangPenginapan::whereIn('provinsi', $tempatTujuans)->first();

            // If not found, try fuzzy match (e.g., destination is "Kota Jambi", province is "Jambi")
            if (! $uangPenginapan) {
                foreach ($tempatTujuans as $tujuan) {
                    if (config('database.default') === 'sqlite') {
                        $uangPenginapan = UangPenginapan::whereRaw('INSTR(LOWER(?), LOWER(provinsi)) > 0', [trim($tujuan)])->first();
                    } else {
                        $uangPenginapan = UangPenginapan::whereRaw('? LIKE CONCAT(\'%\', provinsi, \'%\')', [trim($tujuan)])->first();
                    }
                    if ($uangPenginapan) {
                        break;
                    }

                    // Fallback cek sebaliknya
                    if (! $uangPenginapan) {
                        $uangPenginapan = UangPenginapan::where('provinsi', 'LIKE', '%'.trim($tujuan).'%')->first();
                        if ($uangPenginapan) {
                            break;
                        }
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

            $uangHarian = UangHarian::whereIn('provinsi', $tempatTujuans)->first();

            if (! $uangHarian) {
                foreach ($tempatTujuans as $tujuan) {
                    if (config('database.default') === 'sqlite') {
                        $uangHarian = UangHarian::whereRaw('INSTR(LOWER(?), LOWER(provinsi)) > 0', [trim($tujuan)])->first();
                    } else {
                        $uangHarian = UangHarian::whereRaw('? LIKE CONCAT(\'%\', provinsi, \'%\')', [trim($tujuan)])->first();
                    }
                    if ($uangHarian) {
                        break;
                    }

                    if (! $uangHarian) {
                        $uangHarian = UangHarian::where('provinsi', 'LIKE', '%'.trim($tujuan).'%')->first();
                        if ($uangHarian) {
                            break;
                        }
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