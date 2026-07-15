<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spt extends Model
{
    use HasFactory;

    // Nama tabel sesuai acuan dokumen
    protected $table = 'data_spt';

    // Kolom fillable berdasarkan properti SPT di dokumen
    protected $fillable = [
        'nomor_spt',           // Nomor SPT
        'tgl_spt',             // Tgl SPT
        'pegawai_ditugaskan',  // Wadah data pegawai dinamis (Nama, NIP, Pangkat, Jabatan)
        'tujuan_kegiatan',     // Tujuan Kegiatan
        'tempat_tujuan',       // Tempat Tujuan
        'tgl_berangkat',       // Tgl. Berangkat
        'tgl_kembali',         // Tgl. Kembali
        'lama_kegiatan',       // Lama Kegiatan
        'kode_mak',            // Kode MAK
        'pembuat_id',          // ID user yang membuat SPT (kolom NOT NULL, wajib ada di fillable)
        'status',              // Status SPT (draft/disetujui/direvisi/ditolak)
        'verifikator_id',
        'catatan_verifikator',
        'penanggung_jawab',
        'anggota',
        'jenis_tugas',
        'surat_dasar',
        'menimbang',
        'dasar',
        'biaya',
    ];

    const STATUS_DRAFT = 'draft';

    const STATUS_WAITING_TU = 'diajukan'; // Menunggu verifikasi TU

    const STATUS_REVISED = 'direvisi';

    const STATUS_APPROVED = 'disetujui';

    const STATUS_REJECTED = 'ditolak';

    // Konversi otomatis data JSON dari PostgreSQL menjadi array PHP
    protected $casts = [
        'pegawai_ditugaskan' => 'array', // Mendukung penugasan pegawai dinamis
        'tgl_spt' => 'date',
        'tgl_berangkat' => 'date',
        'tgl_kembali' => 'date',
    ];

    /**
     * Hubungan ke model SPD (One-to-Many).
     */
    public function spds()
    {
        return $this->hasMany(Spd::class, 'spt_id');
    }

    /**
     * Hitung status progress dinamis untuk alur SPT -> SPD -> Rincian -> SPJ.
     */
    public function getStatusProgressAttribute(): string
    {
        if ($this->status !== 'disetujui' && $this->status !== 'selesai') {
            return $this->status;
        }

        $totalTravelers = count($this->pegawai_ditugaskan ?? []);
        if ($totalTravelers === 0) {
            return $this->status;
        }

        // 1. Check SPD creation
        $createdSpds = $this->spds->count();
        if ($createdSpds < $totalTravelers) {
            return 'dalam_pembuatan_spd';
        }

        // 2. Check Rincian (SPJ draft) creation
        $createdSpjs = $this->spds->filter(fn($spd) => $spd->rincian !== null)->count();
        if ($createdSpjs < $totalTravelers) {
            return 'dalam_pembuatan_rincian';
        }

        // 3. Check SPJ approval
        $approvedSpjs = $this->spds->filter(fn($spd) => $spd->rincian?->status === 'disetujui')->count();
        if ($approvedSpjs < $totalTravelers) {
            return 'pengajuan_spj';
        }

        return 'selesai';
    }
}
