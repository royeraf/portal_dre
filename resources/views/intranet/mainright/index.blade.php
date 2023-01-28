<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> Mainright
    </x-slot>
    <h6 class="br-section-label">Registro</h6>
    <form action="{{ route('mainright.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mg-b-25">
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-control-label" for="nombre">Nombre: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="nombre" id="nombre" :value="old('nombre')" placeholder="Nombre" required>
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="form-control-label" for="url">Link: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="url" id="url" value="" placeholder="URL">
                    <x-input-error :messages="$errors->get('url')" class="mt-2" />
                </div>  
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="form-control-label" for="indice">Indice<span class="tx-danger">*</span></label>
                    <input class="form-control" type="number" name="indice" id="indice" value="{{$indice+1}}">
                    <x-input-error :messages="$errors->get('indice')" class="mt-2" />
                </div>  
            </div>
            <div class="col-lg-5">
                <label class="form-control-label" for="inputGroupFile">IMAGEN: </label>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile" name="imagen" accept="image/png,image/jpeg" required>
                        <label class="custom-file-label" for="inputGroupFile" aria-describedby="inputGroupFileAddon">Choose image</label>
                    </div>
                </div>
                <span class="alert-warning">215px de Ancho</span>
                <div class="border rounded-lg text-center p-3">
                    <img src="//placehold.it/140?text=IMAGE" class="img-fluid" id="preview" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn btn-info">Guardar</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col">
            <table class="table table-hover small">
                <thead>
                    <tr>
                        <th class="border border-slate-500">ID</th>
                        <th class="border border-slate-500">Nombre</th>
                        <th class="border border-slate-500">Indice</th>
                        <th class="border border-slate-500">Url</th>
                        <th class="border border-slate-500">Imagen</th>
                        <th class="border border-slate-500">Accion</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($registros as $item)
                <tr>
                    <td class="border border-slate-500">{{ $item->id }}</td>
                    <td class="border border-slate-500">{{ $item->nombre }}</td>
                    <td class="border border-slate-500">{{ $item->indice }}</td>
                    <td class="border border-slate-500">{{ $item->url }}</td>
                    <td class="border border-slate-500">
                        <?php
                        $image_path = public_path('img/mainright/').$item->imagen; 
                        if (file_exists($image_path)){  ?>
                            <img src="{{asset('img/mainright/'.$item->imagen)}}" class="img-fluid" width="150" />
                        <?php } ?>
                    </td>
                    <td class="border border-slate-500">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('mainright.destroy', $item->id) }}" class="btn btn-danger btn-sm eliminar" title="Eliminar"><i class="fas fa-trash"></i></a>
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
