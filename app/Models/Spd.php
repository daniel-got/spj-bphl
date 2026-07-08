<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Spd extends Model
{
    use HasFactory;

    // Nama tabel sesuai acuan dokumen
    protected $table = 'data_spd';

    // Kolom fillable berdasarkan properti SPD di dokumen
    protected $fillable = [
        'nomor_spd',           // Nomor SPD
        'tgl_spd',             // Tgl SPD
        'nip_pegawai',         // NIP Pegawai
        'berangkat_dari',      // Berangkat dari
        'alat_angkut',         // Alat Angkut
        'ppk',                 // PPK
        'nama_ppk',            // Nama PPK
        'nip_ppk',             // NIP PPK
        'pejabat_ditugaskan',  // Kolom tambahan untuk pejabat dinamis
        'status',              // Status SPD
        'alasan',              // Alasan revisi/penolakan
        'spt_id',              // Referensi SPT
        'pembuat_id',          // Pembuat SPD
    ];

    protected $casts = [
        'pejabat_ditugaskan' => 'array', // Mendukung penambahan pejabat secara dinamis
        'alat_angkut' => 'array',
        'tgl_spd' => 'date',
    ];

    /**
     * Get the tempat_tujuan attribute from SPT.
     */
    public function getTempatTujuanAttribute()
    {
        return $this->spt?->tempat_tujuan ?? [];
    }

    /**
     * Get the tujuan_kegiatan attribute from SPT.
     */
    public function getTujuanKegiatanAttribute()
    {
        return $this->spt?->tujuan_kegiatan;
    }

    /**
     * Get the tgl_berangkat attribute from SPT.
     */
    public function getTglBerangkatAttribute()
    {
        return $this->spt?->tgl_berangkat;
    }

    /**
     * Get the tgl_kembali attribute from SPT.
     */
    public function getTglKembaliAttribute()
    {
        return $this->spt?->tgl_kembali;
    }

    /**
     * Get the lama_kegiatan attribute from SPT.
     */
    public function getLamaKegiatanAttribute()
    {
        return $this->spt?->lama_kegiatan;
    }

    /**
     * Get the kode_mak attribute from SPT.
     */
    public function getKodeMakAttribute()
    {
        return $this->spt?->kode_mak;
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Method booted dikosongkan karena duplikasi data ke Rincian sudah tidak diperlukan
    }

    /**
     * Hubungan ke model SPT.
     */
    public function spt(): BelongsTo
    {
        return $this->belongsTo(Spt::class, 'spt_id');
    }
}
