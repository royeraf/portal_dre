<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> DIRECTORIO
    </x-slot>
    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border border-slate-500">ID</th>
                        <th class="border border-slate-500" width="30%">Apellidos y Nombres</th>
                        <th class="border border-slate-500">FOTO</th>
                        <th class="border border-slate-500">DNI</th>
                        <th class="border border-slate-500">Area</th>
                        <th class="border border-slate-500">Cargo</th>
                        <th class="border border-slate-500">Email</th>
                        <th class="border border-slate-500">Celular</th>
                        <th class="border border-slate-500">Accion</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($lista as $item)
                <tr>
                    <td class="border border-slate-500">{{ $item->id }}</td>
                    <td class="border border-slate-500">{{ $item->apenom }}</td>
                    <td class="border border-slate-500 p-0">
                        <?php
                        $image_path = public_path('img/fotos/').$item->foto; 
                        if (file_exists($image_path)){  ?>
                        <div class="col">
                            <img src="{{asset('img/fotos/'.$item->foto)}}" class="img-fluid" width="150" />
                        </div>
                        <?php } ?>
                    </td>
                    <td class="border border-slate-500">{{ $item->dni }}</td>
                    <td class="border border-slate-500">{{ $item->area }}</td>
                    <td class="border border-slate-500">{{ $item->cargo }}</td>
                    <td class="border border-slate-500">{{ $item->email }}</td>
                    <td class="border border-slate-500">{{ $item->celular }}</td>                                                          
                    <td class="border border-slate-500">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('directorio.destroy', $item->id) }}" class="btn btn-danger btn-sm eliminar" title="Eliminar"><i class="fas fa-trash"></i></a>
                            <a href="{{route('directorio.edit', $item->id)}}" class="btn btn-warning btn-sm" title="Editar"><i class="icon ion-edit"></i></a>
                        </div>
                    </td>
                </tr>
                </tbody>
                @endforeach
            </table>
            {{ $lista->links() }}
        </div>
    </div>
</x-app-layout>
