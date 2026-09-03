<?php

namespace Tests\Feature;

use App\Http\Controllers\ChatbotController;
use App\Models\KnowledgeDocument;
use App\Models\User;
use App\Services\PdfSecurityScanner;
use App\Support\PersonalDataRedactor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ComplianceControlsTest extends TestCase
{
    use RefreshDatabase;

    public function test_privacy_notice_and_security_headers_are_public(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Asistente con IA. No envíes datos personales. Verifica datos importantes.')
            ->assertDontSee('Política de Privacidad')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');

        $this->assertStringContainsString("frame-ancestors 'self'", (string) $response->headers->get('Content-Security-Policy'));
        $this->get('/privacidad')->assertNotFound();
    }

    public function test_ai_knowledge_and_logs_use_separate_roles(): void
    {
        $editor = User::factory()->create(['role' => 'editor']);
        $manager = User::factory()->create(['role' => 'ai_manager']);
        $auditor = User::factory()->create(['role' => 'auditor']);
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($editor)->get('/intranet/conocimiento-ia')->assertForbidden();
        $this->actingAs($editor)->get('/intranet/consultas-asistente')->assertForbidden();
        $this->actingAs($manager)->get('/intranet/conocimiento-ia')->assertOk();
        $this->actingAs($manager)->get('/intranet/consultas-asistente')->assertForbidden();
        $this->actingAs($auditor)->get('/intranet/consultas-asistente')->assertOk();
        $this->actingAs($auditor)->get('/intranet/conocimiento-ia')->assertForbidden();
        $this->actingAs($admin)->get('/intranet/conocimiento-ia')->assertOk();
        $this->actingAs($admin)->get('/intranet/consultas-asistente')->assertOk();
    }

    public function test_reset_endpoint_deletes_only_the_requested_conversation(): void
    {
        $conversation = 'conversation-for-delete';
        $targetHash = substr(hash('sha256', $conversation), 0, 32);

        DB::table('chatbot_consultas')->insert([
            [
                'pregunta' => 'consulta objetivo',
                'origen' => 'modelo',
                'sesion' => $targetHash,
                'created_at' => now(),
            ],
            [
                'pregunta' => 'otra consulta',
                'origen' => 'modelo',
                'sesion' => str_repeat('a', 32),
                'created_at' => now(),
            ],
        ]);

        $this->deleteJson('/api/chat/conversation', ['conversacion' => $conversation])->assertNoContent();

        $this->assertDatabaseMissing('chatbot_consultas', ['sesion' => $targetHash]);
        $this->assertDatabaseHas('chatbot_consultas', ['sesion' => str_repeat('a', 32)]);
    }

    public function test_feedback_updates_only_the_latest_answer_in_the_anonymous_conversation(): void
    {
        $conversation = 'conversation-for-feedback';
        $targetHash = substr(hash('sha256', $conversation), 0, 32);

        DB::table('chatbot_consultas')->insert([
            [
                'pregunta' => 'primera respuesta',
                'origen' => 'modelo',
                'sesion' => $targetHash,
                'created_at' => now()->subSecond(),
            ],
            [
                'pregunta' => 'respuesta más reciente',
                'origen' => 'modelo',
                'sesion' => $targetHash,
                'created_at' => now(),
            ],
            [
                'pregunta' => 'respuesta de otra sesión',
                'origen' => 'modelo',
                'sesion' => str_repeat('b', 32),
                'created_at' => now(),
            ],
        ]);

        $this->postJson('/api/chat/feedback', [
            'conversacion' => $conversation,
            'util' => false,
        ])->assertNoContent();

        $this->assertDatabaseHas('chatbot_consultas', [
            'pregunta' => 'respuesta más reciente',
            'feedback' => -1,
        ]);
        $this->assertDatabaseHas('chatbot_consultas', [
            'pregunta' => 'primera respuesta',
            'feedback' => null,
        ]);
        $this->assertDatabaseHas('chatbot_consultas', [
            'pregunta' => 'respuesta de otra sesión',
            'feedback' => null,
        ]);
    }

    public function test_chatbot_exposes_accessible_anonymous_feedback_controls(): void
    {
        $component = file_get_contents(resource_path('views/components/dre-chatbot.blade.php'));
        $javascript = file_get_contents(resource_path('js/app.js'));

        $this->assertStringContainsString('data-feedback-endpoint', $component);
        $this->assertStringContainsString('¿Te sirvió esta respuesta?', $javascript);
        $this->assertStringContainsString("label: 'Sí, fue útil'", $javascript);
        $this->assertStringContainsString("label: 'No fue útil'", $javascript);
    }

    public function test_retention_command_purges_only_expired_records(): void
    {
        DB::table('chatbot_consultas')->insert([
            ['pregunta' => 'antigua', 'origen' => 'modelo', 'created_at' => now()->subDays(91)],
            ['pregunta' => 'reciente', 'origen' => 'modelo', 'created_at' => now()->subDays(10)],
        ]);

        $this->artisan('chatbot:purge-logs')->assertSuccessful();

        $this->assertDatabaseMissing('chatbot_consultas', ['pregunta' => 'antigua']);
        $this->assertDatabaseHas('chatbot_consultas', ['pregunta' => 'reciente']);
    }

    public function test_common_personal_data_is_redacted(): void
    {
        $redacted = PersonalDataRedactor::redact(
            'Mi DNI es 12345678, mi celular 987654321 y correo persona@example.com. contraseña: secreta'
        );

        $this->assertStringNotContainsString('12345678', $redacted);
        $this->assertStringNotContainsString('987654321', $redacted);
        $this->assertStringNotContainsString('persona@example.com', $redacted);
        $this->assertStringNotContainsString('secreta', $redacted);
    }

    public function test_pdf_scanner_rejects_active_content(): void
    {
        $scanner = app(PdfSecurityScanner::class);
        $safe = UploadedFile::fake()->createWithContent(
            'safe.pdf',
            "%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\n%%EOF"
        );
        $scanner->assertSafe($safe);
        $this->assertTrue(true);

        $active = UploadedFile::fake()->createWithContent(
            'active.pdf',
            "%PDF-1.4\n1 0 obj\n<< /OpenAction << /S /JavaScript /JS (app.alert('x')) >> >>\nendobj\n%%EOF"
        );

        $this->expectException(\RuntimeException::class);
        $scanner->assertSafe($active);
    }

    public function test_unpublished_knowledge_is_excluded_from_semantic_retrieval(): void
    {
        config(['services.openai.key' => 'test-key']);
        Http::fake([
            'api.openai.com/v1/embeddings' => Http::response([
                'data' => [['index' => 0, 'embedding' => [1.0, 0.0]]],
            ]),
        ]);

        $document = KnowledgeDocument::create([
            'title' => 'PDF confidencial de prueba',
            'original_filename' => 'confidencial.pdf',
            'pdf_path' => 'ai-knowledge/pdfs/confidencial.pdf',
            'markdown' => 'Contenido reservado de prueba.',
            'status' => 'ready',
            'is_published' => false,
        ]);
        DB::table('ai_knowledge_chunks')->insert([
            'document_id' => $document->id,
            'text' => 'Contenido reservado de prueba.',
            'embedding' => json_encode([1.0, 0.0]),
            'chunk_index' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $findSources = new \ReflectionMethod(ChatbotController::class, 'findSources');
        $sources = $findSources->invoke(
            app(ChatbotController::class),
            'Muéstrame el PDF confidencial de prueba',
            [],
            ''
        );

        $this->assertFalse($sources->contains(fn (array $source) => $source['title'] === $document->title));
    }
}
