<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> Paginas
    </x-slot>
    <h6 class="br-section-label">Registro</h6>
    <form action="{{ route('paginaweb.store') }}" method="POST">
        @csrf
        <div class="row mg-b-25">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-control-label">Nombre Pagina: </label>
                    <input class="form-control" type="text" name="nom_pagina" id="nom_pagina" :value="old('nom_pagina')" placeholder="">
                </div>
            </div><!-- col-4 -->
        </div><!-- row -->
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="idpagina" value="">
                <div class="form-group">
                    <label class="form-control-label">Contenido: </label>
                    <textarea rows="8" class="form-control is-valid mg-t-20" name="cont_pagina" id="mysummernote" placeholder="Textarea (success state)"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn btn-info">Guardar</button>
            </div>
        </div>
    </form>
    <br>
    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border border-slate-500">ID</th>
                        <th class="border border-slate-500">Nombre</th>
                        <th class="border border-slate-500">LINK</th>
                        <th class="border border-slate-500">Estado</th>
                        <th class="border border-slate-500">Accion</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($paginas as $item)
                <tr>
                    <td class="border border-slate-500">{{ $item->id }}</td>
                    <td class="border border-slate-500">{{ $item->nom_pagina }}</td>
                    <td class="border border-slate-500"><a href="https://drehuanuco.gob.pe/paginas/{{ $item->id }}">https://drehuanuco.gob.pe/paginas/{{ $item->id }}</a></td>
                    <td class="border border-slate-500">{{ $item->activo_pag==1 ? 'ACTIVO' : 'INACTIVO' }}</td>
                    <td class="border border-slate-500">
                    <a href="{{ route('pagina.destroy', $item->id) }}" class="btn btn-danger btn-sm eliminar" title="Eliminar"><i class="fas fa-trash"></i></a>
                    <a href="{{ route('pagina.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Editar"><i class="fa fa-pen"></i></a>
                    </td>
                </tr>
                </tbody>
                @endforeach
            </table>
            {{ $paginas->links() }}
        </div>
    </div>
</x-app-layout>
