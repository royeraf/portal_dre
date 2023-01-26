<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> SLIDER
    </x-slot>
    <h6 class="br-section-label">Editar</h6>
    <form action="{{ route('slide.update', $slider) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row mg-b-25">
            <div class="col-lg-5">
                <div class="form-group">
                    <label class="form-control-label" for="titulo">Titulo: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="titulo" id="titulo" value="{{$slider->titulo}}" placeholder="Nombre">
                    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="link">LINK: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="link" id="link" value="{{$slider->link}}" placeholder="http://">
                    <x-input-error :messages="$errors->get('link')" class="mt-2" />
                </div>                
            </div>

            <div class="col-lg-7">
                <div class="form-group">
                    <label class="form-control-label" for="titulo">Descripcion Corta: <span class="tx-danger">*</span></label>
                    <textarea name="descripcioncorta" id="descripcioncorta" rows="4" class="form-control">{{$slider->descripcioncorta}}</textarea>
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
                    <img src="{{asset('img/slider/'.$slider->img_slider)}}" class="img-fluid" id="preview" />
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
</x-app-layout>
