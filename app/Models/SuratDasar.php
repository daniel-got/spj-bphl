<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SuratDasar extends Model
{
    const CACHE_KEY = 'surat_dasar_aktif';

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
    // Caching
    // -------------------------------------------------------------------------

    /**
     * Ambil daftar Surat Dasar yang aktif dari cache.
     * Dipakai untuk mengisi pilihan dropdown pada form pembuatan SPT.
     */
    public static function getCachedAktif(): Collection
    {
        return Cache::rememberForever(self::CACHE_KEY, fn () => static::aktif()->get());
    }

    /**
     * Hapus cache surat dasar.
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
