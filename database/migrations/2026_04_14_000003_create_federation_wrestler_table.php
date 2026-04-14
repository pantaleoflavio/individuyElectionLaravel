<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('federation_wrestler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wrestler_id')->constrained()->cascadeOnDelete();
            $table->foreignId('federation_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['wrestler_id', 'federation_id']);
        });

        DB::table('wrestlers')
            ->whereNotNull('federation_id')
            ->orderBy('id')
            ->chunkById(100, function ($wrestlers): void {
                $rows = [];
                $now = now();

                foreach ($wrestlers as $wrestler) {
                    $rows[] = [
                        'wrestler_id' => $wrestler->id,
                        'federation_id' => $wrestler->federation_id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                if ($rows !== []) {
                    DB::table('federation_wrestler')->insertOrIgnore($rows);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('federation_wrestler');
    }
};
