<?php

namespace Database\Seeders;

use App\Models\Wrestler;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WrestlerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Wrestler::factory()->count(50)->create();
    }
}
