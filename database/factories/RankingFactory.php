<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ranking;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ranking>
 */
class RankingFactory extends Factory
{
    protected $model = Ranking::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(['wrestler', 'tag team', 'federation']),
            'status' => $this->faker->boolean,
            'category_id' => $this->faker->numberBetween(1, 10),
            'includes_inactive' => $this->faker->boolean,
        ];
    }
}
