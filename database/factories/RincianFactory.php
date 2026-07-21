<?php

namespace Database\Factories;

use App\Models\Rincian;
use App\Models\Spd;
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
            'spd_id' => Spd::factory(),
            'rincian_biaya' => [
                'transport' => [
                    'Taksi' => [
                        ['biaya' => fake()->numberBetween(100000, 1000000)],
                    ]
                ],
                'penginapan' => [
                    [
                        'hotel_ril' => fake()->numberBetween(200000, 800000),
                        'penginapan_persen' => 100,
                    ]
                ],
            ],
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
