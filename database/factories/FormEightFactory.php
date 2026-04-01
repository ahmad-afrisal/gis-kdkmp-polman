<?php

namespace Database\Factories;

use App\Models\Cooperation;
use App\Models\FormEight;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormEight>
 */
class FormEightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = FormEight::class;

    public function definition(): array
    {
        return [
            'cooperation_id' => Cooperation::inRandomOrder()->first()?->id,

            'land_readiness' => $this->faker->boolean(),

            // 0 : Belum, 1 : Selesai, 2 : Tidak Terbangun
            'store_development' => $this->faker->randomElement([0, 1, 2]),

            'vehicle' => $this->faker->boolean(),
            'table_and_chair' => $this->faker->boolean(),
            'display_case' => $this->faker->boolean(),
            'computer' => $this->faker->boolean(),

            'problem' => $this->faker->sentence(),
            'information' => $this->faker->sentence(),
        ];
    }
}
