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
        'jenis_perjalanan',    // Jenis perjalanan dinas (Dalam Kota/Luar Kota)
        'berangkat_dari',      // Berangkat dari
        'alat_angkut',         // Alat Angkut
        'ppk',                 // PPK
        'nama_ppk',            // Nama PPK
        'nip_ppk',             // NIP PPK
        'pejabat_ditugaskan',  // Kolom tambahan untuk pejabat dinamis
        'spt_id',              // Referensi SPT
        'pembuat_id',          // Pembuat SPD
        'kepala_seksi_jabatan',
        'kepala_seksi_nama',
        'kepala_seksi_nip',
        'pejabat_instansi_perusahaan',
        'pejabat_instansi_perusahaan_nama',
        'pejabat_instansi_perusahaan_nip',
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
     * Nama pegawai diambil dari data_pegawai berdasarkan nip_pegawai.
     */
    public function getPegawaiDitugaskanAttribute()
    {
        return $this->pegawai?->nama_pegawai;
    }

    /**
     * Pangkat/Golongan pegawai diambil dari data_pegawai berdasarkan nip_pegawai.
     */
    public function getPangkatPegawaiAttribute()
    {
        $pegawai = $this->pegawai;

        if (! $pegawai) {
            return null;
        }

        $parts = array_filter([$pegawai->pangkat, $pegawai->golongan]);

        return $parts ? implode(' / ', $parts) : null;
    }

    /**
     * Jabatan pegawai diambil dari data_pegawai berdasarkan nip_pegawai.
     */
    public function getJabatanPegawaiAttribute()
    {
        return $this->pegawai?->jabatan;
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
     * Hubungan ke model Rincian (One-to-One).
     */
    public function rincian()
    {
        return $this->hasOne(Rincian::class, 'spd_id');
    }

    /**
     * Hubungan ke model SPT.
     */
    public function spt(): BelongsTo
    {
        return $this->belongsTo(Spt::class, 'spt_id');
    }

    /**
     * Hubungan ke data pegawai berdasarkan NIP.
     * SPD hanya menyimpan nip_pegawai; identitas (nama, pangkat, jabatan)
     * selalu dibaca dari data_pegawai agar tetap konsisten.
     */
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'nip_pegawai', 'nip');
    }

    /**
     * Hubungan ke model User (Pembuat).
     */
    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pembuat_id');
    }
}
