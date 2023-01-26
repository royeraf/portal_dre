<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> COMUNICADOS
    </x-slot>
    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border border-slate-500">ID</th>
                        <th class="border border-slate-500">TITULO</th>
                        <th class="border border-slate-500">imagen</th>
                        <th class="border border-slate-500">Accion</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($comunicados as $item)
                <tr>
                    <td class="border border-slate-500">{{ $item->id }}</td>
                    <td class="border border-slate-500">{{ $item->titulo }}</td>
                    <td class="border border-slate-500 p-0">
                        <?php
                        $image_path = public_path('img/comunicados/').$item->imagen; 
                        if (file_exists($image_path)){  ?>
                        <div class="col">
                            <img src="{{asset('img/comunicados/'.$item->imagen)}}" class="img-fluid" width="150" />
                        </div>
                        <?php } ?>
                    </td>                                                     
                    <td class="border border-slate-500">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('comunicado.destroy', $item->id) }}" class="btn btn-danger btn-sm eliminar" title="Eliminar"><i class="fas fa-trash"></i></a>
                            <a href="{{route('comunicado.edit', $item->id)}}" class="btn btn-warning btn-sm" title="Editar"><i class="icon ion-edit"></i></a>
                        </div>
                    </td>
                </tr>
                </tbody>
                @endforeach
            </table>
            {{ $comunicados->links() }}
        </div>
    </div>
</x-app-layout>
