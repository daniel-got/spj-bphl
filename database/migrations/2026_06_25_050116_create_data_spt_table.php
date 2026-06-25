<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_spt', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_spt')->unique();
            $table->date('tgl_spt');
            $table->json('pegawai_ditugaskan');
            $table->text('tujuan_kegiatan');
            $table->string('tempat_tujuan');
            $table->date('tgl_berangkat');
            $table->date('tgl_kembali');
            $table->integer('lama_kegiatan');
            $table->string('kode_mak');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_spt');
    }
};