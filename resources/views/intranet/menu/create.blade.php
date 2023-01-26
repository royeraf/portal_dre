<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> MENUS
    </x-slot>
    <h6 class="br-section-label">Registro</h6>
    <form action="{{ route('menus.store') }}" method="POST">
        @csrf
        <div class="row mg-b-25">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-control-label" for="nom_menu">Nombre: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="nom_menu" id="nom_menu" :value="old('nom_menu')" placeholder="Nombre" required>
                    <x-input-error :messages="$errors->get('nom_menu')" class="mt-2" />
                </div>
            </div><!-- col-4 -->
            <div class="col-lg-2">
                <label class="form-control-label">Pagina: <span class="tx-danger">*</span></label>
                <br>
                <div id="br-toggle1" class="br-toggle br-toggle-rounded br-toggle-primary">
                    <div class="br-toggle-switch"></div>
                  </div>
            </div><!-- col-4 -->
            <div class="col-lg-3">
                <div class="form-group mg-b-10-force">
                <label class="form-control-label" for="categoriamenu">Categoria: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="categoriamenu" name="categoriamenu" data-placeholder="Elige Categoria">
                    <option value="">NINGUNO</option>
                    @foreach ($menusdd as $item)
                        <option value="{{$item->id}}">{{$item->nom_menu}}</option>
                    @endforeach
                </select>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-control-label" for="link_menu">Link: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="link_menu" id="link_menu" value="#" placeholder="Link Menu">
                    <x-input-error :messages="$errors->get('link_menu')" class="mt-2" />
                </div>   
            </div>
        </div><!-- row -->
        <div class="row">
            <div class="col-md-12 d-none" id="contenidopagina">
                <label class="form-control-label">Titulo Pagina: </label>
                <input class="form-control" type="text" name="nom_pagina" id="nom_pagina" :value="old('nom_pagina')" placeholder="">
                <label class="form-control-label">Contenido: </label>
                <textarea rows="8" class="form-control is-valid mg-t-20" name="cont_pagina" id="mysummernote" placeholder="Textarea (success state)"></textarea>
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
                        <th class="border border-slate-500">Nombre</th>
                        <th class="border border-slate-500">Link</th>
                        <th class="border border-slate-500">Estado</th>
                        <th class="border border-slate-500">Categoria</th>
                        <th class="border border-slate-500">Accion</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($menus as $item)
                <tr>
                    <td class="border border-slate-500">{{ $item->id }}</td>
                    <td class="border border-slate-500">{{ $item->nom_menu }}</td>
                    <td class="border border-slate-500">{{ $item->link_menu }}</td>
                    <td class="border border-slate-500">{{ $item->activo_menu==1 ? 'ACTIVO' : 'INACTIVO' }}</td>
                    <td class="border border-slate-500">{{ $item->categoria }}</td>
                    <td class="border border-slate-500">
                    <a href="{{ route('menus.destroy', $item->id) }}" class="btn btn-danger btn-sm eliminar" title="Eliminar"><i class="fas fa-trash"></i></a>
                    <a href="{{route('menu.edit', $item->id)}}" class="btn btn-warning btn-sm" title="Editar"><i class="icon ion-edit"></i></a>&nbsp;
                    </td>
                </tr>
                </tbody>
                @endforeach
            </table>
            {{ $menus->links() }}
        </div>
    </div>
</x-app-layout>
