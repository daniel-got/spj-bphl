<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UangPenginapan extends Model
{
    protected $table = 'data_uang_penginapan';

    protected $fillable = [
        'provinsi',
        'gol_iv',
        'gol_iii_ii_i',
    ];
}
