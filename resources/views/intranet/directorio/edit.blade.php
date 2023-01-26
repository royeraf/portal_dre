<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> DIRECTORIO
    </x-slot>
    <h6 class="br-section-label">Registro</h6>
    <form action="{{ route('directorio.update', $directorio) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row mg-b-25">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-control-label" for="apenom">APELLIDOS Y NOMBRES: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="apenom" id="apenom" value="{{$directorio->apenom}}">
                    <x-input-error :messages="$errors->get('apenom')" class="mt-2" />
                </div>
            </div><!-- col-4 -->
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-control-label" for="area">Area:</label>
                    <select name="area" id="area" class="form-control">
                        @foreach ($areas as $item)
                           <option value="{{$item->nombre}}" <?= $item->nombre==$directorio->area ? 'selected="selected"' : '' ?>>{{$item->nombre}}</option> 
                        @endforeach
                    </select>
                </div>                
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-control-label" for="area">Cargo:</label>
                    <input type="text" class="form-control" name="cargo" value="{{$directorio->cargo}}">
                </div>
            </div>
        </div><!-- row -->
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="form-control-label" for="dni">DNI:</label>
                    <input type="text" class="form-control" name="dni" value="{{$directorio->dni}}" required>
                </div>
            </div>            
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-control-label" for="Email">Email:</label>
                    <input type="text" class="form-control" name="email" value="{{$directorio->email}}">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="form-control-label" for="celular">Celular:</label>
                    <input type="text" class="form-control" name="celular" value="{{$directorio->celular}}">
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
                    <?php
                    $image_path = public_path('img/fotos/').$directorio->foto; 
                        if (file_exists($image_path)){  ?>    
                        <div class="col">
                            <img src="{{asset('img/fotos/'.$directorio->foto)}}" class="img-fluid img-thumbnail" id="preview1" />
                        </div>
                        <?php } ?>
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
