<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spt extends Model
{
    use HasFactory;

    // Menghubungkan ke nama tabel hasil migration Anda
    protected $table = 'data_spt';

    protected $fillable = [
        'nomor_spt',
        'status',
        'tgl_spt',
        'pegawai_ditugaskan',
        
        // Wajib dimasukkan ke fillable
        'jenis_tugas',
        'surat_dasar',

        'penanggung_jawab',
        'anggota',
        'menimbang',
        'dasar',
        'biaya',
        'tujuan_kegiatan',
        'tempat_tujuan',
        'tgl_berangkat',
        'tgl_kembali',
        'lama_kegiatan',
        'kode_mak',
        'pembuat_id', // Tracking pembuat data
    ];

    /**
     * Konversi otomatis tipe data dari database ke format PHP.
     */
    protected $casts = [
        'pegawai_ditugaskan' => 'array', // Supaya data JSON pegawai otomatis menjadi Array saat diakses
        'tgl_spt' => 'date',
        'tgl_berangkat' => 'date',
        'tgl_kembali' => 'date',
    ];
}