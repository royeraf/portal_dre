<?php

namespace App\Console\Commands;

use App\Models\KnowledgeDocument;
use App\Services\KnowledgeIndexer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class IndexKnowledge extends Command
{
    protected $signature = 'knowledge:index
                            {--documento= : Indexa solo el documento con este id}
                            {--todos : Reindexa también los documentos que ya tienen fragmentos}';

    protected $description = 'Genera los fragmentos y embeddings que el chatbot usa para buscar en los PDFs';

    public function handle(KnowledgeIndexer $indexer): int
    {
        $documentos = KnowledgeDocument::query()
            ->where('status', 'ready')
            ->when($this->option('documento'), fn ($q, $id) => $q->where('id', $id))
            ->orderBy('id')
            ->get();

        if ($documentos->isEmpty()) {
            $this->warn('No hay documentos procesados para indexar.');

            return self::SUCCESS;
        }

        $fallos = 0;

        foreach ($documentos as $documento) {
            $existentes = DB::table('ai_knowledge_chunks')->where('document_id', $documento->id)->count();

            if ($existentes > 0 && !$this->option('todos') && !$this->option('documento')) {
                $this->line("- {$documento->title}: ya tiene {$existentes} fragmentos, se omite (usa --todos para rehacerlo)");

                continue;
            }

            try {
                $total = $indexer->index($documento);
                $this->info("- {$documento->title}: {$total} fragmentos indexados");
            } catch (\Throwable $e) {
                $fallos++;
                $this->error("- {$documento->title}: {$e->getMessage()}");
            }
        }

        return $fallos > 0 ? self::FAILURE : self::SUCCESS;
    }
}
