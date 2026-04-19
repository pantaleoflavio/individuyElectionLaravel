<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_ranking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ranking_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['ranking_id', 'category_id']);
        });

        Schema::create('federation_ranking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ranking_id')->constrained()->onDelete('cascade');
            $table->foreignId('federation_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['ranking_id', 'federation_id']);
        });

        Schema::create('ranking_countries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ranking_id')->constrained()->onDelete('cascade');
            $table->string('country');
            $table->timestamps();
            $table->unique(['ranking_id', 'country']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ranking_countries');
        Schema::dropIfExists('federation_ranking');
        Schema::dropIfExists('category_ranking');
    }
};