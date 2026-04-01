<?php
// filepath: c:\Users\liliana\Desktop\Sistemas DRE\drehco\database\migrations\2025_10_28_165604_create_siagie_reports_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla: Reportes SIAGIE disponibles
        Schema::create('siagie_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_id')->unique()->comment('ID en sistema SIAGIE');
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->nullable()->comment('Matrícula, Evaluación, Certificados, etc');
            $table->timestamp('published_at');
            $table->integer('charts_count')->default(0);
            $table->string('api_url');
            $table->boolean('is_available')->default(true);
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
            
            $table->index(['slug', 'is_available']);
            $table->index(['category', 'is_available']);
            $table->index('published_at');
        });

        // Tabla: Gráficos SIAGIE seleccionados
        Schema::create('siagie_charts', function (Blueprint $table) {
            $table->id();
            $table->string('report_slug');
            $table->unsignedBigInteger('external_chart_id')->comment('ID del gráfico en sistema SIAGIE');
            $table->string('chart_title');
            $table->json('chart_data')->comment('Datos del gráfico');
            $table->json('chart_config')->comment('Configuración del gráfico');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_global')->default(false)->comment('Si es gráfico global del reporte');
            $table->text('custom_notes')->nullable();
            $table->timestamps();
            
            $table->foreign('report_slug')
                  ->references('slug')
                  ->on('siagie_reports')
                  ->onDelete('cascade');
            
            $table->unique(['report_slug', 'external_chart_id']);
            $table->index(['report_slug', 'is_active', 'order']);
            $table->index('is_global');
        });

        // Tabla: Enlaces SIAGIE (ya existente, mantener)
        if (!Schema::hasTable('siagie_enlaces')) {
            Schema::create('siagie_enlaces', function (Blueprint $table) {
                $table->id();
                $table->string('titulo');
                $table->text('descripcion')->nullable();
                $table->string('url');
                $table->string('icono')->nullable();
                $table->string('tipo')->default('enlace');
                $table->string('imagen')->nullable();
                $table->boolean('activo')->default(1);
                $table->integer('orden')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('siagie_charts');
        Schema::dropIfExists('siagie_reports');
    }
};