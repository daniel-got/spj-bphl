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
        'penanggung_jawab',
        'anggota',
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
}
