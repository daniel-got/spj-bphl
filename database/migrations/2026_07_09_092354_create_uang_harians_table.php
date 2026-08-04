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
        Schema::create('data_uang_harian', function (Blueprint $table) {
            $table->id();
            $table->string('provinsi')->unique();
            $table->integer('luar_kota')->default(0);
            $table->integer('dalam_kota_lebih_8_jam')->default(0);
            $table->integer('diklat')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_uang_harian');
    }
};
