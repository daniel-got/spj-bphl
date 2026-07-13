<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UangHarian extends Model
{
    protected $table = 'data_uang_harian';

    protected $fillable = [
        'provinsi',
        'luar_kota',
        'dalam_kota_lebih_8_jam',
        'diklat',
    ];
}
