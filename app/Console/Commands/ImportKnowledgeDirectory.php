<?php

namespace App\Console\Commands;

use App\Models\KnowledgeDocument;
use App\Services\KnowledgeIndexer;
use App\Services\PdfMarkdownExtractor;
use App\Services\PdfSecurityScanner;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Throwable;

class ImportKnowledgeDirectory extends Command
{
    protected $signature = 'knowledge:import-directory
                            {path : Carpeta que contiene los PDF}
                            {--limit=0 : Cantidad maxima de archivos; 0 procesa todos}
                            {--part=0 : Lote a procesar, empezando en 0}
                            {--parts=1 : Numero total de lotes paralelos}
                            {--publish : Publica los documentos procesados para el chatbot}
                            {--index : Genera embeddings inmediatamente}
                            {--only-referenced : Importa solo PDFs vinculados desde el CMS}
                            {--force : Reprocesa archivos cuyo nombre ya existe}';

    protected $description = 'Importa de forma segura todos los PDF de una carpeta al conocimiento de la IA';

    public function handle(
        PdfMarkdownExtractor $extractor,
        PdfSecurityScanner $scanner,
        KnowledgeIndexer $indexer
    ): int {
        $directory = realpath((string) $this->argument('path'));

        if ($directory === false || ! is_dir($directory)) {
            $this->error('La carpeta indicada no existe.');

            return self::FAILURE;
        }

        $files = collect(glob($directory.DIRECTORY_SEPARATOR.'*.pdf') ?: [])
            ->sort()
            ->values();

        if ($this->option('only-referenced')) {
            $referenced = $this->referencedPdfNames();
            $files = $files
                ->filter(fn (string $path) => $referenced->contains(Str::lower(basename($path))))
                ->values();
        }
        $parts = max(1, (int) $this->option('parts'));
        $part = (int) $this->option('part');

        if ($part < 0 || $part >= $parts) {
            $this->error('El lote debe estar entre 0 y '.($parts - 1).'.');

            return self::FAILURE;
        }

        if ($parts > 1) {
            $files = $files
                ->filter(fn (string $path) => (int) sprintf('%u', crc32(basename($path))) % $parts === $part)
                ->values();
        }
        $alreadyImported = 0;
        if (! $this->option('force') && $files->isNotEmpty()) {
            $existingNames = KnowledgeDocument::query()
                ->pluck('original_filename')
                ->map(fn (string $name) => Str::lower($name))
                ->flip();
            $alreadyImported = $files
                ->filter(fn (string $path) => $existingNames->has(Str::lower(basename($path))))
                ->count();
            $files = $files
                ->reject(fn (string $path) => $existingNames->has(Str::lower(basename($path))))
                ->values();
        }

        $limit = max(0, (int) $this->option('limit'));

        if ($limit > 0) {
            $files = $files->take($limit);
        }

        if ($files->isEmpty()) {
            $this->info($alreadyImported > 0
                ? "No hay PDFs nuevos; {$alreadyImported} ya estaban importados."
                : 'No se encontraron archivos PDF pendientes.');

            return self::SUCCESS;
        }

        $processed = 0;
        $skipped = $alreadyImported;
        $failed = 0;

        $this->info("Se procesaran {$files->count()} PDF desde {$directory}");

        foreach ($files as $sourcePath) {
            $originalName = basename($sourcePath);
            $existing = KnowledgeDocument::query()
                ->where('original_filename', $originalName)
                ->latest('id')
                ->first();

            if ($existing && ! $this->option('force')) {
                $skipped++;
                $this->line("- OMITIDO {$originalName}: ya fue importado");
                continue;
            }

            try {
                $uploaded = new UploadedFile($sourcePath, $originalName, 'application/pdf', null, true);
                $scanner->assertSafe($uploaded);

                $storedPath = 'ai-knowledge/pdfs/'.Str::uuid().'.pdf';
                Storage::disk('local')->put($storedPath, fopen($sourcePath, 'rb'));

                $provisionalTitle = pathinfo($originalName, PATHINFO_FILENAME);
                $result = $extractor->extract(Storage::disk('local')->path($storedPath), $provisionalTitle);
                $title = $this->titleFromMarkdown($result['markdown'], $provisionalTitle);
                $markdown = preg_replace('/^#\s+.*$/u', '# '.$title, $result['markdown'], 1);

                if ($existing && $this->option('force')) {
                    Storage::disk('local')->delete($existing->pdf_path);
                    $existing->delete();
                }

                $document = KnowledgeDocument::create([
                    'title' => $title,
                    'original_filename' => $originalName,
                    'pdf_path' => $storedPath,
                    'markdown' => $markdown,
                    'page_count' => $result['page_count'],
                    'status' => 'ready',
                    'is_published' => (bool) $this->option('publish'),
                    'published_at' => $this->option('publish') ? now() : null,
                ]);

                $chunks = null;
                if ($this->option('index')) {
                    $chunks = $indexer->index($document);
                }

                $processed++;
                $suffix = $chunks === null ? '' : ", {$chunks} fragmentos";
                $this->info("- OK {$originalName}: {$title}{$suffix}");
            } catch (Throwable $exception) {
                $failed++;
                $this->error("- ERROR {$originalName}: {$exception->getMessage()}");
            }
        }

        $this->newLine();
        $this->info("Resultado: {$processed} procesados, {$skipped} omitidos, {$failed} fallidos.");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function titleFromMarkdown(string $markdown, string $fallback): string
    {
        $lines = preg_split('/\R+/u', $markdown) ?: [];
        $candidates = [];

        foreach ($lines as $index => $line) {
            if ($index === 0) {
                continue;
            }

            $candidate = trim(preg_replace('/^#+\s*/u', '', $line));

            if ($candidate === '' || preg_match('/^p[aá]gina\s+\d+$/iu', $candidate)) {
                continue;
            }

            if (mb_strlen($candidate) >= 8 && preg_match('/\p{L}/u', $candidate)) {
                $candidates[] = $candidate;

                if (preg_match('/\b(?:cronograma|convocatoria|resoluci[oó]n|directiva|reglamento|informe|comunicado|bases|resultado)\b/iu', $candidate)) {
                    $title = $candidate;

                    for ($next = $index + 1; $next < min(count($lines), $index + 5); $next++) {
                        $continuation = trim(preg_replace('/^#+\s*/u', '', $lines[$next]));
                        if ($continuation === '' || preg_match('/^p[aá]gina\s+\d+$/iu', $continuation)) {
                            break;
                        }
                        if (mb_strlen($title.' '.$continuation) > 180) {
                            break;
                        }
                        $title .= ' '.$continuation;
                    }

                    return Str::limit($title, 180, '');
                }
            }
        }

        foreach ($candidates as $candidate) {
            if (! preg_match('/^(?:gorehco|dre\s*hu[aá]nuco|gobierno regional hu[aá]nuco)$/iu', $candidate)) {
                return Str::limit($candidate, 180, '');
            }
        }

        return $fallback;
    }

    /**
     * Devuelve únicamente nombres de PDF que el CMS realmente enlaza. Así un archivo
     * huérfano en public/archivos no termina incorporado accidentalmente a la IA.
     */
    private function referencedPdfNames()
    {
        $urls = collect();

        foreach ([
            ['archivo_convocatoria', 'url_archivo'],
            ['archivodocumentogestion', 'url_archivo'],
            ['archivo', 'link'],
        ] as [$table, $column]) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, $column)) {
                $urls = $urls->concat(DB::table($table)->whereNotNull($column)->pluck($column));
            }
        }

        return $urls
            ->map(function ($url) {
                $path = parse_url((string) $url, PHP_URL_PATH) ?: (string) $url;

                return Str::lower(rawurldecode(basename($path)));
            })
            ->filter(fn (string $name) => str_ends_with($name, '.pdf'))
            ->unique()
            ->values();
    }
}
