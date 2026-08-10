<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('chatbot_consultas', function (Blueprint $table) {
            $table->string('estado', 20)->nullable()->after('origen')->index();
        });
    }

    public function down()
    {
        Schema::table('chatbot_consultas', function (Blueprint $table) {
            $table->dropIndex(['estado']);
            $table->dropColumn('estado');
        });
    }
};
