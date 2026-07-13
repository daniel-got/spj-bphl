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
            if (Schema::hasColumn('data_spd', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('data_spd', 'alasan')) {
                $table->dropColumn('alasan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_spd', function (Blueprint $table) {
            $table->string('status')->default('draft');
            $table->text('alasan')->nullable();
        });
    }
};
