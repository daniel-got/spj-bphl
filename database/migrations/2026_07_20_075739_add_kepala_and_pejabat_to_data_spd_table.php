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
        Schema::table('data_spd', function (Blueprint $table) {
            $table->string('kepala_seksi_jabatan')->nullable();
            $table->string('kepala_seksi_nama')->nullable();
            $table->string('kepala_seksi_nip')->nullable();
            $table->string('pejabat_instansi_perusahaan')->nullable();
            $table->string('pejabat_instansi_perusahaan_nama')->nullable();
            $table->string('pejabat_instansi_perusahaan_nip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_spd', function (Blueprint $table) {
            $table->dropColumn([
                'kepala_seksi_jabatan',
                'kepala_seksi_nama',
                'kepala_seksi_nip',
                'pejabat_instansi_perusahaan',
                'pejabat_instansi_perusahaan_nama',
                'pejabat_instansi_perusahaan_nip',
            ]);
        });
    }
};
