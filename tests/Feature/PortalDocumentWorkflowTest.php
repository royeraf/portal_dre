<?php

namespace Tests\Feature;

use App\Models\Convocatoria;
use App\Models\KnowledgeDocument;
use App\Models\User;
use App\Services\KnowledgeIndexer;
use App\Services\PdfMarkdownExtractor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class PortalDocumentWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_convocatoria_accepts_a_safe_pdf_without_requiring_an_external_url(): void
    {
        Storage::fake('portal_documents');
        $user = User::factory()->create();
        $convocatoriaId = DB::table('convocatoria')->insertGetId([
            'titulo' => 'Convocatoria de prueba',
            'tipo' => 'CAS',
            'descripcion' => 'Proceso de prueba',
            'fecha_inicio' => now()->toDateString(),
            'fecha_termino' => now()->addDay()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $convocatoria = Convocatoria::query()->findOrFail($convocatoriaId);
        $pdf = UploadedFile::fake()->createWithContent(
            'bases.pdf',
            "%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\n%%EOF"
        );

        $response = $this->actingAs($user)->post(route('archivo.convocatoria.store', $convocatoria), [
            'nom_archivo' => 'Bases del proceso',
            'etapa' => 'INSCRIPCION',
            'file' => $pdf,
        ]);

        $response->assertRedirect(route('convocatoria.show', $convocatoria));
        $record = DB::table('archivo_convocatoria')->where('id_convocatoria', $convocatoria->id)->first();
        $this->assertNotNull($record);
        $this->assertMatchesRegularExpression('#^/archivos/[0-9a-f-]+\.pdf$#', $record->url_archivo);
        Storage::disk('portal_documents')->assertExists(basename($record->url_archivo));
    }

    public function test_portal_sync_imports_only_referenced_pdfs_as_drafts_and_does_not_duplicate_them(): void
    {
        Storage::fake('local');
        $directory = storage_path('framework/testing/portal-sync-'.Str::uuid());
        File::ensureDirectoryExists($directory);
        file_put_contents(
            $directory.DIRECTORY_SEPARATOR.'portal-sync.pdf',
            "%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\n%%EOF"
        );
        file_put_contents(
            $directory.DIRECTORY_SEPARATOR.'orphan.pdf',
            "%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\n%%EOF"
        );

        $convocatoriaId = DB::table('convocatoria')->insertGetId([
            'titulo' => 'Convocatoria de sincronización',
            'tipo' => 'CAS',
            'descripcion' => 'Prueba',
            'fecha_inicio' => now()->toDateString(),
            'fecha_termino' => now()->addDay()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('archivo_convocatoria')->insert([
            'nom_archivo' => 'PDF publicado',
            'url_archivo' => '/archivos/portal-sync.pdf',
            'etapa' => 'INSCRIPCION',
            'id_convocatoria' => $convocatoriaId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->mock(PdfMarkdownExtractor::class)
            ->shouldReceive('extract')
            ->once()
            ->andReturn(['markdown' => "# Documento\n\nContenido verificable de prueba.", 'page_count' => 1]);
        $this->mock(KnowledgeIndexer::class)
            ->shouldReceive('index')
            ->once()
            ->andReturn(1);

        try {
            $this->artisan('knowledge:import-directory', [
                'path' => $directory,
                '--index' => true,
                '--only-referenced' => true,
            ])->assertSuccessful();

            $this->artisan('knowledge:import-directory', [
                'path' => $directory,
                '--index' => true,
                '--only-referenced' => true,
            ])->assertSuccessful();
        } finally {
            File::deleteDirectory($directory);
        }

        $this->assertSame(1, KnowledgeDocument::query()->count());
        $document = KnowledgeDocument::query()->firstOrFail();
        $this->assertSame('portal-sync.pdf', $document->original_filename);
        $this->assertSame('ready', $document->status);
        $this->assertFalse($document->is_published);
    }

    public function test_convocatoria_deletion_is_not_available_through_a_get_request(): void
    {
        $user = User::factory()->create();
        $convocatoriaId = DB::table('convocatoria')->insertGetId([
            'titulo' => 'Convocatoria protegida',
            'tipo' => 'CAS',
            'descripcion' => 'Prueba',
            'fecha_inicio' => now()->toDateString(),
            'fecha_termino' => now()->addDay()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $convocatoria = Convocatoria::query()->findOrFail($convocatoriaId);

        $this->actingAs($user)->get(route('convocatoria.destroy', $convocatoria))->assertStatus(405);
        $this->assertDatabaseHas('convocatoria', ['id' => $convocatoriaId]);

        $this->actingAs($user)->delete(route('convocatoria.destroy', $convocatoria))->assertRedirect(route('convocatoria'));
        $this->assertDatabaseMissing('convocatoria', ['id' => $convocatoriaId]);
    }
}
