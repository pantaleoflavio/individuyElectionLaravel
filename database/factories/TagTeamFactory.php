<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Federation;
use App\Models\TagTeam;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TagTeam>
 */
class TagTeamFactory extends Factory
{
    protected $model = TagTeam::class;

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
             'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
            'is_active' => $this->faker->boolean(80),
            'federation_id' => Federation::query()->inRandomOrder()->value('id') ?? Federation::factory(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (TagTeam $tagTeam): void {
            $categoryId = Category::query()->inRandomOrder()->value('id') ?? Category::factory()->create()->id;
            $federationId = Federation::query()->inRandomOrder()->value('id') ?? Federation::factory()->create()->id;

            $tagTeam->categories()->syncWithoutDetaching([$categoryId]);
            $tagTeam->federations()->syncWithoutDetaching([$federationId]);
        });
    }
}
