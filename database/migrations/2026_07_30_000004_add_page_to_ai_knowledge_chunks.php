<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ai_knowledge_chunks', function (Blueprint $table) {
            // Guardar la página junto al fragmento evita que el modelo tenga que deducirla
            // de los marcadores sueltos en el texto, cosa que hacía mal al unir fragmentos.
            $table->unsignedInteger('page')->nullable()->after('heading');
        });
    }

    public function down()
    {
        Schema::table('ai_knowledge_chunks', function (Blueprint $table) {
            $table->dropColumn('page');
        });
    }
};
