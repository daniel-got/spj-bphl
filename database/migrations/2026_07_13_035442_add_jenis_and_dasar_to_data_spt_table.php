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
        Schema::table('data_spt', function (Blueprint $table) {
            $table->string('jenis_tugas')->nullable(); // Pilihan: pelatihan, keuangan, administrasi
            $table->text('surat_dasar')->nullable();   // Bunyi teks undangan/nota dinas poin 3
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_spt', function (Blueprint $table) {
            $table->dropColumn(['jenis_tugas', 'surat_dasar']);
        });
    }
};