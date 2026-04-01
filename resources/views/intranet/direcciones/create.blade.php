<!-- filepath: c:\Users\liliana\Desktop\Sistemas DRE\drehco\resources\views\intranet\direcciones\create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2><i class="fas fa-building"></i> Direcciones
        <small class="mg-b-0">Nueva Dirección</small></h2>
    </x-slot>
    
    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('admin.direcciones') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Direcciones
            </a>
        </div>
    </div>

    <h6 class="br-section-label">Nueva Dirección</h6>
    <form action="{{ route('admin.direcciones.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mg-b-25">
            <div class="col-lg-8">
                <div class="form-group">
                    <label class="form-control-label" for="nombre">Nombre de la Dirección: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" placeholder="Ej: Dirección de Gestión Pedagógica" required>
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-control-label" for="activo">Estado: <span class="tx-danger">*</span></label>
                    <select class="form-control" name="activo" id="activo" required>
                        <option value="1" {{ old('activo') == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('activo') == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    <x-input-error :messages="$errors->get('activo')" class="mt-2" />
                </div>
            </div>
        </div>
        
        <div class="row mg-b-25">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-control-label" for="idpagina">ID de Página (Opcional):</label>
                    <input class="form-control" type="number" name="idpagina" id="idpagina" value="{{ old('idpagina') }}" placeholder="Ej: 23">
                    <small class="form-text text-muted">Número de página del sistema de menús para enlazar esta dirección</small>
                    <x-input-error :messages="$errors->get('idpagina')" class="mt-2" />
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-control-label" for="descripcion">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="4" placeholder="Descripción de las funciones y responsabilidades de esta dirección">{{ old('descripcion') }}</textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>
            </div>
        </div>
        <br>
        
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Dirección
                </button>
                <a href="{{ route('admin.direcciones') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </div>
    </form>
</x-app-layout>