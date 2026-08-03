<?php

namespace App\Services;

use RuntimeException;
use Smalot\PdfParser\Parser;

class PdfMarkdownExtractor
{
    public function __construct(private PdfOcrTranscriber $transcriber)
    {
    }

    public function extract(string $filePath, string $title): array
    {
        $pdf = (new Parser())->parseFile($filePath);
        $text = trim($pdf->getText());
        $paginas = count($pdf->getPages());

        // Las normas institucionales suelen publicarse escaneadas y no tienen capa de texto.
        if (mb_strlen($text) < 30 && config('services.openai.ocr', true)) {
            $text = trim($this->transcriber->transcribe($filePath, $paginas));
        }

        if (mb_strlen($text) < 30) {
            throw new RuntimeException('No se pudo extraer texto. El PDF puede ser una imagen escaneada y requerir OCR.');
        }

        return [
            'markdown' => $this->toMarkdown($text, $title),
            'page_count' => $paginas,
        ];
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
