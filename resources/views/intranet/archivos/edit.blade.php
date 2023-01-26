<x-app-layout>

    <x-slot name="header">
        <h2><i class="far fa-clone"></i> ARCHIVOS
    </x-slot>
    <h6 class="br-section-label">Editar</h6>
    <form action="{{ route('archivos.update', $archivo) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row mg-b-25">
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="form-control-label" for="nombre">Nombre: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="nombre" id="nombre" value="{{$archivo->nombre}}">
                </div>
            </div><!-- col-4 -->
            <div class="col">
                <div class="form-group">
                    <label class="form-control-label" for="nom_archivo">Archivo: <span class="tx-danger">*</span></label>
                    <div class="custom-file">
                        <input type="file" id="file" name="file" class="custom-file-input">
                        <label class="custom-file-label"></label>
                    </div>                    
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mg-b-10-force">
                <label class="form-control-label" for="categoria">Categoria: <span class="tx-danger">*</span></label>
                <select name="categoria" id="categoria" class="form-control">
                    <option value="Comunicado" <?= $archivo->categoria=='Comunicado' ? 'selected="selected"' : '' ?>>Comunicado</option>
                    <option value="Solicitud" <?= $archivo->categoria=='Solicitud' ? 'selected="selected"' : '' ?>>Solicitud</option>
                    <option value="Oficio" <?= $archivo->categoria=='Oficio' ? 'selected="selected"' : '' ?>>Oficio</option>
                    <option value="Resolucion" <?= $archivo->categoria=='Resolucion' ? 'selected="selected"' : '' ?>>Resolucion</option>
                </select>
                </div>
            </div><!-- col-4 -->
        </div><!-- row -->
        <div class="row">
            <div class="col">
                <label class="form-control-label" for="categoria">Link: </label>
                <a href="{{asset('archivos/'.$archivo->link)}}">{{asset('archivos/'.$archivo->link)}}</a>
                <br><br>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn btn-info">Guardar</button>
            </div>
        </div>
  
    </form>
</x-app-layout>
