<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeDocument;
use App\Services\KnowledgeIndexer;
use App\Services\PdfMarkdownExtractor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class KnowledgeDocumentController extends Controller
{
    public function index(): View
    {
        return view('intranet.knowledge.index', [
            'documents' => KnowledgeDocument::latest()->paginate(12),
        ]);
    }

    public function store(Request $request, PdfMarkdownExtractor $extractor): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:20480'],
        ]);

        $file = $validated['pdf'];
        $filename = Str::uuid()->toString().'.pdf';
        $path = $file->storeAs('ai-knowledge/pdfs', $filename, 'local');
        $document = KnowledgeDocument::create([
            'title' => $validated['title'] ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'original_filename' => $file->getClientOriginalName(),
            'pdf_path' => $path,
            'status' => 'processing',
            'uploaded_by' => $request->user()->id,
        ]);

        try {
            $result = $extractor->extract(Storage::disk('local')->path($path), $document->title);
            $document->update([
                'markdown' => $result['markdown'],
                'page_count' => $result['page_count'],
                'status' => 'ready',
            ]);

            // Sin fragmentos indexados el chatbot no encuentra este PDF por búsqueda semántica,
            // pero el texto ya quedó guardado, así que un fallo aquí no invalida la carga.
            try {
                $total = app(KnowledgeIndexer::class)->index($document);

                return redirect()->route('knowledge.index')
                    ->with('success', "PDF procesado e indexado para el asistente ({$total} fragmentos).");
            } catch (\Throwable $indexacion) {
                report($indexacion);

                return redirect()->route('knowledge.index')
                    ->with('error', 'El PDF se procesó, pero no se pudo indexar para la búsqueda del asistente: '
                        .$indexacion->getMessage().' Puedes reintentar con: php artisan knowledge:index --documento='.$document->id);
            }
        } catch (\Throwable $exception) {
            report($exception);
            $document->update([
                'status' => 'failed',
                'error_message' => Str::limit($exception->getMessage(), 1000),
            ]);

            return redirect()->route('knowledge.index')->with('error', 'El PDF se guardó, pero no se pudo extraer texto: '.$exception->getMessage());
        }
    }

    public function destroy(KnowledgeDocument $knowledgeDocument): RedirectResponse
    {
        Storage::disk('local')->delete($knowledgeDocument->pdf_path);
        $knowledgeDocument->delete();

        return redirect()->route('knowledge.index')->with('success', 'Documento eliminado del conocimiento de la IA.');
    }

    public function download(KnowledgeDocument $knowledgeDocument)
    {
        abort_unless($knowledgeDocument->status === 'ready' && $knowledgeDocument->is_published, 404);
        abort_unless(Storage::disk('local')->exists($knowledgeDocument->pdf_path), 404);

        return Storage::disk('local')->download($knowledgeDocument->pdf_path, $knowledgeDocument->original_filename);
    }
}
