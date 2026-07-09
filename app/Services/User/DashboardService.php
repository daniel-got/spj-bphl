<?php

namespace App\Services\User;

use App\Models\Rincian;
use App\Models\Spd;
use App\Models\Spt;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function getDashboardData(): array
    {
        $user = Auth::user();
        $pegawai = $user->pegawai;
        $nip = $pegawai ? $pegawai->nip : null;

        return [
            'stats' => $this->getStatCards($user->id, $nip),
            'recentSpt' => $this->getRecentSpt($user->id, $nip),
            'documentSummary' => $this->getDocumentSummary($user->id, $nip),
        ];
    }

    private function getStatCards(int $userId, ?string $nip): array
    {
        // 1. Ditugaskan (Assigned): SPT yang statusnya disetujui tapi belum ada SPD
        $assignedCount = Spt::where('status', Spt::STATUS_APPROVED)
            ->where(function ($query) use ($userId, $nip) {
                $query->where('pembuat_id', $userId);
                if ($nip) {
                    $query->orWhere('pegawai_ditugaskan', 'like', '%'.$nip.'%');
                }
            })
            ->whereDoesntHave('spds')
            ->count();

        // 2. Pelaksanaan (Execution): Sudah ada SPD tapi belum ada Rincian
        $executionCount = Spd::where(function ($query) use ($userId, $nip) {
            $query->where('pembuat_id', $userId);
            if ($nip) {
                $query->orWhere('nip_pegawai', $nip);
            }
        })
            ->whereDoesntHave('rincian')
            ->count();

        // 3. Penyusunan Laporan (Report): Sudah ada Rincian tapi statusnya belum disetujui (selesai)
        $reportCount = Rincian::where(function ($query) use ($userId, $nip) {
            $query->where('pembuat_id', $userId);
            if ($nip) {
                $query->orWhereHas('spd', function ($q) use ($nip) {
                    $q->where('nip_pegawai', $nip);
                });
            }
        })
            ->whereIn('status', [Rincian::STATUS_DRAFT, Rincian::STATUS_SUBMITTED, Rincian::STATUS_REVISED])
            ->count();

        // 4. Selesai (Finished): Rincian sudah disetujui
        $finishedCount = Rincian::where(function ($query) use ($userId, $nip) {
            $query->where('pembuat_id', $userId);
            if ($nip) {
                $query->orWhereHas('spd', function ($q) use ($nip) {
                    $q->where('nip_pegawai', $nip);
                });
            }
        })
            ->where('status', Rincian::STATUS_APPROVED)
            ->count();

        return [
            [
                'title' => 'Ditugaskan',
                'value' => $assignedCount,
                'description' => 'SPT disetujui, belum ada SPD',
                'icon' => 'document-text',
                'color' => 'blue',
            ],
            [
                'title' => 'Pelaksanaan',
                'value' => $executionCount,
                'description' => 'Dalam proses perjalanan dinas',
                'icon' => 'clipboard',
                'color' => 'green',
            ],
            [
                'title' => 'Penyusunan Laporan',
                'value' => $reportCount,
                'description' => 'Draft/Revisi rincian biaya',
                'icon' => 'calculator',
                'color' => 'yellow',
            ],
            [
                'title' => 'Selesai',
                'value' => $finishedCount,
                'description' => 'SPJ telah diselesaikan',
                'icon' => 'check-circle',
                'color' => 'indigo',
            ],
        ];
    }

    private function getRecentSpt(int $userId, ?string $nip)
    {
        return Spt::where('pembuat_id', $userId)
            ->when($nip, function ($q) use ($nip) {
                return $q->orWhere('pegawai_ditugaskan', 'like', '%'.$nip.'%');
            })
            ->latest()
            ->limit(5)
            ->get();
    }

    private function getDocumentSummary(int $userId, ?string $nip): array
    {
        $statuses = ['draft', 'diajukan', 'direvisi', 'disetujui', 'ditolak'];
        $summary = [];

        foreach ($statuses as $status) {
            $summary[] = [
                'status' => $status,
                'jumlah' => Spt::where('status', $status)
                    ->where(function ($query) use ($userId, $nip) {
                        $query->where('pembuat_id', $userId);
                        if ($nip) {
                            $query->orWhere('pegawai_ditugaskan', 'like', '%'.$nip.'%');
                        }
                    })->count(),
            ];
        }

        return $summary;
    }
}
