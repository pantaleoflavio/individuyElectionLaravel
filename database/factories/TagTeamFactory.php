<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TagTeam>
 */
class TagTeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'country' => $this->faker->country(),
            'category_id' => $this->faker->numberBetween(1, 10),
            'is_active' => $this->faker->boolean(80),
            'federation_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
