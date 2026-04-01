<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('eventos_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained('areas_menu')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion');
            
            // Enlaces con sus descripciones (5 enlaces)
            $table->string('enlace_1')->nullable();
            $table->string('descripcion_enlace_1')->nullable();
            $table->string('enlace_2')->nullable();
            $table->string('descripcion_enlace_2')->nullable();
            $table->string('enlace_3')->nullable();
            $table->string('descripcion_enlace_3')->nullable();
            $table->string('enlace_4')->nullable();
            $table->string('descripcion_enlace_4')->nullable();
            $table->string('enlace_5')->nullable();
            $table->string('descripcion_enlace_5')->nullable();
            
            // Enlace externo principal
            $table->string('enlace_externo')->nullable();
            
            // Campos de control
            $table->boolean('activo')->default(true);
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('eventos_areas');
    }
};