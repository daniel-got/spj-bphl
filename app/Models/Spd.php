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
        'spt_id',              // Referensi SPT
        'pembuat_id',          // Pembuat SPD
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

    /**
     * Get the alat_angkut attribute.
     *
     * @param  mixed  $value
     * @return array
     */
    public function getAlatAngkutAttribute($value)
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
     * Set the alat_angkut attribute.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setAlatAngkutAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['alat_angkut'] = json_encode(array_filter(array_map('trim', $value)));
        } else {
            $this->attributes['alat_angkut'] = $value;
        }
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::updated(function ($spd) {
            $rincian = Rincian::where('nomor_spd', $spd->getOriginal('nomor_spd'))->first();
            if ($rincian) {
                $rincian->update([
                    'nomor_spd' => $spd->nomor_spd,
                    'tgl_spd' => $spd->tgl_spd,
                    'pegawai_ditugaskan' => $spd->pegawai_ditugaskan,
                    'nip_pegawai' => $spd->nip_pegawai,
                    'tujuan_kegiatan' => $spd->tujuan_kegiatan,
                    'berangkat_dari' => $spd->berangkat_dari,
                    'tempat_tujuan' => is_array($spd->tempat_tujuan) ? implode(', ', $spd->tempat_tujuan) : $spd->tempat_tujuan,
                    'lama_kegiatan' => $spd->lama_kegiatan,
                    'jenis_perjalanan' => $spd->jenis_perjalanan,
                    'alat_angkut' => is_array($spd->alat_angkut) ? implode(', ', $spd->alat_angkut) : $spd->alat_angkut,
                    'kode_mak' => $spd->kode_mak,
                    'ppk' => $spd->ppk,
                    'nama_ppk' => $spd->nama_ppk,
                    'nip_ppk' => $spd->nip_ppk,
                ]);
            }
        });
    }

    /**
     * Hubungan ke model SPT.
     */
    public function spt(): BelongsTo
    {
        return $this->belongsTo(Spt::class, 'spt_id');
    }
}
