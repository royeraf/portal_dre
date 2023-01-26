<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> DIRECTORIO
    </x-slot>
    <h6 class="br-section-label">Registro</h6>
    <form action="{{ route('directorio.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mg-b-25">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-control-label" for="apenom">APELLIDOS Y NOMBRES: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="apenom" id="apenom" :value="old('apenom')" placeholder="Apellidos y Nombres" required>
                    <x-input-error :messages="$errors->get('apenom')" class="mt-2" />
                </div>
            </div><!-- col-4 -->
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-control-label" for="area">Area:</label>
                    <select name="area" id="area" class="form-control">
                        @foreach ($areas as $item)
                           <option value="{{$item->nombre}}">{{$item->nombre}}</option> 
                        @endforeach
                    </select>
                </div>                
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-control-label" for="area">Cargo:</label>
                    <input type="text" class="form-control" name="cargo" placeholder="Cargo">
                </div>
            </div>
        </div><!-- row -->
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="form-control-label" for="dni">DNI:</label>
                    <input type="text" class="form-control" name="dni" placeholder="00000000" maxlength="8" required>
                </div>
            </div>            
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-control-label" for="Email">Email:</label>
                    <input type="text" class="form-control" name="email" placeholder="johnpaul@yourdomain.com">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="form-control-label" for="celular">Celular:</label>
                    <input type="text" class="form-control" name="celular" placeholder="999999999">
                </div>                
            </div>
            <div class="col-lg-4">
                <label class="form-control-label" for="inputGroupFile1">Foto: </label>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile1" name="foto">
                        <label class="custom-file-label" for="inputGroupFile1" aria-describedby="inputGroupFileAddon">Choose image</label>
                    </div>
                </div>
                <div class="border rounded-lg text-center p-3">
                    <img src="//placehold.it/140?text=IMAGE" class="img-fluid" id="preview1" />
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
