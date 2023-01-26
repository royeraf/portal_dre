<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> Galeria
    </x-slot>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1><small>Titulo : </small>{{ $galeria->titulo }}</h1>
                <h2><small>Descripcion : </small><?= $galeria->descripcion ?></h2>
                <h2><small>Fecha Publicacion : </small>{{$galeria->fecha_publicacion}}</h2> 
            </div>
            <div class="col">
            </div>
        </div>
        <a href="{{route('galeria.agregarimagen', $galeria)}}" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</a>
        <br><br>
        <div class="row">
            <table class="table table-hover small">
                <tr>
                    <th class="border border-slate-500">ID</th>
                    <th class="border border-slate-500">IMAGEN</th>
                    <th class="border border-slate-500">FECHA SUBIDA</th>
                    <th class="border border-slate-500">ACCION</th>
                </tr>
                @foreach ($imagenes as $item)
                @php
                    $image_path = public_path('img/imageneventos/').$item->archivo_img; 
                @endphp
                <tr>
                    <td class="border border-slate-500">{{$item->id}}</td>
                    <td class="border border-slate-500">
                        <?php if (file_exists($image_path)){  ?>
                            <img src="{{asset('img/imageneventos/'.$item->archivo_img)}}" class="img-fluid img-thumbnail" width="90px" />
                        <?php } ?>
                    </td>
                    <td class="border border-slate-500">{{$item->created_at}}</td>
                    <td class="border border-slate-500">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('galeria.destroyarchivo', $item) }}" class="btn btn-danger btn-sm eliminar" title="Eliminar"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>    
                </tr>
                @endforeach            
            </table>            
        </div>

    </div>
</x-app-layout>

