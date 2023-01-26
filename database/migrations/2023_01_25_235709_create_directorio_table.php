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
        Schema::create('directorio', function (Blueprint $table) {
            $table->id();
            $table->string('apenom');
            $table->string('dni', 8)->unique();
            $table->string('area', 35);
            $table->string('cargo', 35);
            $table->string('email', 45);
            $table->string('celular', 11);
            $table->string('foto', 45);
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
        Schema::dropIfExists('directorio');
    }
};
