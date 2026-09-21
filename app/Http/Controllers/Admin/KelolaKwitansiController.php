<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kwitansi;
use Illuminate\Http\Request;

class KelolaKwitansiController extends Controller
{
    public function index(Request $request)
    {
        $query = Kwitansi::with(['rincian.spd.spt', 'rincian.spd.pegawai', 'rincian.pembuat']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_kwitansi', 'ilike', "%{$search}%")
                    ->orWhereHas('rincian.spd', function ($sq) use ($search) {
                        $sq->where('nomor_spd', 'ilike', "%{$search}%")
                            ->orWhereHas('pegawai', function ($pq) use ($search) {
                                $pq->where('nama_pegawai', 'ilike', "%{$search}%");
                            });
                    });
            });
        }

        $kwitansis = $query->latest()->paginate((int) $request->input('per_page', 10));

        return view('pages.admin.kwitansi.index', compact('kwitansis'));
    }

    public function show(Kwitansi $kwitansi)
    {
        // View detail kwitansi (could just redirect to the user view but let's give them access if they have a view page)
        // Currently there is no show view for kwitansi, maybe just redirect to print or edit.
        return redirect()->route('user.kwitansi.print', $kwitansi->id);
    }
}
