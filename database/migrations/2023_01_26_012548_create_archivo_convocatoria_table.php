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
        Schema::create('archivo_convocatoria', function (Blueprint $table) {
            $table->id();
            $table->string('nom_archivo');
            $table->string('url_archivo');
            $table->string('etapa');
            $table->foreignId('id_convocatoria')->nullable()->constrained('convocatoria')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('archivo_convocatoria');
    }
};
