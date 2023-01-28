<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> Archivos Documentos de Gestion
    </x-slot>
    <h6 class="br-section-label">Registro Documentos de Gestion : {{$Documentogestion->titulo}}</h6>
    <form action="{{ route('archivoDocumentogestion.store', $Documentogestion) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mg-b-25">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-control-label" for="nombre">Nombre: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="nombre" id="nombre" :value="old('nombre')" placeholder="nombre" required>
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-control-label" for="url_archivo">URL: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="url_archivo" id="url_archivo" :value="old('url_archivo')" placeholder="url_archivo" required>
                    <x-input-error :messages="$errors->get('url_archivo')" class="mt-2" />
                </div>
            </div>
        </div><!-- row -->
        <div class="row">
            <div class="col">
                <button class="btn btn-info">Guardar</button>
                <br>
            </div>
        </div>
    </form>
    <br>
    <div class="row">
        <div class="col">
            <table class="table table-hover small">
                <thead>
                    <tr>
                        <th class="border border-slate-500">ID</th>
                        <th class="border border-slate-500">Nombre</th>
                        <th class="border border-slate-500">URL</th>
                        <th class="border border-slate-500">Accion</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($registros as $item)
                <tr>
                    <td class="border border-slate-500">{{ $item->id }}</td>
                    <td class="border border-slate-500">{{ $item->nombre }}</td>
                    <td class="border border-slate-500"><a href="{{ $item->url_archivo }}">{{ $item->url_archivo }}</a></td>
                    <td class="border border-slate-500">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('archivoDocumentogestion.destroy', $item->id) }}" class="btn btn-danger btn-sm eliminar" title="Eliminar"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                </tbody>
                @endforeach
            </table>
            {{ $registros->links() }}
        </div>
    </div>
</x-app-layout>
