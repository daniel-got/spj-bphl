<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Normalisasi data_spd (menghapus duplikasi dari SPT)
        Schema::table('data_spd', function (Blueprint $table) {
            $table->dropColumn([
                'pegawai_ditugaskan',
                'pangkat_pegawai',
                'jabatan_pegawai',
                'tujuan_kegiatan',
                'tempat_tujuan',
                'tgl_berangkat',
                'tgl_kembali',
                'lama_kegiatan',
                'kode_mak',
                'jenis_perjalanan', // Tambahan kolom yang harus dihapus karena ada di SPT
            ]);
        });

        // 2. Normalisasi data_rincian (menambahkan spd_id dan menghapus duplikasi dari SPD/SPT)
        Schema::table('data_rincian', function (Blueprint $table) {
            $table->foreignId('spd_id')->after('id')->nullable()->constrained('data_spd')->onDelete('cascade');

            $table->dropColumn([
                'nomor_spd',
                'tgl_spd',
                'pegawai_ditugaskan',
                'nip_pegawai',
                'tujuan_kegiatan',
                'berangkat_dari',
                'tempat_tujuan',
                'lama_kegiatan',
                'jenis_perjalanan',
                'alat_angkut',
                'kode_mak',
                'ppk',
                'nama_ppk',
                'nip_ppk',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_rincian', function (Blueprint $table) {
            $table->dropForeign(['spd_id']);
            $table->dropColumn('spd_id');

            $table->string('nomor_spd')->nullable();
            $table->date('tgl_spd')->nullable();
            $table->string('pegawai_ditugaskan')->nullable();
            $table->string('nip_pegawai')->nullable();
            $table->text('tujuan_kegiatan')->nullable();
            $table->string('berangkat_dari')->nullable();
            $table->string('tempat_tujuan')->nullable();
            $table->integer('lama_kegiatan')->nullable();
            $table->string('jenis_perjalanan')->nullable();
            $table->string('alat_angkut')->nullable();
            $table->string('kode_mak')->nullable();
            $table->string('ppk')->nullable();
            $table->string('nama_ppk')->nullable();
            $table->string('nip_ppk')->nullable();
        });

        Schema::table('data_spd', function (Blueprint $table) {
            $table->string('pegawai_ditugaskan')->nullable();
            $table->string('pangkat_pegawai')->nullable();
            $table->string('jabatan_pegawai')->nullable();
            $table->text('tujuan_kegiatan')->nullable();
            $table->string('tempat_tujuan')->nullable();
            $table->date('tgl_berangkat')->nullable();
            $table->date('tgl_kembali')->nullable();
            $table->integer('lama_kegiatan')->nullable();
            $table->string('kode_mak')->nullable();
        });
    }
};
