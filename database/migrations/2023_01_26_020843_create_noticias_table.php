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
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 55);
            $table->string('descripcioncorta', 70);
            $table->text('contenido');
            $table->string('img1');
            $table->string('img2')->nullable();
            $table->string('img3')->nullable();
            $table->unsignedTinyInteger('activo')->default(1);
            $table->date('fechapubli');
            $table->foreignId('iduser')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('noticias');
    }
};
