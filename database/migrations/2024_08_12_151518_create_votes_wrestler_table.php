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
        Schema::create('votes_wrestler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ranking_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('wrestler_id')->constrained('wrestlers')->onDelete('cascade');
            $table->float('vote');
            $table->timestamps();

            // Vincolo per garantire che ogni utente possa votare solo una volta per ogni wrestler in un ranking specifico
            $table->unique(['ranking_id', 'user_id', 'wrestler_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes_wrestler');
    }
};
