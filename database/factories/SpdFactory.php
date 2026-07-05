<?php

namespace Database\Factories;

use App\Models\Spd;
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
        $tglBerangkat = fake()->dateTimeBetween('now', '+1 month');
        $tglKembali = fake()->dateTimeBetween($tglBerangkat, '+2 months');
        $lama = (int) $tglBerangkat->diff($tglKembali)->days + 1;

        return [
            'nomor_spd' => 'SPD/'.fake()->unique()->numerify('###').'/BPHL/'.now()->year,
            'tgl_spd' => fake()->date(),
            'pegawai_ditugaskan' => fake()->name(),
            'nip_pegawai' => fake()->numerify('##################'),
            'pangkat_pegawai' => 'Penata',
            'jabatan_pegawai' => fake()->jobTitle(),
            'tujuan_kegiatan' => fake()->sentence(8),
            'tempat_tujuan' => fake()->city(),
            'tgl_berangkat' => $tglBerangkat->format('Y-m-d'),
            'tgl_kembali' => $tglKembali->format('Y-m-d'),
            'lama_kegiatan' => $lama,
            'kode_mak' => fake()->numerify('5###.###.###'),
            'jenis_perjalanan' => fake()->randomElement(['Dalam Kota', 'Luar Kota', 'Luar Provinsi']),
            'berangkat_dari' => fake()->city(),
            'alat_angkut' => fake()->randomElement(['Kendaraan Dinas', 'Pesawat', 'Kereta Api']),
            'ppk' => fake()->numerify('##################'),
            'nama_ppk' => fake()->name(),
            'nip_ppk' => fake()->numerify('##################'),
            'status' => 'draft',
            'pembuat_id' => User::factory(),
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
