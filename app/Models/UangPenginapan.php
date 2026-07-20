<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UangPenginapan extends Model
{
    const CACHE_KEY = 'uang_penginapan_all';

    protected $table = 'data_uang_penginapan';

    protected $fillable = [
        'provinsi',
        'gol_iv',
        'gol_iii_ii_i',
    ];

    // -------------------------------------------------------------------------
    // Caching
    // -------------------------------------------------------------------------

    /**
     * Ambil seluruh data uang penginapan dari cache.
     */
    public static function getCachedAll(): Collection
    {
        return Cache::rememberForever(self::CACHE_KEY, fn () => static::all());
    }

    /**
     * Hapus cache uang penginapan.
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
