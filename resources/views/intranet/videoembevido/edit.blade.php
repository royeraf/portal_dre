<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> Noticias
    </x-slot>
    <h6 class="br-section-label">Editar</h6>
    <form action="{{ route('videoembevido.update', $videoembevido) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="row mg-b-25">
            <div class="col-lg-10">
                <div class="form-group">
                    <label class="form-control-label" for="titulo">Titulo: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="titulo" id="titulo" value="{{$videoembevido->titulo}}" placeholder="Nombre">
                    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-2">

            </div>
        </div><!-- row -->
        <div class="row">
            <div class="col">
                <label class="form-control-label" for="contenido">CONTENIDO <span class="tx-danger">*</span></label>
                <textarea name="contenido" id="contenido" class="form-control" rows="5" placeholder="Contenido de Embevido">{{ $videoembevido->contenido }}</textarea>
                <br>
            </div>
        </div>
        <br>





        <div class="row">
            <div class="col">
                <button class="btn btn-info">Guardar</button>
            </div>
        </div>
    </form>

</x-app-layout>

