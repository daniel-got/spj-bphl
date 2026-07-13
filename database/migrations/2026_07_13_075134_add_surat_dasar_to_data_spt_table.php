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
            // Kita cek dulu, jika kolom belum ada, baru kita tambahkan agar tidak error
            if (!Schema::hasColumn('data_spt', 'surat_dasar')) {
                $table->text('surat_dasar')->nullable()->after('tgl_spt');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_spt', function (Blueprint $table) {
            if (Schema::hasColumn('data_spt', 'surat_dasar')) {
                $table->dropColumn('surat_dasar');
            }
        });
    }
};