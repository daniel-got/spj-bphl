<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Nomor SPD kini di-shared antar pegawai dalam satu SPT,
     * sehingga constraint unique di level database harus dihapus.
     * Uniqueness dijaga di application layer: satu pegawai hanya boleh
     * membuat satu SPD per SPT (lihat StoreSpdRequest & SpdService).
     */
    public function up(): void
    {
        Schema::table('data_spd', function (Blueprint $table) {
            $table->dropUnique('data_spd_nomor_spd_unique');
        });
    }

    public function down(): void
    {
        Schema::table('data_spd', function (Blueprint $table) {
            $table->unique('nomor_spd');
        });
    }
};
