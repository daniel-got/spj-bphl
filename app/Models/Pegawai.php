<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Pegawai extends Model
{
    const CACHE_KEY = 'pegawai_all';

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
    // Caching
    // -------------------------------------------------------------------------

    /**
     * Ambil seluruh data pegawai dari cache. Jika belum ada, query ke database
     * dan simpan selamanya. Cache otomatis di-clear saat ada perubahan data.
     */
    public static function getCachedAll(): Collection
    {
        $data = Cache::rememberForever(self::CACHE_KEY, fn () => static::all()->toArray());

        if ($data instanceof Collection) {
            return $data;
        }

        return (new static)->newCollection(
            array_map(fn (array $row) => (new static)->forceFill($row)->syncOriginal(), $data)
        );
    }

    /**
     * Hapus cache pegawai. Dipanggil otomatis saat data berubah.
     */
    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Daftarkan event listener untuk cache invalidation secara otomatis.
     */
    protected static function booted(): void
    {
        static::saved(fn () => static::clearCache());
        static::deleted(fn () => static::clearCache());
    }

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
