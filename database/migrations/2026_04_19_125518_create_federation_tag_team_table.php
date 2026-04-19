<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('federation_tag_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_team_id')->constrained()->onDelete('cascade');
            $table->foreignId('federation_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['tag_team_id', 'federation_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('federation_tag_team');
    }
};