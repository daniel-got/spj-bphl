<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratDasar extends Model
{
    use HasFactory;

    protected $table = 'data_surat_dasar';

    protected $fillable = [
        'teks',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    // -------------------------------------------------------------------------
    // Query Scopes
    // -------------------------------------------------------------------------

    /**
     * Hanya ambil surat dasar yang aktif (ditampilkan di dropdown form).
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Filter berdasarkan kata kunci pencarian.
     */
    public function scopeSearch($query, ?string $keyword)
    {
        if (! $keyword) {
            return $query;
        }

        return $query->where('teks', 'like', "%{$keyword}%");
    }
}
