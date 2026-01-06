<?php

use App\Models\User;
use App\Models\Ranking;
use App\Models\TagTeam;
use App\Models\Category;
use App\Models\Wrestler;
use App\Models\Federation;
use App\Models\VoteTagTeam;
use App\Models\VoteWrestler;
use Illuminate\Database\Seeder;
use Database\Seeders\RankingSeeder;
use Database\Seeders\TagTeamSeeder;
use Database\Seeders\WrestlerSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Creazione utente manuale
        User::firstOrCreate([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@doe.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'image_path' => 'profile_images/john_doe_image.jpg',
        ]);

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
        $wrestlerRankings = Ranking::where('type', 'wrestler')->get();

        foreach ($wrestlerRankings as $ranking) {
            $candidateIds = Wrestler::query()
                ->where('category_id', $ranking->category_id)
                ->where('is_active', true)
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
        $tagTeamRankings = Ranking::where('type', 'tag team')->get();

        foreach ($tagTeamRankings as $ranking) {
            $candidateIds = TagTeam::query()
                ->where('category_id', $ranking->category_id)
                ->where('is_active', true)
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
