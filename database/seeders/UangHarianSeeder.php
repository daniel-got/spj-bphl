<?php

namespace Database\Seeders;

use App\Models\UangHarian;
use Illuminate\Database\Seeder;

class UangHarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('database/dbuh.csv'), 'r');
        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ';')) !== false) {
            if ($firstline) {
                $firstline = false;

                continue;
            }

            if (empty(trim($data[0]))) {
                continue;
            }

            $provinsi = trim($data[0]);
            $luarKota = (int) str_replace('.', '', trim($data[1] ?? '0'));
            $dalamKota = (int) str_replace('.', '', trim($data[2] ?? '0'));
            $diklat = (int) str_replace('.', '', trim($data[3] ?? '0'));

            UangHarian::updateOrCreate(
                ['provinsi' => $provinsi],
                [
                    'luar_kota' => $luarKota,
                    'dalam_kota_lebih_8_jam' => $dalamKota,
                    'diklat' => $diklat,
                ]
            );
        }
        fclose($csvFile);
    }
}
