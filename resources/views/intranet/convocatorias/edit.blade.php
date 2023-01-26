<x-app-layout>

    <x-slot name="header">
        <h2><i class="far fa-clone"></i> CONVOCATORIAS
    </x-slot>
    <h6 class="br-section-label">Editar</h6>
    <form action="{{ route('convocatoria.update', $convocatoria) }}" method="POST">
        @csrf
        @method('put')
        <div class="row mg-b-25">
            <div class="col">
                <div class="form-group">
                    <label class="form-control-label" for="tipo">TIPO: <span class="tx-danger">*</span></label>
                    <select name="tipo" id="tipo" class="form-control">
                        <option value="CAS" {{$convocatoria->tipo=='CAS' ? 'selected' : ''}}>CAS</option>
                        <option value="CAP" {{$convocatoria->tipo=='CAP' ? 'selected' : ''}}>CAP</option>
                        <option value="DOCENTE" {{$convocatoria->tipo=='DOCENTE' ? 'selected' : ''}}>DOCENTE</option>
                        <option value="DIRECTIVO" {{$convocatoria->tipo=='DIRECTIVO' ? 'selected' : ''}}>DIRECTIVO</option>
                        <option value="REASIGNACION" {{$convocatoria->tipo=='REASIGNACION' ? 'selected' : ''}}>REASIGNACION</option>
                    </select>
                    <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label class="form-control-label" for="titulo">Titulo: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="titulo" id="titulo" placeholder="titulo" value="{{$convocatoria->titulo}}" required>
                    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                </div>
            </div><!-- col-4 -->
            <div class="col">
                <div class="form-group">
                    <label class="form-control-label" for="fecha_inicio">Fecha Inicio: <span class="tx-danger">*</span></label>
                    <input type="date" name="fecha_inicio" value="{{$convocatoria->fecha_inicio}}" class="form-control">                
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label class="form-control-label" for="fecha_inicio">Fecha Termino: <span class="tx-danger">*</span></label>
                    <input type="date" name="fecha_termino" value="{{$convocatoria->fecha_termino}}" class="form-control">                
                </div>
            </div>
            <div class="col">

            </div>            
        </div><!-- row -->
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-control-label" for="descripcion">Descripcion: <span class="tx-danger">*</span></label>
                    <textarea name="descripcion" id="descripcion" class="form-control">{{$convocatoria->descripcion}}</textarea>
                </div>                
            </div>
            <div class="col">
                <div class="form-group">
                    <label class="form-control-label" for="estado">Estado : <span class="tx-danger">*</span></label>
                    <input type="text" name="estado" id="estado" value="{{$convocatoria->estado}}" class="form-control">                
                </div> 
            </div>   
            <div class="col">
                <label class="form-control-label">Activo: <span class="tx-danger">*</span></label>
                <br>
                <div id="br-toggle4" class="br-toggle br-toggle-rounded br-toggle-success {{ $convocatoria->es_activo=='1' ? 'on' : '' }}">
                    <div class="br-toggle-switch"></div>
                </div>
                <input type="hidden" name="es_activo" value="{{$convocatoria->es_activo}}">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn btn-info">Guardar</button>
            </div>
        </div>
  
    </form>
</x-app-layout>
