<?php

namespace Tests\Feature;

use App\Http\Controllers\ChatbotController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatbotConversationRegressionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.openai.key' => null, 'services.openai.limite_diario_tokens' => 0]);
        Http::preventStrayRequests();
    }

    private function news(string $title, string $date, string $content): int
    {
        return DB::table('noticias')->insertGetId([
            'titulo' => $title, 'descripcioncorta' => $content, 'contenido' => '<p>'.$content.'</p>',
            'img1' => 'test.jpg', 'activo' => 1, 'fechapubli' => $date,
        ]);
    }

    public function test_nonexistent_code_never_returns_a_different_call(): void
    {
        DB::table('convocatoria')->insert([
            'titulo' => 'CONVOCATORIA CAS 0011-2026', 'tipo' => 'CAS', 'descripcion' => 'Personal administrativo',
            'fecha_inicio' => '2026-07-01', 'fecha_termino' => '2026-07-30',
        ]);
        config(['services.openai.key' => 'test-key']);
        $this->postJson('/api/chat', ['message' => '¿Cuándo vence la convocatoria CAS 999-2099?'])
            ->assertOk()->assertJsonMissing(['title' => 'CONVOCATORIA CAS 0011-2026'])
            ->assertJsonPath('answer', fn ($answer) => str_contains($answer, 'No encontré una convocatoria'));
        Http::assertNothingSent();
    }

    public function test_code_filter_accepts_zero_padding_but_not_partial_numbers(): void
    {
        $method = new \ReflectionMethod(ChatbotController::class, 'filtrarPorIdentificadorExacto');
        $sources = collect([
            ['title' => 'CAS 0011-2026'], ['title' => 'CAS 111-2026'], ['title' => 'CAS 11-2025'],
        ]);
        $result = $method->invoke(app(ChatbotController::class), $sources, 'CAS 11 / 2026');
        $this->assertSame([['title' => 'CAS 0011-2026']], $result->all());
        $this->assertCount(3, $method->invoke(app(ChatbotController::class), $sources, 'Noticias del 27/08/2026'));
    }

    public function test_latest_news_are_in_date_order_and_followup_uses_displayed_second(): void
    {
        $first = $this->news('Clubes de ciencia', '2026-08-10', 'Se realizaron actividades científicas.');
        $third = $this->news('Noticias educativas de UGEL AMBO', '2026-07-01', 'Se realizó una jornada en Ambo.');
        $second = $this->news('Jornada de integridad pública', '2026-07-14', 'Se capacitó sobre integridad y transparencia.');
        $listing = $this->postJson('/api/chat', ['message' => 'Últimas noticias educativas'])->assertOk();
        $this->assertSame([
            url('/noticia/'.$first), url('/noticia/'.$second), url('/noticia/'.$third),
        ], array_column($listing->json('links'), 'url'));
        $history = [
            ['role' => 'user', 'content' => 'Últimas noticias educativas'],
            ['role' => 'assistant', 'content' => $listing->json('answer')],
        ];
        foreach (['Resúmeme la segunda noticia', 'Explícame la segunda', 'Abre la segunda'] as $question) {
            $this->postJson('/api/chat', ['message' => $question, 'history' => $history])
                ->assertOk()->assertJsonPath('links.0.url', url('/noticia/'.$second))
                ->assertJsonPath('links.0.title', 'Jornada de integridad pública');
        }
        $this->postJson('/api/chat', ['message' => 'Resume la tercera noticia', 'history' => $history])
            ->assertOk()->assertJsonPath('links.0.url', url('/noticia/'.$third));
    }

    public function test_missing_ordinal_does_not_guess_a_publication(): void
    {
        $this->news('Noticia cualquiera', '2026-08-10', 'Contenido de ejemplo.');
        $this->postJson('/api/chat', ['message' => 'Resume la segunda noticia'])
            ->assertOk()->assertJsonPath('links', [])
            ->assertJsonPath('answer', fn ($answer) => str_contains($answer, 'No puedo identificar'));
    }

    public function test_fut_uses_the_current_public_homepage_link(): void
    {
        DB::table('mainright')->insert([
            ['nombre' => 'FUT', 'url' => 'javascript:alert(1)', 'imagen' => 'fut.png'],
            ['nombre' => 'Formato Único de Trámite (FUT)', 'url' => 'https://drive.google.com/file/d/test/view', 'imagen' => 'fut.png'],
        ]);
        $this->postJson('/api/chat', ['message' => 'Necesito descargar el FUT'])
            ->assertOk()->assertJsonPath('links.0.url', 'https://drive.google.com/file/d/test/view');
        DB::table('mainright')->where('nombre', 'Formato Único de Trámite (FUT)')->update(['url' => url('/archivos/nuevo-fut.pdf')]);
        $this->postJson('/api/chat', ['message' => 'FUT'])
            ->assertOk()->assertJsonPath('links.0.url', url('/archivos/nuevo-fut.pdf'));
    }

    public function test_long_assistant_history_is_accepted_but_bounded(): void
    {
        $this->postJson('/api/chat', [
            'message' => 'gracias', 'history' => [['role' => 'assistant', 'content' => str_repeat('a', 12000)]],
        ])->assertOk();
        $this->postJson('/api/chat', [
            'message' => 'gracias', 'history' => [['role' => 'assistant', 'content' => str_repeat('a', 12001)]],
        ])->assertUnprocessable()->assertJsonValidationErrors('history.0.content');
    }

    public function test_deadline_without_context_requests_the_call_name(): void
    {
        foreach (['¿Cuándo vence?', 'hasta cuando', '¿Cuándo cierra?'] as $question) {
            $this->postJson('/api/chat', ['message' => $question, 'page' => ['path' => '/']])
                ->assertOk()->assertJsonPath('links', [])
                ->assertJsonPath('answer', fn ($answer) => str_contains($answer, '¿De qué convocatoria'));
        }
    }
}
