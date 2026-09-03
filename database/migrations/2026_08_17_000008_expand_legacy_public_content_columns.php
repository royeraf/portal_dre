<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        if (Schema::hasTable('menus')) {
            DB::statement('ALTER TABLE menus MODIFY link_menu VARCHAR(500) NOT NULL');
        }
        if (Schema::hasTable('noticias')) {
            DB::statement('ALTER TABLE noticias MODIFY titulo VARCHAR(500) NOT NULL');
            DB::statement('ALTER TABLE noticias MODIFY descripcioncorta TEXT NOT NULL');
        }
        if (Schema::hasTable('convocatoria')) {
            DB::statement('ALTER TABLE convocatoria MODIFY titulo VARCHAR(500) NOT NULL');
        }
        if (Schema::hasTable('archivo_convocatoria')) {
            DB::statement('ALTER TABLE archivo_convocatoria MODIFY nom_archivo VARCHAR(500) NOT NULL');
            DB::statement('ALTER TABLE archivo_convocatoria MODIFY url_archivo VARCHAR(1000) NOT NULL');
        }
        if (Schema::hasTable('comunicados')) {
            DB::statement('ALTER TABLE comunicados MODIFY titulo VARCHAR(191) NOT NULL');
            DB::statement('ALTER TABLE comunicados MODIFY url VARCHAR(500) NOT NULL');
        }
        if (Schema::hasTable('slider')) {
            DB::statement('ALTER TABLE slider MODIFY link VARCHAR(500) NOT NULL');
        }
    }

    public function down(): void
    {
        // Intentionally do not shrink these columns: current institutional
        // records exceed the old limits and a rollback would truncate data.
    }
};
