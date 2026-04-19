<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tag_team_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_team_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['tag_team_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tag_team_category');
    }
};