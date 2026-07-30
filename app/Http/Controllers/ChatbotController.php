<?php

namespace App\Http\Controllers;

use App\Models\Comunicado;
use App\Models\Convocatoria;
use App\Models\KnowledgeDocument;
use App\Models\Noticia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    /**
     * Sin esta lista, consultas como "dime algo que tiene" enganchan cualquier documento
     * por palabras como "tiene" y el asistente afirma haber encontrado información.
     * Solo hacen falta los términos de 4 letras o más, el resto ya se descarta por longitud.
     */
    private const PALABRAS_VACIAS = [
        'algo', 'algun', 'alguna', 'algunas', 'alguno', 'algunos', 'ante', 'antes', 'aqui',
        'buenas', 'buenos', 'cada', 'como', 'con', 'contra', 'cual', 'cuales', 'cualquier',
        'dias', 'noches', 'saludos', 'tardes',
        'cuando', 'cuanto', 'cuanta', 'cuantas', 'cuantos', 'dame', 'debe', 'deben', 'decir',
        'dejar', 'desde', 'dice', 'dicen', 'dime', 'donde', 'donde', 'ella', 'ellas', 'ellos',
        'entonces', 'entre', 'eran', 'eres', 'esas', 'ese', 'eso', 'esos', 'esta', 'estan',
        'estar', 'estas', 'este', 'esto', 'estos', 'estoy', 'favor', 'fue', 'fueron', 'gracias',
        'hace', 'hacen', 'hacer', 'hacia', 'hasta', 'haya', 'hola', 'incluso', 'luego', 'mas',
        'mientras', 'mucha', 'muchas', 'mucho', 'muchos', 'nada', 'necesito', 'nosotros',
        'nuestra', 'nuestro', 'otra', 'otras', 'otro', 'otros', 'para', 'pero', 'poco',
        'podria', 'porque', 'pueda', 'puede', 'pueden', 'puedo', 'pues', 'quien', 'quienes',
        'quiere', 'quiero', 'sabe', 'saber', 'segun', 'sean', 'ser', 'sido', 'siempre', 'sin',
        'sobre', 'solo', 'son', 'soy', 'sus', 'tambien', 'tanto', 'tener', 'tengo', 'tiene',
        'tienen', 'tienes', 'toda', 'todas', 'todo', 'todos', 'tuvo', 'una', 'unas', 'uno',
        'unos', 'usted', 'ustedes', 'varias', 'varios', 'vez',
    ];

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

        // Sin contexto que citar el modelo respondería de memoria, y aquí no se puede
        // improvisar sobre trámites ni plazos institucionales.
        if (!$apiKey || $sources->isEmpty()) {
            return response()->json($this->localAnswer($sources));
        }

        $context = $sources->map(fn (array $source) => "- {$source['title']}: ".($source['context'] ?? $source['summary'])." ({$source['url']})")
            ->implode("\n");
        $history = collect($validated['history'] ?? [])
            ->map(fn (array $item) => strtoupper($item['role']).': '.$item['content'])
            ->implode("\n");

        $instructions = <<<'PROMPT'
Eres el asistente virtual de la Dirección Regional de Educación Huánuco (DRE Huánuco). Responde en español claro y amable.

Regla principal: responde solo con lo que aparezca en el CONTEXTO DEL PORTAL. Si el contexto no cubre la consulta, dilo en una frase y orienta a la sección oficial correspondiente; no completes el vacío con recomendaciones generales, buenas prácticas ni ejemplos propios. No inventes fechas, requisitos, enlaces, números de resolución ni estados de trámites. No reemplazas asesoría legal ni decisiones administrativas.

Atribución: el contexto puede provenir de documentos de alcance nacional o regional. Di lo que plantea el documento, sin presentarlo como acción, competencia o compromiso de la DRE Huánuco salvo que el propio texto lo indique.

