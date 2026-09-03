<x-app-layout>

    <x-slot name="header">
        <h2><i class="far fa-clone"></i> CONVOCATORIAS
    </x-slot>
    <h6 class="br-section-label">Registro</h6>
    <form action="{{ route('archivo.convocatoria.store', $convocatoria) }}" method="POST" enctype="multipart/form-data">
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
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-control-label" for="file">Subir PDF</label>
                    <input type="file" name="file" id="file" class="form-control" accept="application/pdf">
                    <small class="form-text text-muted">Máximo 20 MB. Se sincronizará como borrador para la IA.</small>
                    <x-input-error :messages="$errors->get('file')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-control-label" for="url_archivo">O pegar URL</label>
                    <input type="text" name="url_archivo" id="url_archivo" value="{{ old('url_archivo') }}" class="form-control" placeholder="https://...">
                    <small class="form-text text-muted">Usa archivo o URL; no necesitas completar ambos.</small>
                    <x-input-error :messages="$errors->get('url_archivo')" class="mt-2" />
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
