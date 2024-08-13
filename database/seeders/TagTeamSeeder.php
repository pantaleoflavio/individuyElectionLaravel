<?php

namespace Database\Seeders;

use App\Models\TagTeam;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TagTeam::factory()->count(20)->create();
    }
}
