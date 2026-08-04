<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_rincian', function (Blueprint $table) {
            // Hapus kolom lama yang hanya menampung 1 data
            $table->dropColumn(['biaya_transport', 'penginapan', 'hotel_ril', 'detail_transportasi']);
        });

        Schema::table('data_rincian', function (Blueprint $table) {
            // Ganti dengan satu kolom JSON yang bisa menampung banyak set data
            $table->json('rincian_biaya')->nullable()->after('nip_ppk');
        });
    }

    public function down(): void
    {
        Schema::table('data_rincian', function (Blueprint $table) {
            $table->dropColumn('rincian_biaya');
        });

        Schema::table('data_rincian', function (Blueprint $table) {
            $table->decimal('biaya_transport', 15, 2)->nullable();
            $table->integer('penginapan')->nullable();
            $table->decimal('hotel_ril', 15, 2)->nullable();
            $table->json('detail_transportasi')->nullable();
        });
    }
};
