<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'data_pegawai';

    protected $fillable = [
        'user_id',
        'nama_pegawai',
        'nip',
        'pangkat',
        'golongan',
        'jabatan',
        'sub_seksi',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    /**
     * Setiap Pegawai memiliki satu akun User untuk login.
     * Akses: $pegawai->user->email
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi dummy ke diri sendiri untuk menghindari error eager loading.
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id', 'id');
    }

    // -------------------------------------------------------------------------
    // Query Scopes
    // -------------------------------------------------------------------------

    /**
     * Filter berdasarkan kata kunci (search by nama, nip, atau sub_seksi).
     * Dipanggil: Pegawai::search($keyword)->paginate(10)
     */
    public function scopeSearch($query, ?string $keyword)
    {
        if (! $keyword) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword) {
            $q->where('nama_pegawai', 'like', "%{$keyword}%")
                ->orWhere('nip', 'like', "%{$keyword}%")
                ->orWhere('sub_seksi', 'like', "%{$keyword}%");
        });
    }
}
