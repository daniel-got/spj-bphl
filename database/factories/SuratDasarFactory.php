<?php

namespace Database\Factories;

use App\Models\SuratDasar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SuratDasar>
 */
class SuratDasarFactory extends Factory
{
    protected $model = SuratDasar::class;

    public function definition(): array
    {
        return [
            'teks' => fake()->sentence(10),
            'aktif' => true,
        ];
    }

    public function nonaktif(): static
    {
        return $this->state(fn (array $attributes) => ['aktif' => false]);
    }
}
