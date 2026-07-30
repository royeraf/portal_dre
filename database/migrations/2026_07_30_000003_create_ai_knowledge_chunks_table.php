<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ai_knowledge_chunks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('ai_knowledge_documents')->cascadeOnDelete();
            $table->string('heading')->nullable();
            $table->text('text');
            $table->longText('embedding')->nullable(); // JSON array
            $table->integer('chunk_index')->default(0);
            $table->timestamps();
            $table->index(['document_id','chunk_index']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ai_knowledge_chunks');
    }
};
