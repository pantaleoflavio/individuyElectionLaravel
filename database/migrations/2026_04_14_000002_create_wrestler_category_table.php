<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_wrestler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wrestler_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['wrestler_id', 'category_id']);
        });

        DB::table('wrestlers')
            ->whereNotNull('category_id')
            ->orderBy('id')
            ->chunkById(100, function ($wrestlers): void {
                $rows = [];
                $now = now();

                foreach ($wrestlers as $wrestler) {
                    $rows[] = [
                        'wrestler_id' => $wrestler->id,
                        'category_id' => $wrestler->category_id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                if ($rows !== []) {
                    DB::table('category_wrestler')->insertOrIgnore($rows);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_wrestler');
    }
};
