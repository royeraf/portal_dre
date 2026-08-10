<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use RuntimeException;
use Symfony\Component\Process\Process;

class PdfSecurityScanner
{
    private const ACTIVE_MARKERS = [
        '/JavaScript', '/JS', '/Launch', '/EmbeddedFile', '/OpenAction', '/AA', '/RichMedia',
    ];

    public function assertSafe(UploadedFile $file): void
    {
        $path = $file->getRealPath();
        if (! $path || ! is_readable($path)) {
            throw new RuntimeException('No se pudo inspeccionar el archivo cargado.');
        }

        $handle = fopen($path, 'rb');
        $header = $handle ? fread($handle, 5) : false;
        if (is_resource($handle)) {
            fclose($handle);
        }

        if ($header !== '%PDF-') {
            throw new RuntimeException('El archivo no tiene una cabecera PDF válida.');
        }

        $contents = file_get_contents($path);
        if ($contents === false) {
            throw new RuntimeException('No se pudo analizar el contenido del PDF.');
        }

        if (str_contains($contents, '/Encrypt')) {
            throw new RuntimeException('No se aceptan PDFs cifrados o protegidos con contraseña.');
        }

        foreach (self::ACTIVE_MARKERS as $marker) {
            if (preg_match('/'.preg_quote($marker, '/').'\b/i', $contents) === 1) {
                throw new RuntimeException('El PDF contiene acciones o archivos incrustados no permitidos.');
            }
        }

        $this->scanWithClamAv($path);
    }

    private function scanWithClamAv(string $path): void
    {
        $binary = trim((string) config('security.clamav.binary'));
        $required = (bool) config('security.clamav.required', false);

        if ($binary === '') {
            if ($required) {
                throw new RuntimeException('El antivirus institucional no está configurado.');
            }

            return;
        }

        $process = new Process([$binary, '--no-summary', $path]);
        $process->setTimeout((int) config('security.clamav.timeout_seconds', 90));
        $process->run();

        if ($process->getExitCode() === 1) {
            throw new RuntimeException('El antivirus rechazó el PDF.');
        }

        if (! $process->isSuccessful()) {
            throw new RuntimeException('No se pudo completar el análisis antivirus del PDF.');
        }
    }
}
