<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rincian extends Model
{
    use HasFactory;

    // Nama tabel sesuai acuan dokumen 
    protected $table = 'data_rincian';

    // Kolom fillable berdasarkan komponen rincian biaya 
    protected $fillable = [
        'nomor_spd',            // Nomor SPD 
        'tgl_spd',              // Tgl SPD 
        'pegawai_ditugaskan',   // Pegawai yg ditugaskan 
        'nip_pegawai',          // NIP Pegawai 
        'tujuan_kegiatan',      // Tujuan Kegiatan
        'berangkat_dari',       // Berangkat dari 
        'tempat_tujuan',        // Tempat Tujuan 
        'lama_kegiatan',        // Lama Kegiatan 
        'jenis_perjalanan',     // Jenis Perjalanan 
        'alat_angkut',          // Alat Angkut 
        'kode_mak',             // Kode MAK 
        'ppk',                  // PPK 
        'nama_ppk',             // Nama PPK 
        'nip_ppk',              // NIP PPK 
        'biaya_transport',      // Biaya Transport 
        'penginapan',           // Penginapan (%) 
        'hotel_ril',            // Hotel Ril 
        'detail_transportasi',  // Menyimpan komponen detail transportasi dinamis 
    ];

    protected $casts = [
        'detail_transportasi' => 'array', // Mengakomodasi penambahan baris transportasi dinamis 
        'tgl_spd' => 'date',
        'biaya_transport' => 'decimal:2',
        'penginapan' => 'integer',
        'hotel_ril' => 'decimal:2',
    ];
}