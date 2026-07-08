<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Perbaiki skema data_pegawai agar sesuai model Pegawai:
     * - Hapus kolom 'pangkat_golongan' (gabungan lama)
     * - Tambah kolom 'pangkat' dan 'golongan' terpisah
     */
    public function up(): void
    {
        Schema::table('data_pegawai', function (Blueprint $table) {
            $table->dropColumn('pangkat_golongan');
        });

        Schema::table('data_pegawai', function (Blueprint $table) {
            $table->string('pangkat')->nullable()->after('nip');
            $table->string('golongan')->nullable()->after('pangkat');
        });
    }

    /**
     * Rollback: kembalikan ke pangkat_golongan gabungan.
     */
    public function down(): void
    {
        Schema::table('data_pegawai', function (Blueprint $table) {
            if (Schema::hasColumn('data_pegawai', 'pangkat')) {
                $table->dropColumn('pangkat');
            }
            if (Schema::hasColumn('data_pegawai', 'golongan')) {
                $table->dropColumn('golongan');
            }
        });

        Schema::table('data_pegawai', function (Blueprint $table) {
            if (! Schema::hasColumn('data_pegawai', 'pangkat_golongan')) {
                $table->string('pangkat_golongan')->nullable()->after('nip');
            }
        });
    }
};
