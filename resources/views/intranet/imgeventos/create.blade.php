<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> IMAGENES EVENTOS
    </x-slot>
    <h6 class="br-section-label">Registro Galerias</h6>
    <form action="{{ route('galeria.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mg-b-25">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-control-label" for="titulo">Titulo: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="titulo" id="titulo" :value="old('titulo')" placeholder="Titulo">
                    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-5">
                <div class="form-group">
                    <label class="form-control-label" for="descripcion">Descripcion: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="descripcion" id="descripcion" :value="old('descripcion')">
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>
            </div><!-- col-4 -->
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-control-label" for="fecha_publicacion">Fecha Publicacion: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="date" name="fecha_publicacion" id="fecha_publicacion" value="{{date('Y-m-d')}}" placeholder="http://">
                    <x-input-error :messages="$errors->get('fecha_publicacion')" class="mt-2" />
                </div>                
            </div><!-- col-4 -->
        </div><!-- row -->
        <div class="row">
            <div class="col">
                <button class="btn btn-info">Guardar</button>
            </div>
        </div>
  
    </form>
    <br>

</x-app-layout>
