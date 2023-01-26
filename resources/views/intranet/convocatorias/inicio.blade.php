<x-app-layout>

    <x-slot name="header">
        <h2><i class="far fa-clone"></i> CONVOCATORIAS
    </x-slot>
    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border border-slate-500">ID</th>
                        <th class="border border-slate-500">Titulo</th>
                        <th class="border border-slate-500">Fecha Inicio</th>
                        <th class="border border-slate-500">Fecha Fin</th>
                        <th class="border border-slate-500">Estado</th>
                        <th class="border border-slate-500">Accion</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($convocatorias as $item)
                <tr>
                    <td class="border border-slate-500">{{ $item->id }}</td>
                    <td class="border border-slate-500">{{ $item->titulo }}</td>
                    <td class="border border-slate-500">{{ $item->fecha_inicio }}</td>
                    <td class="border border-slate-500">{{ $item->fecha_termino }}</td>
                    <td class="border border-slate-500">{{ $item->estado }}</td>
                    <td class="border border-slate-500">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('convocatoria.destroy', $item->id) }}" class="btn btn-danger btn-sm eliminar" title="Eliminar"><i class="fas fa-trash"></i></a>
                            <a href="{{route('convocatoria.edit', $item->id)}}" class="btn btn-warning btn-sm" title="Editar"><i class="icon ion-edit"></i></a>
                            <a href="{{route('convocatoria.show', $item->id)}}" class="btn btn-primary btn-sm" title="Mostrar"><i class="fa fa-eye"></i></a>
                        </div>

                    </td>
                </tr>
                </tbody>
                @endforeach
            </table>
            {{ $convocatorias->links() }}
        </div>
    </div>
</x-app-layout>
