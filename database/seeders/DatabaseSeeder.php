<?php

use App\Models\User;
use App\Models\Category;
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
        User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@doe.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'image_path' => 'profile_images/john_doe_image.jpg',
        ]);

        // Creazione factory
        User::factory()->count(2)->create();
        Federation::factory()->count(5)->create();
        Category::factory()->count(10)->create();

        // Chiamata ai seeder
        $this->call([
            RankingSeeder::class,
            WrestlerSeeder::class,
            TagTeamSeeder::class,
        ]);

        // Popolamento di VoteWrestler evitando duplicati
        foreach (VoteWrestler::factory()->count(25)->make() as $voteWrestler) {
            VoteWrestler::insertOrIgnore($voteWrestler->toArray());
        }

        // Popolamento di VoteTagTeam evitando duplicati
        foreach (VoteTagTeam::factory()->count(20)->make() as $voteTagTeam) {
            VoteTagTeam::insertOrIgnore($voteTagTeam->toArray());
        }
    }
}
