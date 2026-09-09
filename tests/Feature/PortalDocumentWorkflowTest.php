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

    public function test_public_convocatoria_cleans_description_markup_and_shows_download_link(): void
    {
        $convocatoriaId = DB::table('convocatoria')->insertGetId([
            'titulo' => 'Convocatoria pública',
            'tipo' => 'DIRECTIVO',
            'descripcion' => '<p>Descripción oficial</p><script>alert("xss")</script>',
            'fecha_inicio' => now()->toDateString(),
            'fecha_termino' => now()->addDay()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('archivo_convocatoria')->insert([
            'nom_archivo' => 'Cronograma',
            'url_archivo' => '/archivos/cronograma.pdf',
            'etapa' => 'INSCRIPCION',
            'id_convocatoria' => $convocatoriaId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get(route('convocatoriaweb', ['convocatoria' => $convocatoriaId]));

        $response->assertOk();
        $response->assertSee('Descripci\\u00f3n oficial', false);
        $response->assertDontSee('alert("xss")');
        $response->assertSee('data-convocatoria-id="'.$convocatoriaId.'"', false);
        $response->assertSee('cronograma.pdf', false);
        $response->assertSee('Documentos adjuntos');
    }

    public function test_old_convocatoria_url_redirects_to_the_existing_listing_modal(): void
    {
        $convocatoriaId = DB::table('convocatoria')->insertGetId([
            'titulo' => 'Convocatoria enlazada',
            'tipo' => 'CAS',
            'descripcion' => 'Detalle',
            'fecha_inicio' => now()->toDateString(),
            'fecha_termino' => now()->addDay()->toDateString(),
            'es_activo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->get(route('verconvocatoria', $convocatoriaId))
            ->assertRedirect(route('convocatoriaweb', ['convocatoria' => $convocatoriaId]));
    }

    public function test_requested_convocatoria_is_loaded_even_when_it_is_on_another_page(): void
    {
        $convocatoriaId = DB::table('convocatoria')->insertGetId([
            'titulo' => 'Convocatoria antigua enlazada',
            'tipo' => 'CAS',
            'descripcion' => 'Debe abrirse desde el chatbot',
            'fecha_inicio' => now()->subMonth()->toDateString(),
            'fecha_termino' => now()->addDay()->toDateString(),
            'es_activo' => 1,
            'created_at' => now()->subMonth(),
            'updated_at' => now()->subMonth(),
        ]);

        foreach (range(1, 13) as $index) {
            DB::table('convocatoria')->insert([
                'titulo' => 'Convocatoria reciente '.$index,
                'tipo' => 'CAS',
                'descripcion' => 'Detalle reciente',
                'fecha_inicio' => now()->toDateString(),
                'fecha_termino' => now()->addDays(2)->toDateString(),
                'es_activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->get(route('convocatoriaweb', ['convocatoria' => $convocatoriaId]))
            ->assertOk()
            ->assertSeeText('Convocatoria antigua enlazada')
            ->assertSee('data-convocatoria-id="'.$convocatoriaId.'"', false)
            ->assertSee('abrirConvocatoriaInicial()', false);
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
