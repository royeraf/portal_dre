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
            <div class="col-lg-12">
                <label class="form-control-label" for="contenido">CONTENIDO: <span class="tx-danger">*</span></label>
                <textarea rows="16" class="form-control is-valid mg-t-20" name="contenido" id="mysummernote">
                    <?= $popup->contenido ?>
                </textarea>
            </div><!-- col-4 -->            
        </div>
        <div class="row">
            <div class="col">
                <label class="form-control-label" for="inputGroupFile1">IMAGEN: </label>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile1" name="imagen">
                        <label class="custom-file-label" for="inputGroupFile1" aria-describedby="inputGroupFileAddon">Choose image</label>
                    </div>
                </div>
                <div class="border rounded-lg text-center p-3">
                    <img src="{{asset('img/popup/'.$popup->imagen)}}" class="img-fluid" id="preview1" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn btn-info">Guardar</button>
            </div>
        </div>
    </form><br>
</x-app-layout>
