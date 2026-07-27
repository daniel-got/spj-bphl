<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'data_pengaturan';

    protected $fillable = [
        'kategori',
        'kunci',
        'nilai',
    ];

    // -------------------------------------------------------------------------
    // Helper Methods
    // -------------------------------------------------------------------------

    /**
     * Ambil nilai pengaturan berdasarkan kategori dan kunci.
     * Mengembalikan null jika tidak ditemukan.
     */
    public static function getValue(string $kategori, string $kunci): ?string
    {
        return static::where('kategori', $kategori)
            ->where('kunci', $kunci)
            ->value('nilai');
    }

    /**
     * Simpan atau perbarui (upsert) nilai pengaturan.
     */
    public static function setValue(string $kategori, string $kunci, ?string $nilai): void
    {
        static::updateOrCreate(
            ['kategori' => $kategori, 'kunci' => $kunci],
            ['nilai' => $nilai],
        );
    }

    /**
     * Ambil seluruh pengaturan dalam satu kategori sebagai key-value array.
     *
     * @return array<string, string|null>
     */
    public static function getCategory(string $kategori): array
    {
        return static::where('kategori', $kategori)
            ->pluck('nilai', 'kunci')
            ->toArray();
    }
}
