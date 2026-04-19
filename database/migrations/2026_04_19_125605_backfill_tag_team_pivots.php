<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tagTeams = DB::table('tag_teams')->select(['id', 'category_id', 'federation_id'])->get();

        foreach ($tagTeams as $tagTeam) {
            if ($tagTeam->category_id) {
                DB::table('tag_team_category')->insertOrIgnore([
                    'tag_team_id' => $tagTeam->id,
                    'category_id' => $tagTeam->category_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($tagTeam->federation_id) {
                DB::table('federation_tag_team')->insertOrIgnore([
                    'tag_team_id' => $tagTeam->id,
                    'federation_id' => $tagTeam->federation_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('tag_team_category')->truncate();
        DB::table('federation_tag_team')->truncate();
    }
};