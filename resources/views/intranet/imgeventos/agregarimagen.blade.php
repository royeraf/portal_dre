<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> Noticia
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
        <form action="{{ route('galeria.storeimagen', $galeria) }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="idgaleria" value="{{$galeria->id}}">
            @csrf
            <div class="row mg-b-25">
                <div class="col-lg-4">
                    <label class="form-control-label" for="inputGroupFile2">IMAGEN: </label>
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile2" name="archivo_img" required>
                            <label class="custom-file-label" for="inputGroupFile2" aria-describedby="inputGroupFileAddon">Choose image</label>
                        </div>
                    </div>
                    <div class="border rounded-lg text-center p-3">
                        <img src="//placehold.it/140?text=IMAGE" class="img-fluid" id="preview2" />
                    </div>
                </div>
            </div><!-- row -->
            <div class="row">
                <div class="col">
                    <button class="btn btn-info">Guardar</button>
                </div>
            </div>
      
        </form>
    </div>
</x-app-layout>