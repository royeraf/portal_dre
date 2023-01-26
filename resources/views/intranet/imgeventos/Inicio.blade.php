<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> IMAGENES EVENTOS
    </x-slot>
    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border border-slate-500">ID</th>
                        <th class="border border-slate-500">Titulo</th>
                        <th class="border border-slate-500">Descripcion</th>
                        <th class="border border-slate-500">imagen</th>
                        <th class="border border-slate-500">Fecha Publicacion</th>
                        <th class="border border-slate-500">Accion</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($registros as $item)
                <tr>
                    <td class="border border-slate-500">{{ $item->id }}</td>
                    <td class="border border-slate-500">{{ $item->titulo }}</td>
                    <td class="border border-slate-500">{{ $item->descripcion }}</td>
                    <td class="border border-slate-500 text-center"><img width="300" class="img-fluid img-thumbnail mx-auto" src="{{asset('img/imageneventos/'.$item->img)}}" alt=""></td>
                    <td class="border border-slate-500">{{ $item->fecha_publicacion }}</td>
                    <td class="border border-slate-500">
                        <div class="btn-group">
                            <a href="{{ route('galeria.destroy', $item->id) }}" class="btn btn-danger btn-sm eliminar" title="Eliminar"><i class="fas fa-trash"></i></a>
                            <a href="{{route('galeria.edit', $item->id)}}" class="btn btn-warning btn-sm" title="Editar"><i class="icon ion-edit"></i></a>
                            <a href="{{route('galeria.show', $item->id)}}" class="btn btn-primary btn-sm" title="Mostrar"><i class="fa fa-eye"></i></a>
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
