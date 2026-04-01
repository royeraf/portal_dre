<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> GALERIA DE VIDEOS

    </x-slot>
    <h6 class="br-section-label">Registro</h6>
    <form action="{{ route('videoembevido.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mg-b-25">
            <div class="col-lg-10">
                <div class="form-group">
                    <label class="form-control-label" for="titulo">Titulo: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="titulo" id="titulo" :value="old('titulo')" placeholder="Nombre">
                    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="form-control-label" for="iduser">ID USUARIO: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="iduser" id="iduser" value="{{ Auth::user()->id }}" readonly>
                    <x-input-error :messages="$errors->get('iduser')" class="mt-2" />
                </div>
            </div>
        </div><!-- row -->
        <div class="row">
            <div class="col">
                <label class="form-control-label" for="contenido">CONTENIDO <span class="tx-danger">*</span></label>
                <textarea name="contenido" id="contenido" class="form-control" rows="5" placeholder="Contenido de Embevido"></textarea>
                <br>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <button class="btn btn-info">Guardar</button>
                <br><br>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-hover small">
                    <thead>
                        <tr>
                            <th class="border border-slate-500">ID</th>
                            <th class="border border-slate-500">Titulo</th>
                            <th class="border border-slate-500">Contenido</th>
                            <th class="border border-slate-500">Fecha Publicacion</th>
                            <th class="border border-slate-500">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($registros as $item)
                    <tr>
                        <td class="border border-slate-500">{{ $item->id }}</td>
                        <td class="border border-slate-500">{{ $item->titulo }}</td>
                        <td class="border border-slate-500">{{ $item->contenido }}</td>
                        <td class="border border-slate-500">{{ $item->created_at }}</td>
                        <td class="border border-slate-500">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('videoembevido.destroy', $item->id) }}" class="btn btn-danger btn-sm eliminar" title="Eliminar"><i class="fas fa-trash"></i></a>
                                <a href="{{route('videoembevido.edit', $item->id)}}" class="btn btn-warning btn-sm" title="Editar"><i class="icon ion-edit"></i></a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                    @endforeach
                </table>
                {{ $registros->links() }}
            </div>
        </div>
    </form>

</x-app-layout>

