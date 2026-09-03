<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('menu') && !Schema::hasTable('menus')) {
            Schema::rename('menu', 'menus');
        }

        if (Schema::hasTable('comunicado') && !Schema::hasTable('comunicados')) {
            Schema::rename('comunicado', 'comunicados');
        }

        if (!Schema::hasTable('video_embevido')) {
            Schema::create('video_embevido', function (Blueprint $table) {
                $table->id();
                $table->string('titulo', 100);
                $table->text('contenido');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('imagen_popup')) {
            Schema::create('imagen_popup', function (Blueprint $table) {
                $table->id();
                $table->string('imagen', 45);
                $table->unsignedBigInteger('idpopup');
                $table->text('enlace')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('imagen_popup');
        Schema::dropIfExists('video_embevido');

        if (Schema::hasTable('comunicados') && !Schema::hasTable('comunicado')) {
            Schema::rename('comunicados', 'comunicado');
        }

        if (Schema::hasTable('menus') && !Schema::hasTable('menu')) {
            Schema::rename('menus', 'menu');
        }
    }
};
