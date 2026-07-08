<?php

namespace Database\Factories;

use App\Models\Spd;
use App\Models\Spt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Spd>
 */
class SpdFactory extends Factory
{
    protected $model = Spd::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomor_spd' => 'SPD/'.fake()->unique()->numerify('###').'/BPHL/'.now()->year,
            'tgl_spd' => fake()->date(),
            'nip_pegawai' => fake()->numerify('##################'),
            'berangkat_dari' => fake()->city(),
            'alat_angkut' => [fake()->randomElement(['Kendaraan Dinas', 'Pesawat', 'Kereta Api'])],
            'ppk' => fake()->randomElement(['Pejabat Pembuat Komitmen 1', 'Pejabat Pembuat Komitmen 2']),
            'nama_ppk' => fake()->name(),
            'nip_ppk' => fake()->numerify('##################'),
            'status' => 'draft',
            'pembuat_id' => User::factory(),
            'spt_id' => Spt::factory(),
        ];
    }

    /**
     * State: SPD sudah diajukan.
     */
    public function diajukan(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'diajukan',
        ]);
    }

    /**
     * State: SPD sudah disetujui.
     */
    public function disetujui(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'disetujui',
        ]);
    }
}
