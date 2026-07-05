<?php

namespace App\Services\Admin;

use App\Models\Pegawai;
use App\Models\Spt;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * DashboardService — Logika bisnis untuk Dashboard Admin.
 *
 * Semua query, agregasi data, dan transformasi dilakukan di sini.
 * Controller hanya memanggil getDashboardData() dan meneruskan hasilnya ke View.
 */
class DashboardService
{
    /**
     * Mengumpulkan semua data yang dibutuhkan untuk halaman Dashboard Admin.
     * Return type array agar mudah di-unpack ke View (compact-style).
     */
    public function getDashboardData(): array
    {
        return [
            'stats' => $this->getStatCards(),
            'recentUsers' => $this->getRecentUsers(),
            'documentSummary' => $this->getDocumentSummary(),
        ];
    }

    // -------------------------------------------------------------------------
    // Private Helpers — dipanggil hanya dari dalam Service ini
    // -------------------------------------------------------------------------

    /**
     * Data untuk 4 kartu statistik di bagian atas dashboard.
     */
    private function getStatCards(): array
    {
        $totalPegawai = User::rolePegawai()->count();
        $totalAdmin = User::admin()->count();
        $totalVerifikator = User::verifikator()->count();
        $totalPegawai2 = User::has('pegawai')->count();

        // Hitung dokumen berdasarkan status jika model Spt tersedia
        $dokumenDiajukan = 0;
        $dokumenDisetujui = 0;

        if (class_exists(Spt::class)) {
            $dokumenDiajukan = Spt::where('status', 'diajukan')->count();
            $dokumenDisetujui = Spt::where('status', 'disetujui')->count();
        }

        return [
            [
                'title' => 'Total Pengguna',
                'value' => $totalPegawai,
                'description' => 'Seluruh akun terdaftar',
                'icon' => 'users',
                'color' => 'blue',
            ],
            [
                'title' => 'Pegawai Aktif',
                'value' => $totalPegawai2,
                'description' => 'Dengan role User',
                'icon' => 'user-group',
                'color' => 'green',
            ],
            [
                'title' => 'Dokumen Diajukan',
                'value' => $dokumenDiajukan,
                'description' => 'Menunggu verifikasi',
                'icon' => 'document-text',
                'color' => 'yellow',
            ],
            [
                'title' => 'Dokumen Disetujui',
                'value' => $dokumenDisetujui,
                'description' => 'Selesai diproses',
                'icon' => 'check-circle',
                'color' => 'green',
            ],
        ];
    }

    /**
     * 5 pengguna terbaru yang baru mendaftar/dibuat oleh Admin.
     * Menggunakan Eager Loading agar data pegawai ikut terbawa (hindari N+1).
     */
    private function getRecentUsers(): Collection
    {
        return User::with('pegawai')
            ->latest()
            ->limit(5)
            ->get();
    }

    /**
     * Ringkasan jumlah dokumen per status untuk ditampilkan sebagai tabel ringkas.
     */
    private function getDocumentSummary(): array
    {
        if (! class_exists(Spt::class)) {
            return [];
        }

        $statuses = ['draft', 'diajukan', 'direvisi', 'disetujui', 'ditolak'];
        $summary = [];

        foreach ($statuses as $status) {
            $summary[] = [
                'status' => $status,
                'jumlah' => Spt::where('status', $status)->count(),
            ];
        }

        return $summary;
    }
}
