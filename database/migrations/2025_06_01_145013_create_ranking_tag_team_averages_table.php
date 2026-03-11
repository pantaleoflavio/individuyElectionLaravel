<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ranking_tag_team_averages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ranking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_team_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('votes_count')->default(0);
            $table->decimal('votes_sum', 8, 2)->default(0);
            $table->decimal('average_vote', 8, 2)->default(0);
            $table->timestamps();

            $table->unique(['ranking_id', 'tag_team_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ranking_tag_team_averages');
    }
};
