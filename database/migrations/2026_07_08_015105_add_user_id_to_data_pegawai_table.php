<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom user_id ke tabel data_pegawai jika belum ada.
     */
    public function up(): void
    {
        Schema::table('data_pegawai', function (Blueprint $table) {
            if (! Schema::hasColumn('data_pegawai', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Rollback: hapus kolom user_id.
     */
    public function down(): void
    {
        Schema::table('data_pegawai', function (Blueprint $table) {
            if (Schema::hasColumn('data_pegawai', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
