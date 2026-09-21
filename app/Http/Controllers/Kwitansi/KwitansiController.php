<?php

namespace App\Http\Controllers\Kwitansi;

use App\Helpers\TerbilangHelper;
use App\Http\Controllers\Controller;
use App\Models\Kwitansi;
use App\Models\Pegawai;
use App\Services\Rincian\RincianService;
use App\Services\Kwitansi\KwitansiService;
use Illuminate\Http\Request;

class KwitansiController extends Controller
{
    protected KwitansiService $kwitansiService;

    public function __construct(KwitansiService $kwitansiService)
    {
        $this->kwitansiService = $kwitansiService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search']);
        $perPage = (int) $request->input('per_page', 10);

        // Set strictPersonal = true agar halaman ini murni menjadi "Kwitansi Saya"
        // sehingga Admin sekalipun hanya melihat kwitansi miliknya sendiri di sini.
        $kwitansis = $this->kwitansiService->getAllLatest($filters, $perPage, true);

        return view('pages.kwitansi.index', compact('kwitansis'));
    }

    public function edit(Kwitansi $kwitansi)
    {
        $user = auth()->user();
        $pegawaiNip = $user ? Pegawai::where('user_id', $user->id)->value('nip') : null;

        $canAccess = $user && ($user->isAdmin() || $user->isMonitoring() ||
                     $kwitansi->rincian->pembuat_id === $user->id ||
                     ($pegawaiNip && $kwitansi->rincian->spd?->nip_pegawai === $pegawaiNip));

        if (! $canAccess) {
            abort(403);
        }

        return view('pages.kwitansi.edit', compact('kwitansi'));
    }

    public function update(Request $request, Kwitansi $kwitansi)
    {
        $user = auth()->user();
        $pegawaiNip = $user ? Pegawai::where('user_id', $user->id)->value('nip') : null;

        $canAccess = $user && ($user->isAdmin() || $user->isMonitoring() ||
                     $kwitansi->rincian->pembuat_id === $user->id ||
                     ($pegawaiNip && $kwitansi->rincian->spd?->nip_pegawai === $pegawaiNip));

        if (! $canAccess) {
            abort(403);
        }

        $validated = $request->validate([
            'untuk_pembayaran' => 'required|string',
        ]);

        $kwitansi->update([
            'untuk_pembayaran' => $validated['untuk_pembayaran'],
        ]);

        return redirect()->route('user.kwitansi.index')->with('success', 'Data Kwitansi berhasil diperbarui.');
    }

    public function print(Kwitansi $kwitansi)
    {
        $user = auth()->user();
        $pegawaiNip = $user ? Pegawai::where('user_id', $user->id)->value('nip') : null;

        $canAccess = $user && ($user->isAdmin() || $user->isMonitoring() ||
                     $kwitansi->rincian->pembuat_id === $user->id ||
                     ($pegawaiNip && $kwitansi->rincian->spd?->nip_pegawai === $pegawaiNip));

        if (! $canAccess) {
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
        $rincianService = app(RincianService::class);
        $uangHarianRate = $rincianService->calculateUangHarianRate($spd);
        $totalBiaya += ($uangHarianRate * (int) ($spd->lama_kegiatan ?? 0));
        $terbilang = '('.TerbilangHelper::format($totalBiaya).')';

        $bendahara = User::whereJsonContains('roles', 'bendahara_pengeluaran')->with('pegawai')->first();

        return view('pages.kwitansi.print', compact('kwitansi', 'rincian', 'spd', 'spt', 'totalBiaya', 'terbilang', 'bendahara'));
    }
}
