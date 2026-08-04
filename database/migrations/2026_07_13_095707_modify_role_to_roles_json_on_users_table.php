<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambahkan kolom roles
        Schema::table('users', function (Blueprint $table) {
            $table->jsonb('roles')->default('["user"]')->after('role');
        });

        // 2. Migrasikan data dari role ke roles
        DB::table('users')->orderBy('id')->chunk(100, function ($users) {
            foreach ($users as $user) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'roles' => json_encode([$user->role]),
                    ]);
            }
        });

        // 3. Hapus kolom role yang lama
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles_json_on_users', function (Blueprint $table) {
            //
        });
    }
};
