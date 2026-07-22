<?php

namespace Database\Seeders;

use App\Models\SuratDasar;
use Illuminate\Database\Seeder;

class SuratDasarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SuratDasar::truncate();

        $pt1 = 'Peraturan Menteri Kehutanan Republik Indonesia Nomor 6 Tahun 2025 Tentang Organisasi dan Tata Kerja Balai Pengelolaan Hutan Lestari tanggal 19 Maret 2025;';
        $pt2_rev6 = 'Surat Pengesahan Daftar Isian Pelaksanaan Anggaran (DIPA) Balai 143.06.2.693523/2026 Rev-6 tanggal 25 Mei 2026;';
        $pt2_satker = 'Surat Pengesahan Daftar Isian Pelaksanaan Anggaran (DIPA) Satker Balai Pengelolaan Hutan Lestari 143.06.2.693523/2026 tanggal 1 Desember 2025;';

        SuratDasar::create(['teks' => $pt1, 'jenis_spt' => 'pelatihan', 'aktif' => true]);
        SuratDasar::create(['teks' => $pt2_rev6, 'jenis_spt' => 'pelatihan', 'aktif' => true]);

        SuratDasar::create(['teks' => $pt1, 'jenis_spt' => 'keuangan', 'aktif' => true]);
        SuratDasar::create(['teks' => $pt2_rev6, 'jenis_spt' => 'keuangan', 'aktif' => true]);

        SuratDasar::create(['teks' => $pt1, 'jenis_spt' => 'administrasi', 'aktif' => true]);
        SuratDasar::create(['teks' => $pt2_satker, 'jenis_spt' => 'administrasi', 'aktif' => true]);

        // Seed any custom master points created by users from custom_surat_dasar.json
        $customJsonPath = storage_path('app/custom_surat_dasar.json');
        if (file_exists($customJsonPath)) {
            $customPoints = json_decode(file_get_contents($customJsonPath), true);
            if (is_array($customPoints)) {
                foreach ($customPoints as $item) {
                    if (! empty($item['teks'])) {
                        SuratDasar::firstOrCreate(
                            [
                                'teks' => $item['teks'],
                                'jenis_spt' => $item['jenis_spt'] ?? null,
                            ],
                            [
                                'aktif' => $item['aktif'] ?? true,
                            ]
                        );
                    }
                }
            }
        }
    }
}
