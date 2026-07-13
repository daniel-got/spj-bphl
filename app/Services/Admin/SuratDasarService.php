<?php

namespace App\Services\Admin;

use App\Models\SuratDasar;
use Illuminate\Support\Facades\DB;

class SuratDasarService
{
    /**
     * Ambil semua surat dasar dengan pencarian dan paginasi.
     */
    public function getAllPaginated(?string $keyword = null, int $perPage = 15)
    {
        return SuratDasar::search($keyword)->latest()->paginate($perPage);
    }

    /**
     * Ambil daftar surat dasar yang aktif untuk dropdown di form SPT.
     * Setelah tabel master dibuat, SptService mengambil dari sini.
     */
    public function getAktif(int $limit = 100)
    {
        return SuratDasar::aktif()->orderBy('teks')->take($limit)->pluck('teks');
    }

    /**
     * Simpan surat dasar baru ke tabel master.
     * Jika teks sudah ada (dari hasil input manual SPT), update saja agar tidak duplikat.
     */
    public function createOrUpdate(array $data): SuratDasar
    {
        return SuratDasar::updateOrCreate(
            ['teks' => $data['teks']],
            ['aktif' => $data['aktif'] ?? true]
        );
    }

    /**
     * Perbarui data surat dasar yang sudah ada.
     */
    public function update(SuratDasar $suratDasar, array $data): SuratDasar
    {
        $suratDasar->update([
            'teks' => $data['teks'],
            'aktif' => $data['aktif'] ?? $suratDasar->aktif,
        ]);

        return $suratDasar->fresh();
    }

    /**
     * Hapus surat dasar dari master.
     */
    public function delete(SuratDasar $suratDasar): bool
    {
        return (bool) $suratDasar->delete();
    }

    /**
     * Toggle status aktif/nonaktif.
     */
    public function toggleAktif(SuratDasar $suratDasar): SuratDasar
    {
        $suratDasar->update(['aktif' => ! $suratDasar->aktif]);

        return $suratDasar->fresh();
    }

    /**
     * Sinkronisasi otomatis: import semua surat_dasar unik dari data_spt ke tabel master.
     * Berguna untuk migrasi data lama yang sudah ada di SPT sebelum tabel master dibuat.
     */
    public function sinkronDariSpt(): int
    {
        $teksFromSpt = DB::table('data_spt')
            ->whereNotNull('surat_dasar')
            ->where('surat_dasar', '!=', '')
            ->distinct()
            ->pluck('surat_dasar');

        $imported = 0;
        foreach ($teksFromSpt as $teks) {
            $created = SuratDasar::firstOrCreate(
                ['teks' => $teks],
                ['aktif' => true]
            );
            if ($created->wasRecentlyCreated) {
                $imported++;
            }
        }

        return $imported;
    }
}
