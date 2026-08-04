<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom status dan pembuat_id ke tabel data_spt
     */
    public function up(): void
    {
        Schema::table('data_spt', function (Blueprint $table) {
            if (! Schema::hasColumn('data_spt', 'status')) {
                $table->string('status')->default('draft')->after('kode_mak');
            }
            if (! Schema::hasColumn('data_spt', 'pembuat_id')) {
                $table->foreignId('pembuat_id')->nullable()->constrained('users')->onDelete('set null')->after('status');
            }
        });
    }

    /**
     * Rollback: hapus kolom status dan pembuat_id
     */
    public function down(): void
    {
        Schema::table('data_spt', function (Blueprint $table) {
            if (Schema::hasColumn('data_spt', 'pembuat_id')) {
                $table->dropForeign(['pembuat_id']);
                $table->dropColumn('pembuat_id');
            }
            if (Schema::hasColumn('data_spt', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
