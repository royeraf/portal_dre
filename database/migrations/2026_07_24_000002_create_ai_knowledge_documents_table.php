<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ai_knowledge_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('original_filename', 255);
            $table->string('pdf_path', 500);
            $table->longText('markdown')->nullable();
            $table->unsignedInteger('page_count')->nullable();
            $table->string('status', 20)->default('processing');
            $table->text('error_message')->nullable();
            $table->boolean('is_published')->default(true);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['status', 'is_published']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ai_knowledge_documents');
    }
};
