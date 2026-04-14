<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rankings', function (Blueprint $table) {
            $table->foreignId('federation_id')->nullable()->after('category_id')->constrained()->nullOnDelete();
            $table->string('country')->nullable()->after('federation_id');
        });
    }

    public function down(): void
    {
        Schema::table('rankings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('federation_id');
            $table->dropColumn('country');
        });
    }
};
