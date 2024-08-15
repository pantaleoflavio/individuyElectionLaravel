<?php
namespace Database\Factories;

use App\Models\VoteWrestler;
use App\Models\Ranking;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteWrestlerFactory extends Factory
{
    protected $model = VoteWrestler::class;

    public function definition(): array
    {
        $wrestlerRankingIds = Ranking::where('type', 'wrestler')->pluck('id')->toArray();

        return [
            'user_id' => $this->faker->numberBetween(1, 3),
            'wrestler_id' => $this->faker->numberBetween(1, 25),
            'ranking_id' => $this->faker->randomElement($wrestlerRankingIds),
            'vote' => $this->faker->randomFloat(1, 0, 10),
        ];
    }
}
