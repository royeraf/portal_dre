<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class EvaluateChatbot extends Command
{
    protected $signature = 'chatbot:evaluate {--url= : URL base del portal} {--file= : Archivo JSON de casos}';

    protected $description = 'Ejecuta casos conversacionales repetibles contra el chatbot y reporta regresiones';

    public function handle(): int
    {
        $baseUrl = rtrim((string) ($this->option('url') ?: config('app.url')), '/');
        $file = (string) ($this->option('file') ?: resource_path('chatbot/evals.json'));
        if (! is_file($file)) {
            $this->error('No existe el archivo de evaluación: '.$file);
            return self::FAILURE;
        }

        try {
            $cases = json_decode(file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            $this->error('El archivo de evaluación no es JSON válido: '.$e->getMessage());
            return self::FAILURE;
        }

        $conversation = 'eval-'.Str::lower(Str::random(24));
        $passed = 0;
        $failed = 0;

        try {
            foreach ($cases as $case) {
                $history = [];
                $previous = null;
                $errors = [];

                foreach ($case['turns'] ?? [] as $turn) {
                    try {
                        $response = Http::acceptJson()->timeout(120)->post($baseUrl.'/api/chat', [
                            'message' => $turn['message'],
                            'history' => $history,
                            'conversacion' => $conversation,
                            'page' => ['path' => '/', 'title' => 'Evaluación automática'],
                        ]);
                        $response->throw();
                        $payload = $response->json();
                        $errors = array_merge($errors, $this->validateTurn($payload, $turn['assert'] ?? [], $previous));
                        $history[] = ['role' => 'user', 'content' => $turn['message']];
                        $history[] = ['role' => 'assistant', 'content' => (string) ($payload['answer'] ?? '')];
                        $previous = $payload;
                    } catch (\Throwable $e) {
                        $errors[] = $e->getMessage();
                    }
                }

                if ($errors === []) {
                    $passed++;
                    $this->line('<info>✓</info> '.($case['name'] ?? 'Caso sin nombre'));
                } else {
                    $failed++;
                    $this->line('<error>✗</error> '.($case['name'] ?? 'Caso sin nombre'));
                    foreach ($errors as $error) {
                        $this->line('  - '.$error);
                    }
                }
            }
        } finally {
            // La suite usa el mismo identificador anónimo y borra sus trazas al terminar,
            // para no contaminar las métricas de consultas ciudadanas.
            Http::acceptJson()->timeout(20)->delete($baseUrl.'/api/chat/conversation', [
                'conversacion' => $conversation,
            ]);
        }

        $this->newLine();
        $this->info("Resultado: {$passed} aprobados, {$failed} fallidos.");
        return $failed === 0 ? self::SUCCESS : self::FAILURE;
    }

    private function validateTurn(array $payload, array $assertions, ?array $previous): array
    {
        $answer = Str::lower(Str::ascii((string) ($payload['answer'] ?? '')));
        $links = collect($payload['links'] ?? []);
        $errors = [];

        foreach ($assertions['answer_contains'] ?? [] as $needle) {
            if (! str_contains($answer, Str::lower(Str::ascii($needle)))) {
                $errors[] = "La respuesta no contiene «{$needle}».";
            }
        }
        foreach ($assertions['answer_not_contains'] ?? [] as $needle) {
            if (str_contains($answer, Str::lower(Str::ascii($needle)))) {
                $errors[] = "La respuesta contiene el texto prohibido «{$needle}».";
            }
        }
        if (isset($assertions['links_max']) && $links->count() > (int) $assertions['links_max']) {
            $errors[] = 'Devolvió más enlaces de los permitidos.';
        }
        foreach ($assertions['link_url_contains'] ?? [] as $needle) {
            if (! $links->contains(fn ($link) => str_contains((string) ($link['url'] ?? ''), $needle))) {
                $errors[] = "Ningún enlace contiene «{$needle}».";
            }
        }
        foreach ($assertions['link_urls_not_contain'] ?? [] as $needle) {
            if ($links->contains(fn ($link) => str_contains((string) ($link['url'] ?? ''), $needle))) {
                $errors[] = "Un enlace contiene la ruta prohibida «{$needle}».";
            }
        }
        if (isset($assertions['link_equals_previous_index'])) {
            $index = (int) $assertions['link_equals_previous_index'];
            $expected = data_get($previous, "links.{$index}.url");
            if (! $expected || data_get($payload, 'links.0.url') !== $expected) {
                $errors[] = 'El seguimiento no mantuvo la posición del listado anterior.';
            }
        }
        if (! empty($assertions['dates_desc'])) {
            preg_match_all('/\b\d{2}\/\d{2}\/\d{4}\b/', (string) ($payload['answer'] ?? ''), $matches);
            $timestamps = collect($matches[0] ?? [])->map(fn ($date) => Carbon::createFromFormat('d/m/Y', $date)->timestamp);
            if ($timestamps->count() < 2 || $timestamps->values()->all() !== $timestamps->sortDesc()->values()->all()) {
                $errors[] = 'Las fechas no están en orden cronológico descendente.';
            }
        }

        return $errors;
    }
}
