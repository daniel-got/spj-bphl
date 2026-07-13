<?php

namespace App\Services\User;

use App\Models\Spt;
use App\Models\Spd;
use App\Models\Rincian;
use Illuminate\Support\Collection;

/**
 * DashboardService — Logika bisnis untuk Dashboard Pegawai/User.
 */
class DashboardService
{
    /**
     * Mengumpulkan semua data yang dibutuhkan untuk halaman Dashboard Pegawai.
     */
    public function getDashboardData(int $userId, ?string $status = null): array
    {
        $stats = $this->getStatCards($userId);
        $recentDocuments = $this->getRecentDocuments($userId, $status);
        $documentSummary = $this->getDocumentSummary($userId);
        $revisionCount = $this->getRevisionCount($userId);

        return [
            'stats' => $stats,
            'recentDocuments' => $recentDocuments,
            'documentSummary' => $documentSummary,
            'revisionCount' => $revisionCount,
        ];
    }

    /**
     * Data untuk 4 kartu statistik di bagian atas dashboard pegawai.
     */
    private function getStatCards(int $userId): array
    {
        $totalSpt = Spt::where('pembuat_id', $userId)->count();
        $totalSpd = Spd::where('pembuat_id', $userId)->count();
        $totalRincian = Rincian::where('pembuat_id', $userId)->count();
        $totalLaporan = 0; // Placeholder karena model Laporan belum diimplementasikan

        return [
            [
                'title' => 'Total SPT',
                'value' => $totalSpt,
                'description' => 'Surat Perintah Tugas dibuat',
                'icon' => 'document-text',
                'color' => 'blue',
            ],
            [
                'title' => 'Total SPD',
                'value' => $totalSpd,
                'description' => 'Surat Perjalanan Dinas dibuat',
                'icon' => 'document',
                'color' => 'green',
            ],
            [
                'title' => 'Total Rincian Biaya',
                'value' => $totalRincian,
                'description' => 'Rincian Biaya diajukan',
                'icon' => 'clipboard-check',
                'color' => 'yellow',
            ],
            [
                'title' => 'Total Laporan',
                'value' => $totalLaporan,
                'description' => 'Laporan Pertanggungjawaban',
                'icon' => 'chart-bar',
                'color' => 'green',
            ],
        ];
    }

    /**
     * Mengambil dokumen terbaru milik user, dengan filter status opsional.
     */
    private function getRecentDocuments(int $userId, ?string $status = null): Collection
    {
        $sptQuery = Spt::where('pembuat_id', $userId);
        $spdQuery = Spd::where('pembuat_id', $userId);
        $rincianQuery = Rincian::where('pembuat_id', $userId);

        if ($status && $status !== 'all') {
            $sptQuery->where('status', $status);
            $spdQuery->where('status', $status);
            $rincianQuery->where('status', $status);
            $limit = 20; // Ambil lebih banyak jika sedang filter status
        } else {
            $limit = 5; // Default 5 terbaru
        }

        $spts = $sptQuery->latest()->limit($limit)->get();
        $spds = $spdQuery->latest()->limit($limit)->get();
        $rincians = $rincianQuery->latest()->limit($limit)->get();

        // Gabungkan dokumen
        $merged = $spts->concat($spds)->concat($rincians)
            ->sortByDesc('created_at');

        $taken = ($status && $status !== 'all') ? $merged->take(20) : $merged->take(5);

        return $taken->map(function ($doc) {
            if ($doc instanceof Spt) {
                $type = 'SPT';
                $nomor = $doc->nomor_spt;
            } elseif ($doc instanceof Spd) {
                $type = 'SPD';
                $nomor = $doc->nomor_spd;
            } else {
                $type = 'Rincian';
                $nomor = $doc->nomor_spd; // Rincian menggunakan nomor_spd sebagai referensi
            }

            return [
                'type' => $type,
                'id' => $doc->id,
                'nomor' => $nomor,
                'tujuan' => $doc->tujuan_kegiatan,
                'status' => $doc->status,
                'catatan_verifikator' => $doc->catatan_verifikator,
                'created_at' => $doc->created_at,
                'tanggal_diajukan' => $doc->created_at ? $doc->created_at->format('d-m-Y') : '-',
                'waktu_relatif' => $doc->created_at ? $doc->created_at->diffForHumans() : '-',
            ];
        })->values();
    }

    /**
     * Ringkasan dokumen per status (Draft, Diajukan, Direvisi, Disetujui, Ditolak)
     */
    private function getDocumentSummary(int $userId): array
    {
        $statuses = [
            'draft' => 'Draft',
            'diajukan' => 'Diajukan',
            'direvisi' => 'Direvisi',
            'disetujui' => 'Disetujui',
        ];

        $summary = [];
        foreach ($statuses as $key => $label) {
            $sptCount = Spt::where('pembuat_id', $userId)->where('status', $key)->count();
            $spdCount = Spd::where('pembuat_id', $userId)->where('status', $key)->count();
            $rincianCount = Rincian::where('pembuat_id', $userId)->where('status', $key)->count();

            $summary[] = [
                'status' => $key,
                'label' => $label,
                'jumlah' => $sptCount + $spdCount + $rincianCount,
            ];
        }

        return $summary;
    }

    /**
     * Hitung jumlah dokumen milik user yang perlu direvisi
     */
    private function getRevisionCount(int $userId): int
    {
        $sptRevisi = Spt::where('pembuat_id', $userId)->where('status', 'direvisi')->count();
        $spdRevisi = Spd::where('pembuat_id', $userId)->where('status', 'direvisi')->count();
        $rincianRevisi = Rincian::where('pembuat_id', $userId)->where('status', 'direvisi')->count();

        return $sptRevisi + $spdRevisi + $rincianRevisi;
    }
}
