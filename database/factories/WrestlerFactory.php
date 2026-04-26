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

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'country' => $this->faker->country(),
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
            'is_active' => $this->faker->boolean(80),
            'federation_id' => Federation::query()->inRandomOrder()->value('id') ?? Federation::factory(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Wrestler $wrestler): void {
            $categoryId = Category::query()->inRandomOrder()->value('id') ?? Category::factory()->create()->id;
            $federationId = Federation::query()->inRandomOrder()->value('id') ?? Federation::factory()->create()->id;

            $wrestler->categories()->syncWithoutDetaching([$categoryId]);
            $wrestler->federations()->syncWithoutDetaching([$federationId]);
        });
    }
}
