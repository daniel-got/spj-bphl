<?php

namespace Database\Factories;

use App\Models\Spt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Spt>
 */
class SptFactory extends Factory
{
    protected $model = Spt::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tglBerangkat = fake()->dateTimeBetween('now', '+1 month');
        $tglKembali = fake()->dateTimeBetween($tglBerangkat, '+2 months');
        $lama = (int) $tglBerangkat->diff($tglKembali)->days + 1;

        return [
            'nomor_spt' => 'SPT/'.fake()->unique()->numerify('###').'/BPHL/'.now()->year,
            'tgl_spt' => fake()->date(),
            'pegawai_ditugaskan' => [
                [
                    'nama' => fake()->name(),
                    'nip' => fake()->numerify('##################'),
                    'pangkat' => 'Penata',
                    'jabatan' => fake()->jobTitle(),
                ],
            ],
            'tujuan_kegiatan' => fake()->sentence(8),
            'tempat_tujuan' => fake()->city(),
            'tgl_berangkat' => $tglBerangkat->format('Y-m-d'),
            'tgl_kembali' => $tglKembali->format('Y-m-d'),
            'lama_kegiatan' => $lama,
            'kode_mak' => fake()->numerify('5###.###.###'),
            'status' => 'draft',
            'pembuat_id' => User::factory(),
        ];
    }

    /**
     * State: SPT sudah diajukan.
     */
    public function diajukan(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'diajukan',
        ]);
    }

    /**
     * State: SPT sudah disetujui.
     */
    public function disetujui(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'disetujui',
        ]);
    }
}
