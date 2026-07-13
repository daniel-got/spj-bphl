<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('database/data_dummy_pegawai.csv'), 'r');
        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ',')) !== false) {
            // Skip baris kosong atau yang tidak punya data lengkap
            if (count($data) < 9) {
                continue;
            }

            if (! $firstline) {
                // 1. Buat User (Idempotent)
                $user = User::firstOrCreate(
                    ['email' => $data[6]],
                    [
                        'name' => $data[0],
                        'password' => Hash::make($data[7]), // password123
                        'role' => $data[8],
                    ]
                );

                // 2. Buat Pegawai terhubung ke User jika belum ada
                $exists = DB::table('data_pegawai')->where('user_id', $user->id)->exists();

                if (! $exists) {
                    DB::table('data_pegawai')->insert([
                        'user_id' => $user->id,
                        'nama_pegawai' => $data[0],
                        'nip' => $data[1],
                        'pangkat' => $data[2],
                        'golongan' => $data[3],
                        'jabatan' => $data[4],
                        'sub_seksi' => $data[5],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
