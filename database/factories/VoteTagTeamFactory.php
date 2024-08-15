<?php

namespace Database\Factories;

use App\Models\VoteTagTeam;
use App\Models\Ranking;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteTagTeamFactory extends Factory
{
    protected $model = VoteTagTeam::class;

    public function definition(): array
    {
        $tagTeamRankingIds = Ranking::where('type', 'tag team')->pluck('id')->toArray();

        return [
            'user_id' => $this->faker->numberBetween(1, 3),
            'tag_team_id' => $this->faker->numberBetween(1, 20),
            'ranking_id' => $this->faker->randomElement($tagTeamRankingIds),
            'vote' => $this->faker->randomFloat(1, 0, 10),
        ];
    }
}
