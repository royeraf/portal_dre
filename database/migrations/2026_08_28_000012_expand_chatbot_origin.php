<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chatbot_consultas', function (Blueprint $table) {
            $table->string('origen', 40)->default('modelo')->change();
        });
    }

    public function down(): void
    {
        Schema::table('chatbot_consultas', function (Blueprint $table) {
            $table->string('origen', 20)->default('modelo')->change();
        });
    }
};
