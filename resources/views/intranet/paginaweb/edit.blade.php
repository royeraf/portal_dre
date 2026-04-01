<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> Noticias
    </x-slot>
    <h6 class="br-section-label">Editar</h6>
    <form action="{{ route('paginaweb.update', $pagina) }}" method="POST">
        @csrf
        @method('put')
        <div class="row mg-b-25">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-control-label">Nombre Pagina: </label>
                    <input class="form-control" type="text" name="nom_pagina" id="nom_pagina" value="{{$pagina->nom_pagina}}" placeholder="">
                </div>
            </div><!-- col-4 -->
        </div><!-- row -->
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="idpagina" value="">
                <div class="form-group">
                    <label class="form-control-label">Contenido: </label>
                    <textarea rows="8" class="form-control is-valid mg-t-20" name="cont_pagina" id="mysummernote" placeholder="Textarea (success state)">
                        {{$pagina->cont_pagina}}
                    </textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn btn-info">Guardar</button>
            </div>
        </div>
    </form>

</x-app-layout>

