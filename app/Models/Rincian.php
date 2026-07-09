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
        // Jika data_spd memiliki kolom nama_pegawai atau semacamnya
        // Dalam model Spd, tidak terlihat kolom nama_pegawai eksplisit,
        // mungkin ada di pejabat_ditugaskan atau relasi lain.
        // Berdasarkan Spd.php, nip_pegawai ada.
        return $this->spd?->nama_pegawai ?? $this->spd?->pejabat_ditugaskan['nama'] ?? '-';
    }

    public function getTujuanKegiatanAttribute()
    {
        return $this->spd?->tujuan_kegiatan;
    }

    public function getTempatTujuanAttribute()
    {
        return $this->spd?->tempat_tujuan;
    }

    public function getLamaKegiatanAttribute()
    {
        return $this->spd?->lama_kegiatan;
    }

    public function getJenisPerjalananAttribute()
    {
        // Misalkan diambil dari tempat tujuan atau kolom di SPD
        return $this->spd?->spt?->tempat_tujuan ? 'Dinas' : '-';
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scope(Builder $query): Builder
    {
        return $query->where('role', UserRole::ADMIN->value);
    }
}
