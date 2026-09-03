<?php

namespace App\Services;

use RuntimeException;
use Smalot\PdfParser\Parser;

class PdfMarkdownExtractor
{
    public function __construct(
        private PdfOcrTranscriber $transcriber,
        private PdfLocalOcrTranscriber $localTranscriber,
        private KnowledgeTextSanitizer $sanitizer,
    ) {}

    public function extract(string $filePath, string $title): array
    {
        $pdf = (new Parser())->parseFile($filePath);
        $text = trim($pdf->getText());
        $paginas = count($pdf->getPages());

        // Algunas normas escaneadas no tienen texto y otras contienen una capa corrupta
        // llena de glifos. Ambas deben pasar por OCR para no indexar contenido ilegible.
        if (! $this->isUsableText($text) && $this->localTranscriber->enabled()) {
            $text = trim($this->localTranscriber->transcribe($filePath));
        }

        if (! $this->isUsableText($text) && config('services.openai.ocr', true)) {
            $text = trim($this->transcriber->transcribe($filePath, $paginas));
        }

        if (! $this->isUsableText($text)) {
            throw new RuntimeException('No se pudo extraer texto. El PDF puede ser una imagen escaneada y requerir OCR.');
        }

        $text = $this->sanitizer->sanitize($text);

        return [
            'markdown' => $this->toMarkdown($text, $title),
            'page_count' => $paginas,
        ];
    }

    private function isUsableText(string $text): bool
    {
        if (mb_strlen($text) < 30) {
            return false;
        }

        $length = max(1, mb_strlen($text));
        $allowed = preg_replace(
            '/[^A-Za-zÁÉÍÓÚÜÑáéíóúüñ0-9\s.,;:()¿?¡!%°ºª\/\-]/u',
            '',
            $text
        );
        preg_match_all('/\b[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]{3,}\b/u', $text, $words);
        preg_match_all('/[\x{0080}-\x{009F}�‚ƒ„…†‡ˆ‰Š‹ŒŽ‘’“”•–—˜™š›œžŸ]/u', $text, $mojibake);

        return mb_strlen($allowed) / $length >= 0.72
            && count($words[0] ?? []) >= 3
            && count($mojibake[0] ?? []) / $length < 0.01;
    }

    private function toMarkdown(string $text, string $title): string
    {
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        $text = preg_replace('/[\t ]+\n/', "\n", $text);
        $text = preg_replace('/\n{3,}/', "\n\n", $text);
        $blocks = preg_split('/\n{2,}/', trim($text));
        $markdown = ['# '.trim($title)];

        foreach ($blocks as $block) {
            $block = trim(preg_replace('/[ \t]+/', ' ', $block));

            if ($block === '') {
                continue;
            }

            // Un bloque que solo contiene un número es el folio de la página. Descartarlo
            // dejaba al asistente sin forma de citar página en los PDFs con capa de texto;
            // se conserva como marcador explícito, el mismo formato que emite el OCR.
            if (preg_match('/^(\d{1,3})$/u', $block, $folio)) {
                $markdown[] = '## Pagina '.$folio[1];

                continue;
            }

            if (mb_strlen($block) <= 120 && preg_match('/^[\p{Lu}\d\s.,:;()\-]+$/u', $block)) {
                // Require at least one letter to treat as a heading (avoid page numbers).
                if (preg_match('/\p{L}/u', $block)) {
                    $markdown[] = '## '.mb_convert_case($block, MB_CASE_TITLE, 'UTF-8');
                    continue;
                }
                // otherwise fall through to normal paragraph handling
            }

            $markdown[] = $block;
        }

        return implode("\n\n", $markdown)."\n";
    }
}
