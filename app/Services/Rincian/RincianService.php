<?php

namespace App\Services\Rincian;

use App\Models\Pegawai;
use App\Models\Rincian;
use App\Models\Spd;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RincianService
{
    /**
     * Get statistics count for Rincian.
     */
    public function getCounts(): array
    {
        $query = Rincian::query();
        $this->applyRoleFilter($query);

        return [
            'all' => (clone $query)->count(),
            'disetujui' => (clone $query)->where('status', 'disetujui')->count(),
            'direvisi' => (clone $query)->where('status', 'direvisi')->count(),
            'ditolak' => (clone $query)->where('status', 'ditolak')->count(),
        ];
    }

    /**
     * Get all Rincian records with optional search and filter.
     */
    public function getAllLatest(array $filters = [], int $perPage = 10)
    {
        $query = Rincian::query();
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
     * Rincian miliknya sendiri (atau yang ia buat), dan pembuat_spt bisa melihat
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
     * Get a Rincian by ID.
     */
    public function getRincianById(string $id)
    {
        return Rincian::findOrFail($id);
    }

    /**
     * Create a new Rincian by copying data from Spd.
     */
    public function createRincian(array $data, int $authId)
    {
        return DB::transaction(function () use ($data, $authId) {
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

    public function searchSpd($query = '')
    {
        return Spd::when($query, function ($q) use ($query) {
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
        $spd = Spd::with('spt')->find($id);

        if (! $spd) {
            return [];
        }

        return [
            'nomor_spd' => $spd->nomor_spd,
            'tgl_spd' => $spd->tgl_spd,
            'pegawai_ditugaskan' => $spd->spt?->pegawai_ditugaskan,
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
        ];
    }
}
