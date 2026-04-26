<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('wrestlers', 'category_id')) {
            $wrestlers = DB::table('wrestlers')->select(['id', 'category_id', 'federation_id'])->get();

            foreach ($wrestlers as $wrestler) {
                if ($wrestler->category_id) {
                    DB::table('wrestler_category')->insertOrIgnore([
                        'wrestler_id' => $wrestler->id,
                        'category_id' => $wrestler->category_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                if ($wrestler->federation_id) {
                    DB::table('federation_wrestler')->insertOrIgnore([
                        'wrestler_id' => $wrestler->id,
                        'federation_id' => $wrestler->federation_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        if (Schema::hasColumn('tag_teams', 'category_id')) {
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

        Schema::table('wrestlers', function (Blueprint $table): void {
            if (Schema::hasColumn('wrestlers', 'category_id')) {
                $table->dropConstrainedForeignId('category_id');
            }

            if (Schema::hasColumn('wrestlers', 'federation_id')) {
                $table->dropConstrainedForeignId('federation_id');
            }
        });

        Schema::table('tag_teams', function (Blueprint $table): void {
            if (Schema::hasColumn('tag_teams', 'category_id')) {
                $table->dropConstrainedForeignId('category_id');
            }

            if (Schema::hasColumn('tag_teams', 'federation_id')) {
                $table->dropConstrainedForeignId('federation_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('wrestlers', function (Blueprint $table): void {
            if (!Schema::hasColumn('wrestlers', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('country')->constrained()->nullOnDelete();
            }

            if (!Schema::hasColumn('wrestlers', 'federation_id')) {
                $table->foreignId('federation_id')->nullable()->after('category_id')->constrained()->nullOnDelete();
            }
        });

        Schema::table('tag_teams', function (Blueprint $table): void {
            if (!Schema::hasColumn('tag_teams', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('country')->constrained()->nullOnDelete();
            }

            if (!Schema::hasColumn('tag_teams', 'federation_id')) {
                $table->foreignId('federation_id')->nullable()->after('category_id')->constrained()->nullOnDelete();
            }
        });
    }
};