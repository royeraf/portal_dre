<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> POPUPS
    </x-slot>
    <h6 class="br-section-label">Editar</h6>
    <form action="{{ route('popup.update', $popup) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row mg-b-25">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-control-label" for="titulopopup">Titulo: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="titulopopup" id="titulopopup" value="{{$popup->titulopopup}}" placeholder="Nombre">
                    <x-input-error :messages="$errors->get('titulopopup')" class="mt-2" />
                </div>
            </div><!-- col-4 -->
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-control-label" for="enlace_popup">Enlace:</label>
                    <input class="form-control" type="text" name="enlace_popup" id="enlace_popup" value="{{$popup->enlace_popup}}" placeholder="http://">
                    <x-input-error :messages="$errors->get('enlace_popup')" class="mt-2" />
                </div>
            </div>
            <div class="col">
                <label class="form-control-label">Activo: <span class="tx-danger">*</span></label>
                <br>
                <div id="br-toggle3" class="br-toggle br-toggle-rounded br-toggle-success {{ $popup->estado=='1' ? 'on' : '' }}">
                    <div class="br-toggle-switch"></div>
                </div>
                <input type="hidden" name="estado" value="{{$popup->estado}}">
            </div>
        </div><!-- row -->
        <div class="row">
            <div class="col">
                <button class="btn btn-info">Guardar</button>
            </div>
        </div>
    </form><br>
    <form action="{{ route('popup.imagen.store', $popup) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="form-control-label" for="enlace">Enlace:</label>
                    <input class="form-control" type="text" name="enlace" id="enlace" value="{{$popup->enlace}}" placeholder="http://">
                    <x-input-error :messages="$errors->get('enlace')" class="mt-2" />
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-control-label" for="inputGroupFile">IMAGEN: </label>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile" name="imagen" required>
                        <label class="custom-file-label" for="inputGroupFile" aria-describedby="inputGroupFileAddon">Elige imagen</label>
                    </div>
                    <button title="Agregar Imagen" class="btn btn-info"><i class="fa fa-plus"></i></button>
                </div>
                <div class="border rounded-lg text-center p-3">
                    <img src="//placehold.it/140?text=IMAGE" class="img-fluid" id="preview" />
                </div>
                <br><br>
            </div>
        </div>
    </form>
    <div class="row">
        <table class="table table-hover small">
            <tr>
                <th class="border border-slate-500">ID</th>
                <th class="border border-slate-500">IMAGEN</th>
                <th class="border border-slate-500">ENLACE</th>
                <th class="border border-slate-500">FECHA SUBIDA</th>
                <th class="border border-slate-500">ACCION</th>
            </tr>
            @foreach ($imagenes as $item)
            @php
                $image_path = public_path('../../public_html/img/popup/').$item->imagen;
            @endphp
            <tr>
                <td class="border border-slate-500">{{$item->id}}</td>
                <td class="border border-slate-500">
                    <?php if (file_exists($image_path)){  ?>
                        <img src="{{asset('img/popup/'.$item->imagen)}}" class="img-fluid img-thumbnail" width="90px" />
                    <?php } ?>
                </td>
                <td class="border border-slate-500">{{$item->enlace}}</td>
                <td class="border border-slate-500">{{$item->created_at}}</td>
                <td class="border border-slate-500">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{ route('popup.imagen.destroy', $item) }}" class="btn btn-danger btn-sm eliminar" title="Eliminar"><i class="fas fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>
