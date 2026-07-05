<?php

namespace Database\Factories;

use App\Models\Rincian;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rincian>
 */
class RincianFactory extends Factory
{
    protected $model = Rincian::class;

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
            'pegawai_ditugaskan' => fake()->name(),
            'nip_pegawai' => fake()->numerify('##################'),
            'tujuan_kegiatan' => fake()->sentence(8),
            'berangkat_dari' => fake()->city(),
            'tempat_tujuan' => fake()->city(),
            'lama_kegiatan' => fake()->numberBetween(1, 14),
            'jenis_perjalanan' => fake()->randomElement(['Dalam Kota', 'Luar Kota', 'Luar Provinsi']),
            'alat_angkut' => fake()->randomElement(['Kendaraan Dinas', 'Pesawat', 'Kereta Api']),
            'kode_mak' => fake()->numerify('5###.###.###'),
            'ppk' => fake()->numerify('##################'),
            'nama_ppk' => fake()->name(),
            'nip_ppk' => fake()->numerify('##################'),
            'biaya_transport' => fake()->randomElement([null, 150000, 300000, 500000]),
            'penginapan' => fake()->randomElement([null, 1, 2, 3]),
            'hotel_ril' => fake()->randomElement([null, 350000, 500000, 750000]),
            'status' => 'draft',
            'pembuat_id' => User::factory(),
        ];
    }

    /**
     * State: Rincian sudah diajukan.
     */
    public function diajukan(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'diajukan',
        ]);
    }

    /**
     * State: Rincian sudah disetujui.
     */
    public function disetujui(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'disetujui',
        ]);
    }
}
