<?php

namespace Database\Factories;

use App\Enums\Golongan;
use App\Enums\Pangkat;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pegawai>
 */
class PegawaiFactory extends Factory
{
    protected $model = Pegawai::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nama_pegawai' => fake()->name(),
            'nip' => fake()->unique()->numerify('##################'),
            'pangkat' => fake()->randomElement(Pangkat::values()),
            'golongan' => fake()->randomElement(Golongan::values()),
            'jabatan' => fake()->jobTitle(),
            'sub_seksi' => fake()->randomElement(['TU', 'PEPHPHL', 'PPPHPHL', null]),
        ];
    }
}
