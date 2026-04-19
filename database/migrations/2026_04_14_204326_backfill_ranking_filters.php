<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $rankings = DB::table('rankings')->select(['id', 'category_id', 'federation_id', 'country'])->get();

        foreach ($rankings as $ranking) {
            if ($ranking->category_id) {
                DB::table('category_ranking')->insertOrIgnore([
                    'ranking_id' => $ranking->id,
                    'category_id' => $ranking->category_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($ranking->federation_id) {
                DB::table('federation_ranking')->insertOrIgnore([
                    'ranking_id' => $ranking->id,
                    'federation_id' => $ranking->federation_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($ranking->country) {
                DB::table('ranking_countries')->insertOrIgnore([
                    'ranking_id' => $ranking->id,
                    'country' => $ranking->country,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('category_ranking')->truncate();
        DB::table('federation_ranking')->truncate();
        DB::table('ranking_countries')->truncate();
    }
};