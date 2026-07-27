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
        Schema::create('data_pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('kategori')->index();      // Kelompok pengaturan, misal: 'r2'
            $table->string('kunci');                  // Kunci unik per kategori, misal: 'access_key'
            $table->text('nilai')->nullable();        // Nilai, terenkripsi untuk data sensitif
            $table->timestamps();

            $table->unique(['kategori', 'kunci']);    // Pastikan kombinasi kategori+kunci unik
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pengaturan');
    }
};
