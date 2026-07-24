<?php

namespace App\Http\Controllers;

use App\Models\Comunicado;
use App\Models\Convocatoria;
use App\Models\Noticia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:1600'],
            'history' => ['sometimes', 'array', 'max:8'],
            'history.*.role' => ['required_with:history', 'in:user,assistant'],
            'history.*.content' => ['required_with:history', 'string', 'max:1000'],
        ]);

        $message = trim($validated['message']);
        $sources = $this->findSources($message);
        $apiKey = config('services.openai.key');

        if (!$apiKey) {
            return response()->json($this->localAnswer($sources));
        }

        $context = $sources->map(fn (array $source) => "- {$source['title']}: {$source['summary']} ({$source['url']})")
            ->implode("\n");
        $history = collect($validated['history'] ?? [])
            ->map(fn (array $item) => strtoupper($item['role']).': '.$item['content'])
            ->implode("\n");

        $instructions = <<<'PROMPT'
Eres el asistente virtual de la Dirección Regional de Educación Huánuco (DRE Huánuco). Responde en español claro, amable y breve. Usa únicamente el contexto institucional entregado y conocimientos administrativos generales seguros. No inventes fechas, requisitos, enlaces, números de resolución ni estados de trámites. Cuando falte evidencia, indícalo y orienta al usuario hacia la sección oficial correspondiente. No reemplazas asesoría legal ni decisiones administrativas.
PROMPT;

        $input = "HISTORIAL:\n{$history}\n\nCONTEXTO DEL PORTAL:\n{$context}\n\nCONSULTA:\n{$message}";

        try {
            $response = Http::timeout(45)
                ->retry(1, 300)
                ->withToken($apiKey)
                ->post('https://api.openai.com/v1/responses', [
                    'model' => config('services.openai.chatbot_model', 'gpt-5-nano'),
                    'instructions' => $instructions,
                    'input' => $input,
                    'max_output_tokens' => 650,
                ]);

            if (!$response->successful()) {
                throw new \RuntimeException('OpenAI request failed: '.$response->status());
            }

            $answer = $response->json('output_text') ?: collect($response->json('output', []))
                ->flatMap(fn (array $item) => $item['content'] ?? [])
                ->firstWhere('type', 'output_text')['text'] ?? null;

            if (!$answer) {
                throw new \RuntimeException('OpenAI returned an empty response.');
            }

            return response()->json([
                'answer' => trim($answer),
                'links' => $sources->take(3)->map(fn (array $source) => [
                    'title' => $source['title'],
                    'url' => $source['url'],
                ])->values(),
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json($this->localAnswer($sources));
        }
    }

    private function findSources(string $message)
    {
        $tokens = collect(preg_split('/[^\pL\pN]+/u', Str::lower($message)))
            ->filter(fn (?string $token) => mb_strlen($token ?? '') >= 4)
            ->unique()
            ->take(6)
            ->values();

        if ($tokens->isEmpty()) {
            return collect();
        }

        $applySearch = function ($query, array $columns) use ($tokens) {
            return $query->where(function ($nested) use ($tokens, $columns) {
                foreach ($tokens as $token) {
                    foreach ($columns as $column) {
                        $nested->orWhere($column, 'like', "%{$token}%");
                    }
                }
            });
        };

        $noticias = $applySearch(Noticia::query(), ['titulo', 'descripcioncorta'])
            ->latest('fechapubli')->limit(3)->get()
            ->map(fn ($item) => [
                'title' => $item->titulo,
                'summary' => Str::limit(strip_tags($item->descripcioncorta), 240),
                'url' => route('noticia', $item),
            ]);

        $comunicados = $applySearch(Comunicado::query(), ['titulo'])
            ->latest('created_at')->limit(2)->get()
            ->map(fn ($item) => [
                'title' => $item->titulo,
                'summary' => 'Comunicado institucional publicado por la DRE Huánuco.',
                'url' => $item->url ?: route('comunicadosall'),
            ]);

        $convocatorias = $applySearch(Convocatoria::query(), ['titulo', 'descripcion', 'tipo'])
            ->latest('fecha_inicio')->limit(2)->get()
            ->map(fn ($item) => [
                'title' => $item->titulo,
                'summary' => Str::limit(strip_tags($item->descripcion), 240),
                'url' => route('verconvocatoria', $item),
            ]);

        return $noticias->concat($comunicados)->concat($convocatorias)->unique('url')->values();
    }

    private function localAnswer($sources): array
    {
        if ($sources->isNotEmpty()) {
            return [
                'answer' => 'Encontré información relacionada en el portal institucional. Revisa las fuentes que aparecen debajo; allí encontrarás el contenido oficial y actualizado.',
                'links' => $sources->take(3)->map(fn (array $source) => [
                    'title' => $source['title'],
                    'url' => $source['url'],
                ])->values(),
            ];
        }

        return [
            'answer' => 'Todavía no encuentro una publicación que responda exactamente a tu consulta. Puedes reformularla indicando el trámite, convocatoria, documento o área que buscas.',
            'links' => [
                ['title' => 'Noticias institucionales', 'url' => route('allnoticias')],
                ['title' => 'Convocatorias', 'url' => route('convocatoriaweb')],
                ['title' => 'Documentos de gestión', 'url' => route('documentosdegestionweb')],
            ],
        ];
    }
}
