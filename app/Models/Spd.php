<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spd extends Model
{
    use HasFactory;

    // Nama tabel sesuai acuan dokumen 
    protected $table = 'data_spd';

    // Kolom fillable berdasarkan properti SPD di dokumen 
    protected $fillable = [
        'nomor_spd',           // Nomor SPD 
        'tgl_spd',             // Tgl SPD 
        'pegawai_ditugaskan',  // Pegawai yg ditugaskan 
        'nip_pegawai',         // NIP Pegawai 
        'pangkat_pegawai',     // Pangkat Pegawai 
        'jabatan_pegawai',     // Jabatan pegawai 
        'tujuan_kegiatan',     // Tujuan Kegiatan 
        'tempat_tujuan',       // Tempat Tujuan 
        'tgl_berangkat',       // Tgl. Berangkat 
        'tgl_kembali',         // Tgl. Kembali 
        'lama_kegiatan',       // Lama Kegiatan 
        'kode_mak',            // Kode MAK 
        'jenis_perjalanan',    // Jenis Perjalanan 
        'berangkat_dari',      // Berangkat dari 
        'alat_angkut',         // Alat Angkut 
        'ppk',                 // PPK 
        'nama_ppk',            // Nama PPK 
        'nip_ppk',             // NIP PPK 
        'pejabat_ditugaskan',  // Kolom tambahan untuk pejabat dinamis 
        'status',              // Status SPD
        'alasan',              // Alasan revisi/penolakan
    ];

    protected $casts = [
        'pejabat_ditugaskan' => 'array', // Mendukung penambahan pejabat secara dinamis 
        'tgl_spd' => 'date',
        'tgl_berangkat' => 'date',
        'tgl_kembali' => 'date',
    ];

    /**
     * Get the tempat_tujuan attribute.
     *
     * @param  mixed  $value
     * @return array
     */
    public function getTempatTujuanAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);
        if (is_array($decoded)) {
            return $decoded;
        }

        if (is_string($value)) {
            return array_filter(array_map('trim', explode(',', $value)));
        }

        return [];
    }

    /**
     * Set the tempat_tujuan attribute.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setTempatTujuanAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['tempat_tujuan'] = json_encode(array_filter(array_map('trim', $value)));
        } else {
            $this->attributes['tempat_tujuan'] = $value;
        }
    }
}