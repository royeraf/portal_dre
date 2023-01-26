<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> Noticias
    </x-slot>
    <h6 class="br-section-label">Editar</h6>
    <form action="{{ route('noticias.update', $noticia) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row mg-b-25">
            <div class="col-lg-10">
                <div class="form-group">
                    <label class="form-control-label" for="titulo">Titulo: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="titulo" id="titulo" value="{{$noticia->titulo}}" placeholder="Nombre">
                    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-2">
               
            </div>
        </div><!-- row -->
        <div class="row">
            <div class="col">
                <label class="form-control-label" for="descripcioncorta">DESCRIPCION CORTA <span class="tx-danger">*</span></label>
                <textarea name="descripcioncorta" id="descripcioncorta" class="form-control">{{$noticia->descripcioncorta}}</textarea> 
                <br>               
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <label class="form-control-label" for="idusuario">CONTENIDO: <span class="tx-danger">*</span></label>
                <textarea rows="16" class="form-control is-valid mg-t-20" name="contenido" id="mysummernote" placeholder="Contenido">{{$noticia->contenido}}</textarea>
            </div><!-- col-4 -->            
        </div>
        <br>
        <div class="row">
            <div class="col">
                <label class="form-control-label" for="inputGroupFile1">IMAGEN 1: </label>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile1" name="img1">
                        <label class="custom-file-label" for="inputGroupFile1" aria-describedby="inputGroupFileAddon">Choose image</label>
                    </div>
                </div>
                <div class="border rounded-lg text-center p-3">
                    <img src="{{asset('img/noticias/'.$noticia->img1)}}" class="img-fluid" id="preview1" />
                </div>
            </div>
            <div class="col">
                <label class="form-control-label" for="inputGroupFile2">IMAGEN 2: </label>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile2" name="img2">
                        <label class="custom-file-label" for="inputGroupFile2" aria-describedby="inputGroupFileAddon">Choose image</label>
                    </div>
                </div>
                <div class="border rounded-lg text-center p-3">
                    <img src="{{asset('img/noticias/'.$noticia->img2)}}" class="img-fluid" id="preview2" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label class="form-control-label" for="inputGroupFile3">IMAGEN 3: </label>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile3" name="img3">
                        <label class="custom-file-label" for="inputGroupFile3" aria-describedby="inputGroupFileAddon">Choose image</label>
                    </div>
                </div>
                <div class="border rounded-lg text-center p-3">
                    <img src="{{asset('img/noticias/'.$noticia->img3)}}" class="img-fluid" id="preview3" />
                </div>                  
            </div>
            <div class="col"></div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn btn-info">Guardar</button>
            </div>
        </div>
    </form>

</x-app-layout>

