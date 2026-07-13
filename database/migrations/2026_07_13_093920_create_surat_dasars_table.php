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
        Schema::create('data_surat_dasar', function (Blueprint $table) {
            $table->id();
            $table->text('teks')->unique();  // Isi teks surat dasar (unik)
            $table->boolean('aktif')->default(true); // Tampilkan atau sembunyikan dari dropdown
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_surat_dasar');
    }
};
