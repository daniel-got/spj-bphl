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
            if (! Schema::hasColumn('data_spt', 'penanggung_jawab')) {
                $table->string('penanggung_jawab')->nullable()->after('pegawai_ditugaskan');
            }
            if (! Schema::hasColumn('data_spt', 'anggota')) {
                $table->text('anggota')->nullable()->after('penanggung_jawab');
            }
            if (! Schema::hasColumn('data_spt', 'menimbang')) {
                $table->text('menimbang')->nullable()->after('anggota');
            }
            if (! Schema::hasColumn('data_spt', 'dasar')) {
                $table->text('dasar')->nullable()->after('menimbang');
            }
            if (! Schema::hasColumn('data_spt', 'biaya')) {
                $table->text('biaya')->nullable()->after('dasar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_spt', function (Blueprint $table) {
            foreach (['biaya', 'dasar', 'menimbang', 'anggota', 'penanggung_jawab'] as $column) {
                if (Schema::hasColumn('data_spt', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
