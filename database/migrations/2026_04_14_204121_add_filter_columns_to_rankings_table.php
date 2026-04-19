<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('rankings', 'filter_type')) {
            Schema::table('rankings', function (Blueprint $table) {
                $table->string('filter_type')->default('category')->after('type');
            });
        }

        if (!Schema::hasColumn('rankings', 'federation_id')) {
            Schema::table('rankings', function (Blueprint $table) {
                $table->foreignId('federation_id')->nullable()->after('category_id')->constrained()->nullOnDelete();
            });
        }

        if (!Schema::hasColumn('rankings', 'country')) {
            Schema::table('rankings', function (Blueprint $table) {
                $table->string('country')->nullable()->after('federation_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('rankings', function (Blueprint $table) {
            if (Schema::hasColumn('rankings', 'federation_id')) {
                $table->dropConstrainedForeignId('federation_id');
            }

            $toDrop = [];

            if (Schema::hasColumn('rankings', 'filter_type')) {
                $toDrop[] = 'filter_type';
            }

            if (Schema::hasColumn('rankings', 'country')) {
                $toDrop[] = 'country';
            }

            if (!empty($toDrop)) {
                $table->dropColumn($toDrop);
            }
        });
    }
};