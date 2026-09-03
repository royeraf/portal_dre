<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chatbot_consultas', function (Blueprint $table) {
            // 1 = útil, -1 = no útil. No se guarda texto adicional ni identidad.
            $table->tinyInteger('feedback')->nullable()->after('estado')->index();
            $table->timestamp('feedback_at')->nullable()->after('feedback');
        });
    }

    public function down(): void
    {
        Schema::table('chatbot_consultas', function (Blueprint $table) {
            $table->dropIndex(['feedback']);
            $table->dropColumn(['feedback', 'feedback_at']);
        });
    }
};
