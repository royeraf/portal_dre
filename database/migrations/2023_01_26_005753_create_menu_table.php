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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('nom_menu', 35)->unique();
            $table->string('link_menu', 35);
            $table->unsignedTinyInteger('activo_menu')->default(1);
            $table->foreignId('idpagina')->nullable()->constrained('pagina')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('categoriamenu');
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
        Schema::dropIfExists('menu');
    }
};
