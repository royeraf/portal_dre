<x-app-layout>
    <x-slot name="header">
        <h2><i class="icon ion-ios-lightbulb-outline"></i> Conocimiento de la IA
            <small class="mg-b-0">PDFs institucionales para el asistente virtual</small>
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="alert alert-info">
        Sube PDFs con texto seleccionable. El sistema los convierte a Markdown y el chatbot usará ese contenido como fuente institucional. Los PDFs escaneados necesitan OCR para poder leerse.
    </div>

    <form method="POST" action="{{ route('knowledge.store') }}" enctype="multipart/form-data" class="form-layout form-layout-4">
        @csrf
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="title">Título <span class="tx-danger">(opcional)</span></label>
                    <input class="form-control" type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Se toma del nombre del archivo si se deja vacío">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="pdf">PDF <span class="tx-danger">*</span></label>
                    <input class="form-control" type="file" id="pdf" name="pdf" accept="application/pdf" required>
                    <small class="form-text text-muted">Máximo 20 MB.</small>
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-block mb-3"><i class="fas fa-file-upload"></i> Procesar</button>
            </div>
        </div>
    </form>

    <div class="table-responsive mt-4">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th>Estado</th>
                    <th>Páginas</th>
                    <th>Markdown</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $document)
                    <tr>
                        <td>
                            <strong>{{ $document->title }}</strong><br>
                            <small class="text-muted">{{ $document->original_filename }}</small>
                        </td>
                        <td>
                            @if($document->status === 'ready')
                                <span class="badge badge-success">Listo</span>
                            @elseif($document->status === 'failed')
                                <span class="badge badge-danger" title="{{ $document->error_message }}">No procesado</span>
                            @else
                                <span class="badge badge-warning">Procesando</span>
                            @endif
                        </td>
                        <td>{{ $document->page_count ?: '-' }}</td>
                        <td>
                            @if($document->markdown)
                                <details>
                                    <summary>Ver contenido</summary>
                                    <pre class="mt-2 mb-0" style="max-width:500px; white-space:pre-wrap;">{{ \Illuminate\Support\Str::limit($document->markdown, 1200) }}</pre>
                                </details>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-nowrap">
                            @if($document->status === 'ready')
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('knowledge.download', $document) }}"><i class="fas fa-file-pdf"></i></a>
                            @endif
                            <form method="POST" action="{{ route('knowledge.destroy', $document) }}" class="d-inline" onsubmit="return confirm('¿Eliminar este PDF y su conocimiento extraído?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">Aún no hay documentos cargados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $documents->links() }}
</x-app-layout>
