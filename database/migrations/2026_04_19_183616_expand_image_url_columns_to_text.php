<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE wrestlers MODIFY image_url TEXT NULL');
            DB::statement('ALTER TABLE tag_teams MODIFY image_url TEXT NULL');
            return;
        }

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE wrestlers ALTER COLUMN image_url TYPE TEXT');
            DB::statement('ALTER TABLE tag_teams ALTER COLUMN image_url TYPE TEXT');
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE wrestlers MODIFY image_url VARCHAR(255) NULL');
            DB::statement('ALTER TABLE tag_teams MODIFY image_url VARCHAR(255) NULL');
            return;
        }

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE wrestlers ALTER COLUMN image_url TYPE VARCHAR(255)');
            DB::statement('ALTER TABLE tag_teams ALTER COLUMN image_url TYPE VARCHAR(255)');
        }
    }
};