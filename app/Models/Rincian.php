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
    // Scopes
    // -------------------------------------------------------------------------

    public function scope(Builder $query): Builder
    {
        return $query->where('role', UserRole::ADMIN->value);
    }
}
