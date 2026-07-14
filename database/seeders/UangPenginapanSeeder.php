<?php

namespace Database\Seeders;

use App\Models\UangPenginapan;
use Illuminate\Database\Seeder;

class UangPenginapanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('database/dbup.csv'), 'r');
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
            $gol_iv = (int) str_replace('.', '', trim($data[1] ?? '0'));
            $gol_iii_ii_i = (int) str_replace('.', '', trim($data[2] ?? '0'));

            UangPenginapan::updateOrCreate(
                ['provinsi' => $provinsi],
                [
                    'gol_iv' => $gol_iv,
                    'gol_iii_ii_i' => $gol_iii_ii_i,
                ]
            );
        }
        fclose($csvFile);
    }
}
