<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('areas_menu', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug');
            $table->text('descripcion')->nullable();
            $table->string('imagen_funcionario')->nullable();
            $table->string('imagen_organigrama')->nullable();
            $table->string('link_descarga_1')->nullable();
            $table->string('texto_descarga_1')->nullable();
            $table->string('link_descarga_2')->nullable();
            $table->string('texto_descarga_2')->nullable();
            $table->foreignId('direccion_id')->constrained('direcciones')->onDelete('cascade');
            $table->integer('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('areas_menu');
    }
};