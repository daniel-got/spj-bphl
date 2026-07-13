<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rincian extends Model
{
    use HasFactory;

    // Nama tabel sesuai acuan dokumen
    protected $table = 'data_rincian';

    // Kolom fillable berdasarkan komponen rincian biaya
    protected $fillable = [
        'spd_id',
        'rincian_biaya',        // Rincian Biaya (JSON Array of Objects)
        'status',
        'pembuat_id',
        'verifikator_id',
        'catatan_verifikator',
        'lampiran',             // Path file lampiran PDF
    ];

    const STATUS_DRAFT = 'draft';

    const STATUS_SUBMITTED = 'diajukan'; // Diajukan ke Verifikator

    const STATUS_REVISED = 'direvisi';

    const STATUS_APPROVED = 'disetujui';

    const STATUS_REJECTED = 'ditolak';

    protected $casts = [
        'rincian_biaya' => 'array', // Mengakomodasi banyak set biaya dinamis
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function spd(): BelongsTo
    {
        return $this->belongsTo(Spd::class, 'spd_id');
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pembuat_id');
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verifikator_id');
    }

    // -------------------------------------------------------------------------
    // Accessors untuk kolom virtual dari relasi SPD
    // -------------------------------------------------------------------------

    public function getNomorSpdAttribute()
    {
        return $this->spd?->nomor_spd;
    }

    public function getNipPegawaiAttribute()
    {
        return $this->spd?->nip_pegawai;
    }

    public function getPegawaiDitugaskanAttribute()
    {
        // Nama pegawai diambil dari SPD (accessor SPD membacanya dari data_pegawai via nip_pegawai).
        return $this->spd?->pegawai_ditugaskan ?? '-';
    }

    public function getTujuanKegiatanAttribute()
    {
        return $this->spd?->tujuan_kegiatan;
    }

    public function getTempatTujuanAttribute()
    {
        $tt = $this->spd?->tempat_tujuan;

        return is_array($tt) ? implode(', ', $tt) : $tt;
    }

    public function getLamaKegiatanAttribute()
    {
        return $this->spd?->lama_kegiatan;
    }

    public function getJenisPerjalananAttribute()
    {
        return $this->spd?->jenis_perjalanan ?? '-';
    }

    public function getTglSpdAttribute()
    {
        return $this->spd?->tgl_spd?->format('Y-m-d');
    }

    public function getBerangkatDariAttribute()
    {
        return $this->spd?->berangkat_dari;
    }

    public function getAlatAngkutAttribute()
    {
        $aa = $this->spd?->alat_angkut;

        return is_array($aa) ? implode(', ', $aa) : $aa;
    }

    public function getKodeMakAttribute()
    {
        return $this->spd?->kode_mak;
    }

    public function getPpkAttribute()
    {
        return $this->spd?->ppk;
    }

    public function getNamaPpkAttribute()
    {
        return $this->spd?->nama_ppk;
    }

    public function getNipPpkAttribute()
    {
        return $this->spd?->nip_ppk;
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scope(Builder $query): Builder
    {
        return $query;
    }
}
