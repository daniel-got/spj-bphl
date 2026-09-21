<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kwitansi;
use App\Services\Kwitansi\KwitansiService;
use Illuminate\Http\Request;

class KelolaKwitansiController extends Controller
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

        // Bypass role filter for Admin
        $kwitansis = $this->kwitansiService->getAllLatest($filters, $perPage, false);

        return view('pages.admin.kwitansi.index', compact('kwitansis'));
    }

    public function show(Kwitansi $kwitansi)
    {
        // View detail kwitansi (could just redirect to the user view but let's give them access if they have a view page)
        // Currently there is no show view for kwitansi, maybe just redirect to print or edit.
        return redirect()->route('user.kwitansi.print', $kwitansi->id);
    }
}
