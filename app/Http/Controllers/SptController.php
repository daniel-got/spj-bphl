<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SptController extends Controller
{
    public function index()
    {
        // Mengambil data dari tabel data_spt
        $dataSpt = DB::table('data_spt')->get();

        // Hitung statistik untuk summary card atas
        $totalSpt = $dataSpt->count();
        $disetujui = $dataSpt->where('status', 'disetujui')->count(); 
        $direvisi = $dataSpt->where('status', 'direvisi')->count();
        $ditolak = $dataSpt->where('status', 'ditolak')->count();

        // Mengarah ke path folder view yang baru: pages/spt/index.blade.php
        return view('pages.spt.index', compact('dataSpt', 'totalSpt', 'disetujui', 'direvisi', 'ditolak'));
    }

    /**
     * Menampilkan halaman form tambah SPT
     */
    public function create()
    {
        // Mengarah ke file pages/spt/create.blade.php yang baru Anda buat
        return view('pages.spt.create');
    }

    /**
     * Menyimpan data SPT baru ke database
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang dikirim dari form create.blade.php
        $validated = $request->validate([
            'nomor_spt'          => 'required|string|max:255',
            'tgl_spt'            => 'required|date',
            'pegawai_ditugaskan' => 'required|string|max:255',
            'nip_pegawai'        => 'required|string|max:255',
            'pangkat_pegawai'    => 'nullable|string|max:255',
            'jabatan_pegawai'    => 'nullable|string|max:255',
            'tujuan_kegiatan'    => 'required|string',
            'tempat_tujuan'      => 'required|array', 
            'tempat_tujuan.*'    => 'required|string|max:255',
            'tgl_berangkat'      => 'required|date',
            'tgl_kembali'        => 'required|date|after_or_equal:tgl_berangkat',
            'lama_kegiatan'      => 'required|integer|min:1',
            'kode_mak'           => 'nullable|string|max:255',
        ]);

        // Mengubah array tempat_tujuan menjadi format JSON agar bisa disimpan di database
        $validated['tempat_tujuan'] = json_encode($request->tempat_tujuan);

        // Tambahkan default status jika kolom status dibutuhkan di tabel data_spt Anda
        $validated['status'] = 'pending'; // atau sesuaikan dengan alur aplikasi Anda (misal langsung disetujui)

        // 2. Insert data ke tabel data_spt menggunakan Query Builder DB
        DB::table('data_spt')->insert($validated);

        // 3. Setelah sukses, redirect ke halaman index dengan pesan sukses
        return redirect()->route('user.spt.index')->with('success', 'Data SPT baru berhasil ditambahkan!');
    }
}