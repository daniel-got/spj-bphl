<?php

namespace App\Http\Controllers\Kwitansi;

use App\Http\Controllers\Controller;
use App\Models\Kwitansi;
use Illuminate\Http\Request;

class KwitansiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = Kwitansi::with(['rincian.spd.spt', 'rincian.spd.pegawai', 'rincian.pembuat']);
        
        if ($user && !$user->isAdmin() && !$user->isMonitoring()) {
            $query->whereHas('rincian', function($q) use ($user) {
                $q->where('pembuat_id', $user->id);
            });
        }
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_kwitansi', 'like', "%{$search}%")
                  ->orWhereHas('rincian.spd', function($sq) use ($search) {
                      $sq->where('nomor_spd', 'like', "%{$search}%")
                         ->orWhere('pegawai_ditugaskan', 'like', "%{$search}%");
                  });
            });
        }
        
        $kwitansis = $query->latest()->paginate((int)$request->input('per_page', 10));
        
        return view('pages.kwitansi.index', compact('kwitansis'));
    }

    public function edit(Kwitansi $kwitansi)
    {
        $user = auth()->user();
        if ($user && !$user->isAdmin() && !$user->isMonitoring() && $kwitansi->rincian->pembuat_id !== $user->id) {
            abort(403);
        }
        
        return view('pages.kwitansi.edit', compact('kwitansi'));
    }

    public function update(Request $request, Kwitansi $kwitansi)
    {
        $user = auth()->user();
        if ($user && !$user->isAdmin() && !$user->isMonitoring() && $kwitansi->rincian->pembuat_id !== $user->id) {
            abort(403);
        }
        
        $validated = $request->validate([
            'untuk_pembayaran' => 'required|string',
        ]);
        
        $kwitansi->update([
            'untuk_pembayaran' => $validated['untuk_pembayaran']
        ]);
        
        return redirect()->route('user.kwitansi.index')->with('success', 'Data Kwitansi berhasil diperbarui.');
    }

    public function print(Kwitansi $kwitansi)
    {
        $user = auth()->user();
        if ($user && !$user->isAdmin() && !$user->isMonitoring() && $kwitansi->rincian->pembuat_id !== $user->id) {
            abort(403);
        }
        
        $rincian = $kwitansi->rincian;
        $spd = $rincian->spd;
        $spt = $spd?->spt;
        
        // Calculate total rincian for terbilang
        $totalBiaya = 0;
        $rb = $rincian->rincian_biaya ?? [];
        if (isset($rb['transport']) && is_array($rb['transport'])) {
            foreach ($rb['transport'] as $items) {
                if (is_array($items)) {
                    foreach ($items as $item) {
                        $totalBiaya += (float) ($item['biaya'] ?? 0);
                    }
                }
            }
        }
        if (isset($rb['penginapan']) && is_array($rb['penginapan'])) {
            foreach ($rb['penginapan'] as $item) {
                if (is_array($item)) {
                    $totalBiaya += (float) ($item['hotel_ril'] ?? 0);
                }
            }
        }
        
        // Add uang harian
        $rincianService = app(\App\Services\Rincian\RincianService::class);
        $uangHarianRate = $rincianService->calculateUangHarianRate($spd);
        $totalBiaya += ($uangHarianRate * (int)($spd->lama_kegiatan ?? 0));
        $spellout = \NumberFormatter::create('id', \NumberFormatter::SPELLOUT)->format($totalBiaya);
        $terbilang = '(' . ucfirst(strtolower($spellout)) . ' rupiah)';
        
        $bendahara = \App\Models\User::whereJsonContains('roles', 'bendahara_pengeluaran')->with('pegawai')->first();
        
        return view('pages.kwitansi.print', compact('kwitansi', 'rincian', 'spd', 'spt', 'totalBiaya', 'terbilang', 'bendahara'));
    }
}
