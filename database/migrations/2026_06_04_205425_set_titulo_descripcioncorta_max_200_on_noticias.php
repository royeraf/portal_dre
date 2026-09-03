<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        // SQL directo porque doctrine/dbal no está instalado (requerido para ->change()).
        DB::statement('ALTER TABLE noticias MODIFY titulo VARCHAR(200) NOT NULL');
        DB::statement('ALTER TABLE noticias MODIFY descripcioncorta VARCHAR(200) NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement('ALTER TABLE noticias MODIFY titulo VARCHAR(55) NOT NULL');
        DB::statement('ALTER TABLE noticias MODIFY descripcioncorta VARCHAR(70) NOT NULL');
    }
};
