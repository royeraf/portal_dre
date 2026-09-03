<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> Convocatoria</h2>
    </x-slot>
    <h2 class="tx-primary">{{ $convocatoria->tipo.': '.$convocatoria->titulo }}</h2>
    <?= $convocatoria->descripcion ?>
    <div class="row tx-primary">
        <div class="col">
            <h3>FECHA INICIO<br><small>{{$convocatoria->fecha_inicio}}</small></h3>
        </div>
        <div class="col">
            <h3>FECHA TERMINO<br><small>{{$convocatoria->fecha_termino}}</small></h3>
        </div>
        <div class="col">
            <h3>FIN DE INSCRIPCION<br><small>{{$convocatoria->fecha_fin_inscripcion}}</small></h3>
        </div>
    </div>
    <div class="row tx-primary">
        <div class="col">
            <h3>FECHA PUBLICACION RESULTADOS<br><small>{{$convocatoria->fecha_resultados}}</small></h3>
        </div>
        <div class="col">
            <h3>FECHA TERMINO<br><small>{{$convocatoria->fecha_termino}}</small></h3>
        </div>
        <div class="col">
            <h3>ESTADO<br><small>{{$convocatoria->estado}}</small></h3>
        </div>       
    </div>
    <div class="row">
        <div class="col">
            <h2>REGISTROS &nbsp;<a href="{{route('archivo.convocatoria.create', $convocatoria)}}" class="btn btn-primary" title="Agregar Registro"><i class="fa fa-plus"></i> Agregar</a></h2>
            <table class="table table-hover small">
                <thead>
                    <tr>
                        <th class="border border-slate-500">ID</th>
                        <th class="border border-slate-500">Nombre</th>
                        <th class="border border-slate-500">Url</th>
                        <th class="border border-slate-500">Etapa</th>
                        <th class="border border-slate-500">Accion</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($archivos_convocatoria as $item)
                <tr>
                    <td class="border border-slate-500">{{ $item->id }}</td>
                    <td class="border border-slate-500">{{ $item->nom_archivo }}</td>
                    <td class="border border-slate-500"><a href="{{ $item->url_archivo }}">{{ $item->url_archivo }}</a></td>
                    <td class="border border-slate-500">{{ $item->etapa }}</td>
                    <td class="border border-slate-500">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <form method="POST" action="{{ route('archivo.convocatoria.destroy', $item) }}" class="d-inline" onsubmit="return confirm('¿Eliminar este archivo de la convocatoria?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                </tbody>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>

