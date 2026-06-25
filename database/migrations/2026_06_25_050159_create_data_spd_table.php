<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_spd', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_spd')->unique();
            $table->date('tgl_spd');
            $table->string('pegawai_ditugaskan');
            $table->string('nip_pegawai');
            $table->string('pangkat_pegawai')->nullable();
            $table->string('jabatan_pegawai')->nullable();
            $table->text('tujuan_kegiatan');
            $table->string('tempat_tujuan');
            $table->date('tgl_berangkat');
            $table->date('tgl_kembali');
            $table->integer('lama_kegiatan');
            $table->string('kode_mak');
            $table->string('jenis_perjalanan');
            $table->string('berangkat_dari');
            $table->string('alat_angkut')->nullable();
            $table->string('ppk')->nullable();
            $table->string('nama_ppk')->nullable();
            $table->string('nip_ppk')->nullable();
            $table->json('pejabat_ditugaskan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_spd');
    }
};