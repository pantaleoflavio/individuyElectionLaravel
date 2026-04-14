<?php

namespace Database\Factories;

use App\Enums\RankingType;
use App\Models\Category;
use App\Models\Federation;
use App\Models\Ranking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ranking>
 */
class RankingFactory extends Factory
{
    protected $model = Ranking::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(RankingType::values()),
            'status' => $this->faker->boolean,
            'category_id' => Category::factory(),
            'federation_id' => Federation::factory(),
            'country' => null,
            'includes_inactive' => $this->faker->boolean,
        ];
    }
}
