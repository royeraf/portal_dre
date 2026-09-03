<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use RuntimeException;
use Symfony\Component\Process\Process;

class PdfLocalOcrTranscriber
{
    public function enabled(): bool
    {
        return (bool) config('services.local_pdf_ocr.enabled', false)
            && is_file((string) config('services.local_pdf_ocr.tesseract'))
            && is_file((string) config('services.local_pdf_ocr.pdftoppm'));
    }

    public function transcribe(string $filePath): string
    {
        if (! $this->enabled()) {
            throw new RuntimeException('El OCR local no está disponible.');
        }

        $directory = storage_path('app/ocr-tmp/'.bin2hex(random_bytes(8)));
        File::ensureDirectoryExists($directory);
        $prefix = $directory.DIRECTORY_SEPARATOR.'page';

        try {
            $render = new Process([
                (string) config('services.local_pdf_ocr.pdftoppm'),
                '-jpeg', '-r', (string) config('services.local_pdf_ocr.dpi', 180),
                $filePath, $prefix,
            ]);
            $render->setTimeout((int) config('services.local_pdf_ocr.pdf_timeout', 900));
            $render->mustRun();

            $images = File::glob($prefix.'-*.jpg');
            natsort($images);
            $parts = [];

            foreach (array_values($images) as $index => $image) {
                $ocr = new Process([
                    (string) config('services.local_pdf_ocr.tesseract'),
                    $image, 'stdout',
                    '--tessdata-dir', (string) config('services.local_pdf_ocr.tessdata'),
                    '-l', (string) config('services.local_pdf_ocr.languages', 'spa+eng'),
                    '--oem', '1', '--psm', '6',
                ]);
                $ocr->setTimeout((int) config('services.local_pdf_ocr.page_timeout', 180));
                $ocr->mustRun();
                $text = trim($ocr->getOutput());

                if ($text !== '') {
                    $parts[] = '## Pagina '.($index + 1)."\n\n".$text;
                }
            }

            if ($parts === []) {
                throw new RuntimeException('El OCR local no pudo reconocer texto en el PDF.');
            }

            return implode("\n\n", $parts);
        } finally {
            File::deleteDirectory($directory);
        }
    }
}
