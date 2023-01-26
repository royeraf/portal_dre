<x-app-layout>

    <x-slot name="header">
        <h2><i class="far fa-clone"></i> ARCHIVOS
    </x-slot>
    <h6 class="br-section-label">Registro</h6>
    <form action="{{ route('archivos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mg-b-25">
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="form-control-label" for="nombre">Nombre: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="nombre" id="nombre" :value="old('nombre')" placeholder="Nombre">
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>
            </div><!-- col-4 -->
            <div class="col">
                <div class="form-group">
                    <label class="form-control-label" for="nom_archivo">Archivo: <span class="tx-danger">*</span></label>
                    <div class="custom-file">
                        <input type="file" id="file" name="file" class="custom-file-input">
                        <label class="custom-file-label"></label>
                    </div>                    
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mg-b-10-force">
                <label class="form-control-label" for="categoria">Categoria: <span class="tx-danger">*</span></label>
                <select name="categoria" id="categoria" class="form-control">
                    <option value="Comunicado">Comunicado</option>
                    <option value="Solicitud">Solicitud</option>
                    <option value="Oficio">Oficio</option>
                    <option value="Resolucion">Resolucion</option>
                </select>
                </div>
            </div><!-- col-4 -->
        </div><!-- row -->
        <div class="row">
            <div class="col">
                <button class="btn btn-info">Guardar</button>
            </div>
        </div>
  
    </form><br>
    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border border-slate-500">ID</th>
                        <th class="border border-slate-500">Nombre</th>
                        <th class="border border-slate-500">Link</th>
                        <th class="border border-slate-500">Categoria</th>
                        <th class="border border-slate-500">Accion</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($archivos as $item)
                <tr>
                    <td class="border border-slate-500">{{ $item->id }}</td>
                    <td class="border border-slate-500">{{ $item->nombre }}</td>
                    <td class="border border-slate-500">
                        <a href="{{asset('archivos/'.$item->link)}}">{{asset('archivos/'.$item->link)}}</a>
                    </td>
                    <td class="border border-slate-500">{{ $item->categoria }}</td>
                    <td class="border border-slate-500">
                    <a href="{{ route('archivos.destroy', $item->id) }}" class="btn btn-danger btn-sm eliminar" title="Eliminar"><i class="fas fa-trash"></i></a>
                    <a href="{{route('archivos.edit', $item->id)}}" class="btn btn-warning btn-sm" title="Editar"><i class="icon ion-edit"></i></a>&nbsp;
                    </td>
                </tr>
                </tbody>
                @endforeach
            </table>
            {{ $archivos->links() }}
        </div>
    </div>
</x-app-layout>
