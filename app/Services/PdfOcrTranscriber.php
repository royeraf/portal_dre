<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Transcribe PDFs sin capa de texto usando el modelo con visión.
 *
 * La mayoría de las normas institucionales (ROF, reglamentos, resoluciones directorales)
 * se publican como papel escaneado: el parser no obtiene ni un carácter y el documento
 * quedaría fuera del conocimiento del asistente.
 */
class PdfOcrTranscriber
{
    /** Páginas por petición cuando el documento es largo y no cabe en una sola respuesta. */
    private const PAGINAS_POR_TANDA = 25;

    private const INSTRUCCION = 'Transcribe integramente el texto de este documento, pagina por pagina, de forma literal. '
        .'No resumas, no comentes y no agregues nada que no este en el documento. '
        .'Antepon a cada pagina una linea con el formato: ## Pagina N';

    public function transcribe(string $filePath, int $paginas = 0): string
    {
        $apiKey = config('services.openai.key');

        if (!$apiKey) {
            throw new RuntimeException('Falta OPENAI_API_KEY: no se puede transcribir un PDF escaneado.');
        }

        $fileId = $this->subir($filePath, $apiKey);

        try {
            // Documentos cortos entran en una sola respuesta; los largos se piden por tandas
            // para no agotar el presupuesto de tokens de salida a mitad de la transcripción.
            if ($paginas > 0 && $paginas > self::PAGINAS_POR_TANDA) {
                $partes = [];

                for ($desde = 1; $desde <= $paginas; $desde += self::PAGINAS_POR_TANDA) {
                    $hasta = min($desde + self::PAGINAS_POR_TANDA - 1, $paginas);
                    $partes[] = $this->pedir(
                        $fileId,
                        $apiKey,
                        self::INSTRUCCION." Transcribe unicamente las paginas {$desde} a {$hasta}."
                    );
                }

                return trim(implode("\n\n", array_filter($partes)));
            }

            return $this->pedir($fileId, $apiKey, self::INSTRUCCION);
        } finally {
            $this->borrar($fileId, $apiKey);
        }
    }

    private function subir(string $filePath, string $apiKey): string
    {
        $respuesta = Http::timeout(300)
            ->withToken($apiKey)
            ->attach('file', file_get_contents($filePath), basename($filePath))
            ->post('https://api.openai.com/v1/files', ['purpose' => 'user_data']);

        if (!$respuesta->successful()) {
            throw new RuntimeException('No se pudo subir el PDF para transcribir: '.$respuesta->body());
        }

        return $respuesta->json('id');
    }

    private function pedir(string $fileId, string $apiKey, string $instruccion): string
    {
        $respuesta = Http::timeout(900)
            ->withToken($apiKey)
            ->post('https://api.openai.com/v1/responses', [
                'model' => config('services.openai.ocr_model', 'gpt-5.6-luna'),
                'input' => [[
                    'role' => 'user',
                    'content' => [
                        ['type' => 'input_file', 'file_id' => $fileId],
                        ['type' => 'input_text', 'text' => $instruccion],
                    ],
                ]],
                'max_output_tokens' => 32000,
            ]);

        if (!$respuesta->successful()) {
            throw new RuntimeException('Falló la transcripción ('.$respuesta->status().'): '.$respuesta->body());
        }

        return trim((string) collect($respuesta->json('output', []))
            ->flatMap(fn (array $item) => $item['content'] ?? [])
            ->firstWhere('type', 'output_text')['text'] ?? '');
    }

    private function borrar(string $fileId, string $apiKey): void
    {
        // El PDF ya está guardado en el servidor: no hay motivo para dejar copias en la API.
        try {
            Http::timeout(30)->withToken($apiKey)->delete('https://api.openai.com/v1/files/'.$fileId);
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