Formato: máximo 70 palabras. Una frase inicial de contexto y hasta 3 viñetas breves que empiecen con "- ". Sin preámbulos como "Respuesta breve:" ni encabezados. No cierres ofreciendo más ayuda ni preguntando si el usuario desea algo más; los enlaces a las fuentes se muestran aparte, así que no los repitas en el texto.

Escribe en texto plano: el chat no interpreta Markdown, así que no uses asteriscos para negrita, ni almohadillas, ni tablas, ni enlaces con corchetes. Si el contexto indica el número de página de un dato, menciónalo.
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
                    // El razonamiento consume del mismo presupuesto que la respuesta visible:
                    // con el nivel por defecto se agotaban los tokens antes de redactar nada.
                    'reasoning' => ['effort' => 'low'],
                    'max_output_tokens' => 1200,
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
        $apiKey = config('services.openai.key');
        $tokens = collect(preg_split('/[^\pL\pN]+/u', Str::lower($message)))
            ->filter(fn (?string $token) => mb_strlen($token ?? '') >= 4)
            ->reject(fn (string $token) => in_array(Str::ascii($token), self::PALABRAS_VACIAS, true))
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

        // If we have embeddings indexed, prefer semantic search using OpenAI embeddings.
        $knowledge = collect();
        if ($apiKey && \Schema::hasTable('ai_knowledge_chunks')) {
            try {
                $queryEmbedding = $this->queryEmbedding($message, $apiKey);
                if ($queryEmbedding) {
                    $chunks = \DB::table('ai_knowledge_chunks')->whereNotNull('embedding')->get();

                    // La norma de la consulta no cambia entre fragmentos: calcularla dentro
                    // del bucle repetía el mismo trabajo una vez por chunk.
                    $qnorm = 0.0;
                    foreach ($queryEmbedding as $v) { $qnorm += $v * $v; }
                    $qnorm = sqrt($qnorm);

                    $scores = [];
                    foreach ($chunks as $chunk) {
                        $emb = json_decode($chunk->embedding, true);
                        if (!is_array($emb)) continue;
                        $dot = 0.0; $knorm=0.0;
                        foreach ($emb as $i => $v) {
                            $dot += ($queryEmbedding[$i] ?? 0) * $v;
                            $knorm += $v * $v;
                        }
                        if ($qnorm==0.0 || $knorm==0.0) continue;
                        $score = $dot / ($qnorm * sqrt($knorm));
                        $scores[] = ['score'=>$score,'chunk'=>$chunk];
                    }
                    usort($scores, fn($a,$b)=> $b['score']<=> $a['score']);
                    $selected = array_slice($scores,0,6);

                    // Los fragmentos elegidos suelen venir del mismo PDF y comparten URL, así que
                    // hay que unirlos en una sola fuente: si se empujan por separado, el
                    // unique('url') del final se queda con uno solo y descarta el resto.
                    $porDocumento = [];
                    foreach ($selected as $s) {
                        $porDocumento[$s['chunk']->document_id][] = $s['chunk'];
                    }

                    foreach ($porDocumento as $documentId => $trozos) {
                        $doc = \DB::table('ai_knowledge_documents')->where('id',$documentId)->first();
                        if (!$doc) continue;

                        // Se devuelven en el orden del documento para que el texto se lea coherente.
                        usort($trozos, fn($a,$b) => $a->chunk_index <=> $b->chunk_index);
                        $texto = collect($trozos)
                            ->map(function ($trozo) {
                                $encabezado = trim((string) ($trozo->heading ?? ''));

                                return ($encabezado !== '' ? "[{$encabezado}] " : '').trim($trozo->text);
                            })
                            ->implode("\n\n[...]\n\n");

                        $knowledge->push([
                            'title' => $doc->title,
                            'summary' => Str::limit(preg_replace('/\s+/',' ', $texto),240),
                            'context' => Str::limit($texto,8000),
                            'url' => route('knowledge.download', ['knowledgeDocument' => $doc->id]),
                        ]);
                    }
                }
            } catch (\Throwable $e) {
                report($e);
                // fall back to keyword search below
            }
        }

        if ($knowledge->isEmpty()) {
            $knowledge = $applySearch(
                KnowledgeDocument::query()->where('status', 'ready')->where('is_published', true),
                ['title', 'markdown']
            )->latest()->limit(2)->get()
                ->map(fn ($item) => [
                    'title' => $item->title,
                    'summary' => Str::limit(preg_replace('/\s+/', ' ', Str::limit($item->markdown, 400)), 240),
                    'context' => $this->relevantPassages($item->markdown, $tokens),
                    'url' => route('knowledge.download', $item),
                ]);
        }

        return $knowledge->concat($noticias)->concat($comunicados)->concat($convocatorias)->unique('url')->values();
    }

    /**
     * Un PDF institucional puede tener cientos de miles de caracteres, así que en vez de
     * mandar el inicio del documento se arma el contexto con los fragmentos que realmente
     * mencionan los términos de la consulta.
     */
    private function relevantPassages(string $markdown, $tokens, int $maxChars = 8000): string
    {
        if (mb_strlen($markdown) <= $maxChars) {
            return $markdown;
        }

        $chunks = [];
        $current = '';
        $heading = '';

        foreach (preg_split('/\n{2,}/', $markdown) as $block) {
            $block = trim($block);

            if ($block === '') {
                continue;
            }

            if (Str::startsWith($block, '#')) {
                $heading = trim(ltrim($block, '# '));
            }

            $current .= ($current === '' ? '' : "\n\n").$block;

            if (mb_strlen($current) >= 900) {
                $chunks[] = ['heading' => $heading, 'text' => $current];
                $current = '';
            }
        }

        if (trim($current) !== '') {
            $chunks[] = ['heading' => $heading, 'text' => $current];
        }

        $needles = collect($tokens)
            ->map(fn (string $token) => Str::lower(Str::ascii($token)))
            ->filter()
            ->all();

        $scores = [];

        foreach ($chunks as $index => $chunk) {
            $haystack = Str::lower(Str::ascii($chunk['heading'].' '.$chunk['text']));
            $hits = 0;
            $covered = 0;

            foreach ($needles as $needle) {
                $found = substr_count($haystack, $needle);

                if ($found > 0) {
                    $hits += $found;
                    $covered++;
                }
            }

            if ($hits > 0) {
                // Un fragmento que toca varios términos de la consulta vale más que otro
                // que repite muchas veces uno solo.
                $score = $hits + ($covered * 5);

                // Los índices con puntos de relleno nombran todos los temas sin desarrollar
                // ninguno, así que puntúan alto sin aportar respuesta.
                if (preg_match_all('/\.{4,}/', $chunk['text']) >= 3) {
                    $score = (int) ($score / 10);
                }

                if ($score > 0) {
                    $scores[$index] = $score;
                }
            }
        }

        if ($scores === []) {
            return Str::limit($markdown, $maxChars);
        }

        arsort($scores);
        $selected = [];
        $used = 0;

        foreach (array_keys($scores) as $index) {
            $piece = $chunks[$index]['heading'] !== ''
                ? '['.$chunks[$index]['heading'].'] '.$chunks[$index]['text']
                : $chunks[$index]['text'];

            if ($used + mb_strlen($piece) > $maxChars) {
                continue;
            }

            $selected[$index] = $piece;
            $used += mb_strlen($piece);
        }

        if ($selected === []) {
            return Str::limit($chunks[array_key_first($scores)]['text'], $maxChars);
        }

        ksort($selected);

        return implode("\n\n[...]\n\n", $selected);
    }

    private function queryEmbedding(string $text, string $apiKey)
    {
        $client = new \GuzzleHttp\Client();
        $resp = $client->post('https://api.openai.com/v1/embeddings', [
            'headers' => ['Authorization' => "Bearer $apiKey", 'Content-Type' => 'application/json'],
            'json' => ['model' => 'text-embedding-3-small', 'input' => $text],
            'timeout' => 15,
        ]);
        $body = json_decode((string)$resp->getBody(), true);
        return $body['data'][0]['embedding'] ?? null;
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
