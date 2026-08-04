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
        // Hanya hapus jika index/constraint tersebut ada di database (production).
        // Kita tangkap exception-nya agar tidak error di local jika index-nya tidak ada.
        try {
            Schema::table('data_surat_dasar', function (Blueprint $table) {
                $table->dropUnique('data_surat_dasar_teks_unique');
            });
        } catch (Exception $e) {
            // Index tidak ditemukan, tidak perlu melakukan apa-apa.
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_surat_dasar', function (Blueprint $table) {
            //
        });
    }
};
