<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeDocument;
use App\Services\KnowledgeIndexer;
use App\Services\PdfMarkdownExtractor;
use App\Services\PdfSecurityScanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class KnowledgeDocumentController extends Controller
{
    public function index(): View
    {
        return view('intranet.knowledge.index', [
            'documents' => KnowledgeDocument::latest()->paginate(12),
        ]);
    }

    public function store(
        Request $request,
        PdfMarkdownExtractor $extractor,
        PdfSecurityScanner $scanner
    ): RedirectResponse {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:20480'],
        ]);

        $file = $validated['pdf'];
        try {
            $scanner->assertSafe($file);
        } catch (\RuntimeException $exception) {
            throw ValidationException::withMessages(['pdf' => $exception->getMessage()]);
        }
        $filename = Str::uuid()->toString().'.pdf';
        $path = $file->storeAs('ai-knowledge/pdfs', $filename, 'local');
        $document = KnowledgeDocument::create([
            'title' => $validated['title'] ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'original_filename' => $file->getClientOriginalName(),
            'pdf_path' => $path,
            'status' => 'processing',
            'is_published' => false,
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

    public function publish(Request $request, KnowledgeDocument $knowledgeDocument): RedirectResponse
    {
        abort_unless($knowledgeDocument->status === 'ready', 422, 'Solo se puede publicar un documento procesado.');

        $publish = $request->boolean('publish');
        $knowledgeDocument->update([
            'is_published' => $publish,
            'published_at' => $publish ? now() : null,
            'published_by' => $publish ? $request->user()->id : null,
        ]);

        return redirect()->route('knowledge.index')->with(
            'success',
            $publish ? 'Documento aprobado y publicado para el asistente.' : 'Documento retirado del conocimiento publicado.'
        );
    }

    public function download(KnowledgeDocument $knowledgeDocument)
    {
        abort_unless($knowledgeDocument->status === 'ready', 404);
        if (! $knowledgeDocument->is_published) {
            abort_unless(request()->user()?->can('manage-ai-knowledge'), 404);
        }
        if (! Storage::disk('local')->exists($knowledgeDocument->pdf_path)) {
            $filename = basename((string) $knowledgeDocument->original_filename);
            abort_if($filename === '' || $filename !== $knowledgeDocument->original_filename, 404);

            return redirect()->away(
                'https://www.drehuanuco.gob.pe/archivos/'.rawurlencode($filename)
            );
        }

        return Storage::disk('local')->download($knowledgeDocument->pdf_path, $knowledgeDocument->original_filename);
    }
}
