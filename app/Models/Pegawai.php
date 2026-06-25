<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    // Nama tabel sesuai acuan dokumen 
    protected $table = 'data_pegawai';

    // Kolom yang dapat diisi (fillable) sesuai spesifikasi dokumen 
    protected $fillable = [
        'nama_pegawai',      // Nama Pegawai 
        'nip',               // NIP 
        'pangkat_golongan',  // Pangkat/Golongan 
        'jabatan',           // Jabatan 
        'sub_seksi',         // Sub/Seksi 
    ];
}