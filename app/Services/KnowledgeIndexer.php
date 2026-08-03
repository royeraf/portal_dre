<?php

namespace App\Services;

use App\Models\KnowledgeDocument;
use App\Support\OpenAi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class KnowledgeIndexer
{
    private const MODELO = 'text-embedding-3-small';

    /** Tamaño objetivo de cada fragmento. Suficiente para dar contexto sin diluir el embedding. */
    private const TAMANO_CHUNK = 900;

    /** Fragmentos por llamada a la API de embeddings. */
    private const POR_LOTE = 64;

    /**
     * Genera los fragmentos y embeddings de un documento y reemplaza los que tuviera.
     * Sin esto el chatbot solo conoce los PDFs que alguien indexó a mano.
     */
    public function index(KnowledgeDocument $document): int
    {
        $apiKey = config('services.openai.key');

        if (!$apiKey) {
            throw new RuntimeException('Falta OPENAI_API_KEY: no se pueden generar los embeddings.');
        }

        $fragmentos = $this->fragmentar((string) $document->markdown);

        if ($fragmentos === []) {
            return 0;
        }

        $filas = [];
        $ahora = now();

        foreach (array_chunk($fragmentos, self::POR_LOTE) as $lote) {
            $vectores = $this->embeddings(array_column($lote, 'text'), $apiKey);

            foreach ($lote as $i => $fragmento) {
                if (!isset($vectores[$i])) {
                    continue;
                }

                $filas[] = [
                    'document_id' => $document->id,
                    'heading' => $fragmento['heading'] !== '' ? Str::limit($fragmento['heading'], 180, '') : null,
                    'page' => $fragmento['page'],
                    'text' => $fragmento['text'],
                    'embedding' => json_encode($vectores[$i]),
                    'chunk_index' => count($filas),
                    'created_at' => $ahora,
                    'updated_at' => $ahora,
                ];
            }
        }

        if ($filas === []) {
            throw new RuntimeException('La API no devolvió ningún embedding utilizable.');
        }

        // El reemplazo se hace al final y en una transacción: si la API falla a medio camino,
        // el documento conserva el índice que ya tenía en vez de quedarse sin ninguno.
        DB::transaction(function () use ($document, $filas) {
            DB::table('ai_knowledge_chunks')->where('document_id', $document->id)->delete();

            foreach (array_chunk($filas, 50) as $lote) {
                DB::table('ai_knowledge_chunks')->insert($lote);
            }
        });

        return count($filas);
    }

    /**
     * @return array<int, array{heading: string, page: int|null, text: string}>
     */
    private function fragmentar(string $markdown): array
    {
        $fragmentos = [];
        $actual = '';
        $encabezado = '';
        $pagina = null;
        $paginaDelFragmento = null;

        foreach (preg_split('/\n{2,}/', $markdown) as $bloque) {
            $bloque = trim($bloque);

            if ($bloque === '') {
                continue;
            }

            if (Str::startsWith($bloque, '#')) {
                // El OCR marca cada página con "## Pagina N". Es un marcador, no un título:
                // se anota la página y no se arrastra como encabezado del fragmento.
                if (preg_match('/^#+\s*p[aá]gina\s+(\d+)/iu', $bloque, $m)) {
                    $pagina = (int) $m[1];

                    continue;
                }

                $encabezado = trim(ltrim($bloque, '# '));
            }

            $paginaDelFragmento ??= $pagina;

            // Un bloque muy largo produciría un fragmento cuyo embedding mezcla demasiados
            // temas y deja de parecerse a ninguna consulta concreta.
            foreach ($this->partirLargo($bloque) as $pieza) {
                $actual .= ($actual === '' ? '' : "\n\n").$pieza;

                if (mb_strlen($actual) >= self::TAMANO_CHUNK) {
                    $fragmentos[] = ['heading' => $encabezado, 'page' => $paginaDelFragmento, 'text' => $actual];
                    $actual = '';
                    $paginaDelFragmento = null;
                }
            }
        }

        if (trim($actual) !== '') {
            $fragmentos[] = ['heading' => $encabezado, 'page' => $paginaDelFragmento, 'text' => $actual];
        }

        return $fragmentos;
    }

    /**
     * Corta por final de oración los bloques que exceden el tamaño objetivo.
     *
     * @return array<int, string>
     */
    private function partirLargo(string $bloque): array
    {
        if (mb_strlen($bloque) <= self::TAMANO_CHUNK) {
            return [$bloque];
        }

        $piezas = [];
        $actual = '';

        foreach (preg_split('/(?<=[.:;!?])\s+/u', $bloque) as $oracion) {
            $actual .= ($actual === '' ? '' : ' ').$oracion;

            if (mb_strlen($actual) >= self::TAMANO_CHUNK) {
                $piezas[] = $actual;
                $actual = '';
            }
        }

        if (trim($actual) !== '') {
            $piezas[] = $actual;
        }

        return $piezas;
    }

    /**
     * @param  array<int, string>  $textos
     * @return array<int, array<int, float>>
     */
    private function embeddings(array $textos, string $apiKey): array
    {
        $respuesta = OpenAi::http(60)
            ->retry(2, 500)
            ->post('https://api.openai.com/v1/embeddings', [
                'model' => self::MODELO,
                'input' => array_values($textos),
            ]);

        if (!$respuesta->successful()) {
            throw new RuntimeException('Fallo al pedir embeddings ('.$respuesta->status().'): '.$respuesta->body());
        }

        $vectores = [];

        foreach ($respuesta->json('data', []) as $item) {
            // La API puede devolver los elementos desordenados; el índice manda.
            $vectores[$item['index'] ?? count($vectores)] = $item['embedding'] ?? null;
        }

        return array_filter($vectores, 'is_array');
    }
}
