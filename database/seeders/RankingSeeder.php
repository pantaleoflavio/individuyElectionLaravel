<?php

namespace Database\Seeders;

use App\Models\Ranking;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RankingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        
        Ranking::factory()->count(10)->create();
    }
}
