<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_spd', function (Blueprint $table) {
            $table->foreignId('spt_id')->nullable()->after('id')->constrained('data_spt')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_spd', function (Blueprint $table) {
            $table->dropForeign(['spt_id']);
            $table->dropColumn('spt_id');
        });
    }
};
