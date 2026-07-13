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
        Schema::create('data_uang_penginapan', function (Blueprint $table) {
            $table->id();
            $table->string('provinsi')->unique();
            $table->bigInteger('gol_iv')->default(0);
            $table->bigInteger('gol_iii_ii_i')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_uang_penginapan');
    }
};
