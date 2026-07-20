<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UangHarian extends Model
{
    const CACHE_KEY = 'uang_harian_all';

    protected $table = 'data_uang_harian';

    protected $fillable = [
        'provinsi',
        'luar_kota',
        'dalam_kota_lebih_8_jam',
        'diklat',
    ];

    // -------------------------------------------------------------------------
    // Caching
    // -------------------------------------------------------------------------

    /**
     * Ambil seluruh data uang harian dari cache.
     */
    public static function getCachedAll(): Collection
    {
        return Cache::rememberForever(self::CACHE_KEY, fn () => static::all());
    }

    /**
     * Hapus cache uang harian.
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
}
