<?php

namespace Database\Seeders;

use App\Enums\RankingType;
use App\Models\Category;
use App\Models\Federation;
use App\Models\Ranking;
use App\Models\TagTeam;
use App\Models\User;
use App\Models\VoteTagTeam;
use App\Models\VoteWrestler;
use App\Models\Wrestler;
use Database\Seeders\RankingSeeder;
use Database\Seeders\TagTeamSeeder;
use Database\Seeders\WrestlerSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Creazione utente manuale
        User::firstOrCreate(
            ['username' => 'johndoe'],
            [
                'name' => 'John Doe',
                'email' => 'john@doe.com',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'image_path' => 'profile_images/john_doe_image.jpg',
            ]
        );

        // Creazione factory
        User::factory()->count(5)->create();
        Federation::factory()->count(5)->create();
        Category::factory()->count(10)->create();

        // Chiamata ai seeder
        $this->call([
            RankingSeeder::class,
            WrestlerSeeder::class,
            TagTeamSeeder::class,
        ]);

        $users = User::pluck('id');

        // VOTI WRESTLER
         $wrestlerRankings = Ranking::with('categories')
            ->where('type', RankingType::Wrestler->value)
            ->get();

        foreach ($wrestlerRankings as $ranking) {
            $categoryIds = $ranking->categories->pluck('id')->all();

            if (empty($categoryIds) && $ranking->category_id) {
                $categoryIds = [$ranking->category_id];
            }
            $candidateIds = Wrestler::query()
                ->where('is_active', true)
                ->when(!empty($categoryIds), function ($query) use ($categoryIds) {
                    $query->whereHas('categories', function ($categoryQuery) use ($categoryIds) {
                        $categoryQuery->whereIn('categories.id', $categoryIds);
                    });
                })
                ->pluck('id');

            if ($candidateIds->isEmpty()) {
                continue;
            }

            foreach ($users as $userId) {
                // Ogni utente vota 3 candidati per ranking (o meno se non bastano)
                $toVote = $candidateIds->random(min(3, $candidateIds->count()));

                foreach ($toVote as $wrestlerId) {
                    VoteWrestler::updateOrCreate(
                        [
                            'user_id' => $userId,
                            'ranking_id' => $ranking->id,
                            'wrestler_id' => $wrestlerId,
                        ],
                        [
                            'vote' => fake()->randomFloat(1, 0, 10),
                        ]
                    );
                }
            }
        }

        // VOTI TAG TEAM
        $tagTeamRankings = Ranking::with('categories')
            ->where('type', RankingType::TagTeam->value)
            ->get();

        foreach ($tagTeamRankings as $ranking) {
            $categoryIds = $ranking->categories->pluck('id')->all();

            if (empty($categoryIds) && $ranking->category_id) {
                $categoryIds = [$ranking->category_id];
            }

            $candidateIds = TagTeam::query()
                ->where('is_active', true)
                ->when(!empty($categoryIds), function ($query) use ($categoryIds) {
                    $query->whereHas('categories', function ($categoryQuery) use ($categoryIds) {
                        $categoryQuery->whereIn('categories.id', $categoryIds);
                    });
                })
                ->pluck('id');

            if ($candidateIds->isEmpty()) {
                continue;
            }

            foreach ($users as $userId) {
                $toVote = $candidateIds->random(min(3, $candidateIds->count()));

                foreach ($toVote as $tagTeamId) {
                    VoteTagTeam::updateOrCreate(
                        [
                            'user_id' => $userId,
                            'ranking_id' => $ranking->id,
                            'tag_team_id' => $tagTeamId,
                        ],
                        [
                            'vote' => fake()->randomFloat(1, 0, 10),
                        ]
                    );
                }
            }
        }
    }
}
