<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institucion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45);
            $table->string('titulo', 45);
            $table->string('slogan', 90);
            $table->string('direccion', 90);
            $table->string('email', 55);
            $table->string('celular', 12);
            $table->string('director_apenom', 75);
            $table->char('director_dni',8);
            $table->string('director_email', 65);
            $table->string('director_foto', 30);
            $table->string('director_celular', 12);
            $table->string('agp_apenom', 75);
            $table->char('agp_dni',8);
            $table->string('agp_email', 65);
            $table->string('agp_foto', 30);
            $table->string('agp_celular', 12);
            $table->string('agi_apenom', 75);
            $table->char('agi_dni',8);
            $table->string('agi_email', 65);
            $table->string('agi_foto', 30);
            $table->string('agi_celular', 12);
            $table->string('aga_apenom', 75);
            $table->char('aga_dni',8);
            $table->string('aga_email', 65);
            $table->string('aga_foto', 30);
            $table->string('aga_celular', 12);                        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institucion');
    }
};
