<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('data_spd', function (Blueprint $table) {
            $table->json('destinasi')->nullable()->after('pejabat_ditugaskan');
        });

        // Migrasi data lama: konversi pejabat_instansi_perusahaan ke array destinasi
        DB::table('data_spd')
            ->whereNotNull('pejabat_instansi_perusahaan')
            ->orWhereNotNull('pejabat_instansi_perusahaan_nama')
            ->orderBy('id')
            ->each(function ($spd) {
                $destinasi = [
                    [
                        'tiba_di' => '',
                        'tgl_tiba' => '',
                        'berangkat_dari' => '',
                        'tujuan_selanjutnya' => '',
                        'tgl_berangkat' => '',
                        'pejabat_jabatan' => $spd->pejabat_instansi_perusahaan ?? '',
                        'pejabat_nama' => $spd->pejabat_instansi_perusahaan_nama ?? '',
                        'pejabat_nip' => $spd->pejabat_instansi_perusahaan_nip ?? '',
                    ],
                ];

                DB::table('data_spd')->where('id', $spd->id)->update([
                    'destinasi' => json_encode($destinasi),
                ]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_spd', function (Blueprint $table) {
            $table->dropColumn('destinasi');
        });
    }
};
