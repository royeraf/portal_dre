<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();
            $table->string('imagen_director')->nullable();
            $table->string('imagen_organigrama')->nullable();
            $table->unsignedBigInteger('idpagina')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->index('idpagina');
        });
    }

    public function down()
    {
        Schema::dropIfExists('direcciones');
    }
};