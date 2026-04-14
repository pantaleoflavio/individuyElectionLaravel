<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('wrestler_category') && !Schema::hasTable('category_wrestler')) {
            Schema::rename('wrestler_category', 'category_wrestler');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('category_wrestler') && !Schema::hasTable('wrestler_category')) {
            Schema::rename('category_wrestler', 'wrestler_category');
        }
    }
};
