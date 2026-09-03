<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql' && Schema::hasTable('noticias')) {
            DB::statement('ALTER TABLE noticias MODIFY contenido LONGTEXT NOT NULL');
        }
    }

    public function down(): void
    {
        // Do not shrink to TEXT: current institutional publications exceed
        // MySQL's 64 KiB TEXT limit and would be truncated.
    }
};
