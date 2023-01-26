<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> SLIDER
    </x-slot>
    <h6 class="br-section-label">Registro</h6>
    <form action="{{ route('slide.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mg-b-25">
            <div class="col-lg-5">
                <div class="form-group">
                    <label class="form-control-label" for="titulo">Titulo: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="titulo" id="titulo" :value="old('titulo')" placeholder="Nombre">
                    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="link">LINK: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="link" id="link" :value="old('link')" placeholder="http://">
                    <x-input-error :messages="$errors->get('link')" class="mt-2" />
                </div>
            </div><!-- col-4 -->
            <div class="col-lg-7">
                <div class="form-group">
                    <label class="form-control-label" for="titulo">Descripcion Corta: <span class="tx-danger">*</span></label>
                    <textarea name="descripcioncorta" id="descripcioncorta" rows="4" class="form-control"></textarea>
                </div>
            </div><!-- col-4 -->
        </div><!-- row -->
        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile" name="img_slider">
                        <label class="custom-file-label" for="inputGroupFile" aria-describedby="inputGroupFileAddon">Choose image</label>
                    </div>
                    <div class="input-group-append">
                        <span class="input-group-text" id="inputGroupFileAddon">Upload</span>
                    </div>
                </div>
                <div class="border rounded-lg text-center p-3">
                    <img src="//placehold.it/140?text=IMAGE" class="img-fluid" id="preview" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="tx-teal">Recuerda que las dimensiones recomendadas de tu imagen tiene que ser de 1920x1128 pixeles</p>
                
            </div>
        </div><br>
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
                        <th>Titulo</th>
                        <th>Descripcion</th>
                        <th class="border border-slate-500">imagen</th>
                        <th class="border border-slate-500">Estado</th>
                        <th class="border border-slate-500">Accion</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($sliders as $item)
                <tr>
                    <td class="border border-slate-500">{{ $item->id }}</td>
                    <td>{{ $item->titulo }}</td>
                    <td>{{ $item->descripcioncorta }}</td>
                    <td class="border border-slate-500 text-center"><img width="300" class="img-fluid img-thumbnail mx-auto" src="{{asset('img/slider/'.$item->img_slider)}}" alt=""></td>
                    <td class="border border-slate-500">{{ $item->activo_slider==1 ? 'ACTIVO' : 'INACTIVO' }}</td>
                    <td class="border border-slate-500">
                    <a href="{{ route('slide.destroy', $item->id) }}" class="btn btn-danger btn-sm eliminar" title="Eliminar"><i class="fas fa-trash"></i></a>
                    <a href="{{route('slide.edit', $item->id)}}" class="btn btn-warning btn-sm" title="Editar"><i class="icon ion-edit"></i></a>&nbsp;

                    </td>
                </tr>
                </tbody>
                @endforeach
            </table>
            {{ $sliders->links() }}
        </div>
    </div>



</x-app-layout>
