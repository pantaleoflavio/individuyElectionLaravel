<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\VoteTagTeam;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteTagTeamFactory extends Factory
{
    protected $model = VoteTagTeam::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'vote' => $this->faker->randomFloat(1, 0, 10),
        ];
    }
}
