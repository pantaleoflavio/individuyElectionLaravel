<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Federation;
use App\Models\Wrestler;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wrestler>
 */
class WrestlerFactory extends Factory
{
    protected $model = Wrestler::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'country' => $this->faker->country(),
            'category_id' => Category::factory(),
            'federation_id' => Federation::factory(),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
