<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> MENUS
    </x-slot>
    <h6 class="br-section-label">Editar</h6>
    <form action="{{ route('menus.update', $menu) }}" method="POST">
        @csrf
        @method('put')
        <div class="row mg-b-25">
            <div class="col-lg-4">
                <div class="form-group">
                    <input type="hidden" name="id" value="{{$menu->id}}">
                    <label class="form-control-label" for="nom_menu">Nombre: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="nom_menu" id="nom_menu" value="{{$menu->nom_menu}}" placeholder="Nombre">
                    <x-input-error :messages="$errors->get('nom_menu')" class="mt-2" />
                </div>
            </div><!-- col-4 -->
            <div class="col-lg-2">
                <label class="form-control-label">Pagina: <span class="tx-danger">*</span></label>
                <br>
                <div id="br-toggle1" class="br-toggle br-toggle-rounded br-toggle-primary {{ $menu->link_menu!='#' ? 'on' : '' }}">
                    <div class="br-toggle-switch"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mg-b-10-force">
                <label class="form-control-label" for="categoriamenu">Categoria: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="categoriamenu" name="categoriamenu" data-placeholder="Elige Categoria">
                    <option value="" {{($menu->categoriamenu=='' || $menu->categoriamenu==null) ? 'selected="selected"' : ''}}>NINGUNO</option>                    
                    @foreach ($menusdd as $item)
                        <option value="{{$item->id}}" {{$menu->categoriamenu==$item->id ? 'selected="selected"' : ''}}>{{$item->nom_menu}}</option>
                    @endforeach
                </select>
                </div>
            </div>
            <div class="col-lg-2">
                <label class="form-control-label">Activo: <span class="tx-danger">*</span></label>
                <br>
                <div id="br-toggle2" class="br-toggle br-toggle-rounded br-toggle-success {{ $menu->activo_menu=='1' ? 'on' : '' }}">
                    <div class="br-toggle-switch"></div>
                </div>
                <input type="hidden" name="activo_menu" value="{{$menu->activo_menu}}">
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label class="form-control-label" for="link_menu">Link: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="link_menu" id="link_menu" value="<?= $menu->link_menu ?>" placeholder="Link Menu">
                    <x-input-error :messages="$errors->get('link_menu')" class="mt-2" />
                
                </div>                 
            </div>
        </div>
        <div class="row">
            <?php if($menu->link_menu!='#'){ ?>
            <div class="col-md-12" id="contenidopagina">
                <input type="hidden" name="idpagina" value="{{$pagina->id}}">
                <label class="form-control-label">Nombre Pagina: </label>
                <input class="form-control" type="text" name="nom_pagina" id="nom_pagina" value="{{ $pagina->nom_pagina }}" placeholder="">
                <label class="form-control-label">Contenido: </label>
                <textarea rows="8" class="form-control is-valid mg-t-20" name="cont_pagina" id="mysummernote">{{$pagina->cont_pagina}}</textarea>
            </div>                
            <?php }else{ ?> 
            <div class="col-md-12 d-none" id="contenidopagina">
                <input type="hidden" name="idpagina" value="">
                <label class="form-control-label">Nombre Pagina: </label>
                <input class="form-control" type="text" name="nom_pagina" id="nom_pagina" :value="old('nom_pagina')" placeholder="">
                <label class="form-control-label">Contenido: </label>
                <textarea rows="8" class="form-control is-valid mg-t-20" name="cont_pagina" id="mysummernote" placeholder="Textarea (success state)"></textarea>
            </div> 
            <?php } ?>
            <div class="col-md-4 d-none">
                   
            </div>
        </div><br>
        <div class="row">
            <div class="col">
                <button class="btn btn-info">Guardar</button>
            </div>
        </div>
    </form>
</x-app-layout>
