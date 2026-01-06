<?php
namespace Database\Factories;

use App\Models\User;
use App\Models\VoteWrestler;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteWrestlerFactory extends Factory
{
    protected $model = VoteWrestler::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'vote' => $this->faker->randomFloat(1, 0, 10),
        ];
    }
}
