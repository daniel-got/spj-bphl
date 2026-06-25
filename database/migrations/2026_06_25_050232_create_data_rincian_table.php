<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_rincian', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_spd');
            $table->date('tgl_spd');
            $table->string('pegawai_ditugaskan');
            $table->string('nip_pegawai');
            $table->text('tujuan_kegiatan');
            $table->string('berangkat_dari');
            $table->string('tempat_tujuan');
            $table->integer('lama_kegiatan');
            $table->string('jenis_perjalanan');
            $table->string('alat_angkut')->nullable();
            $table->string('kode_mak')->nullable();
            $table->string('ppk')->nullable();
            $table->string('nama_ppk')->nullable();
            $table->string('nip_ppk')->nullable();
            $table->decimal('biaya_transport', 15, 2)->nullable();
            $table->integer('penginapan')->nullable();
            $table->decimal('hotel_ril', 15, 2)->nullable();
            $table->json('detail_transportasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_rincian');
    }
};