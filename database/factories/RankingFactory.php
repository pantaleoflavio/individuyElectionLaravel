<?php

namespace Database\Factories;

use App\Enums\RankingType;
use App\Models\Ranking;
use Illuminate\Database\Eloquent\Factories\Factory;
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
            'type' => $this->faker->randomElement(RankingType::values()), // add later 'federation' or other entities
            'status' => $this->faker->boolean,
            'category_id' => Category::factory(),
            'includes_inactive' => $this->faker->boolean,
        ];
    }
}
