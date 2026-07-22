<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kwitansi extends Model
{
    use HasFactory;

    protected $fillable = [
        'rincian_id',
        'nomor_kwitansi',
        'untuk_pembayaran',
    ];

    public function rincian(): BelongsTo
    {
        return $this->belongsTo(Rincian::class, 'rincian_id');
    }
}
