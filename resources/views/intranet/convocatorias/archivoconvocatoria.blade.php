<x-app-layout>

    <x-slot name="header">
        <h2><i class="far fa-clone"></i> CONVOCATORIAS
    </x-slot>
    <h6 class="br-section-label">Registro</h6>
    <form action="{{ route('archivo.convocatoria.store', $convocatoria) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label class="form-control-label" for="convocat_titulo">Convocatoria: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="convocat_titulo" id="convocat_titulo" value="{{$convocatoria->titulo}}" readonly>
                </div>
            </div><!-- col-4 -->            
        </div>
        <div class="row mg-b-25">
            <div class="col-4">
                <div class="form-group">
                    <label class="form-control-label" for="nom_archivo">Titulo: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="nom_archivo" id="nom_archivo" placeholder="Nombre" required>
                </div>
            </div><!-- col-4 -->
            <div class="col">
                <div class="form-group">
                    <label class="form-control-label" for="etapa">Etapa : <span class="tx-danger">*</span></label>
                    <select name="etapa" id="etapa" class="form-control">
                        <option value="INSCRIPCION">INSCRIPCION</option>
                        <option value="CURRICULAR">CURRICULAR</option>
                        <option value="ENTREVISTA">ENTREVISTA</option>
                        <option value="FINAL">FINAL</option>
                    </select>               
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label class="form-control-label" for="url_archivo">URL : <span class="tx-danger">*</span></label>
                    <input type="text" name="url_archivo" value="" class="form-control" placeholder="http://">                
                </div>
            </div>
        </div><!-- row -->
        <div class="row">
            <div class="col">
                <button class="btn btn-info">Guardar</button>
            </div>
        </div>
  
    </form>
</x-app-layout>
