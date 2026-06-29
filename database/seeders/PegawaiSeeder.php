<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data_dummy_pegawai.csv"), "r");
        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ",")) !== false) {
            if (!$firstline) {
                // 1. Buat User
                $user = User::create([
                    'name'     => $data[0],
                    'email'    => $data[6],
                    'password' => Hash::make($data[7]), // password123
                    'role'     => $data[8],
                ]);

                // 2. Buat Pegawai terhubung ke User
                DB::table('data_pegawai')->insert([
                    'user_id'          => $user->id,
                    'nama_pegawai'     => $data[0],
                    'nip'              => $data[1],
                    'pangkat'          => $data[2],
                    'golongan'         => $data[3],
                    'jabatan'          => $data[4],
                    'sub_seksi'        => $data[5],
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
