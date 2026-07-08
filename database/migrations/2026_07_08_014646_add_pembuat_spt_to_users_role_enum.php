<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom role ke tabel users jika belum ada,
     * dan ubah ke string agar mendukung nilai seperti 'pembuat_spt'.
     */
    public function up(): void
    {
        // Karena PostgreSQL menggunakan CHECK constraint untuk ENUM Laravel, kita hapus constraint-nya.
        // HANYA jalankan perintah ini jika menggunakan PostgreSQL (agar tidak error saat testing dengan SQLite)
        if (\Illuminate\Support\Facades\DB::getDriverName() === 'pgsql') {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
        }

        Schema::table('users', function (Blueprint $table) {
            // Ubah tipe kolom menjadi string biasa
            $table->string('role')->default('user')->change();
        });
    }

    /**
     * Rollback: hapus kolom role.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
