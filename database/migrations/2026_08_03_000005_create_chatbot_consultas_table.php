<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sin este registro no hay forma de saber qué se le pregunta al asistente ni qué
     * contesta: los errores de contenido no lanzan excepciones, así que no aparecen
     * en el log de Laravel y solo se descubren revisando a mano.
     *
     * No se guarda la IP. Las consultas de ciudadanos pueden traer datos personales,
     * así que se conserva lo mínimo para poder auditar y se identifica la sesión con
     * un hash, no con el identificador real.
     */
    public function up()
    {
        Schema::create('chatbot_consultas', function (Blueprint $table) {
            $table->id();
            $table->text('pregunta');
            $table->longText('respuesta')->nullable();
            $table->json('fuentes')->nullable();
            $table->string('origen', 20)->default('modelo');
            $table->string('modelo', 60)->nullable();
            $table->unsignedInteger('tokens_entrada')->nullable();
            $table->unsignedInteger('tokens_salida')->nullable();
            $table->unsignedInteger('ms')->nullable();
            $table->text('error')->nullable();
            $table->string('sesion', 64)->nullable();
            $table->timestamp('created_at')->nullable();

            $table->index('created_at');
            $table->index(['origen', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_consultas');
    }
};
