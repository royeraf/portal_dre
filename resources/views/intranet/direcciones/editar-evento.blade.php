<!-- filepath: c:\Users\liliana\Desktop\Sistemas DRE\drehco\resources\views\intranet\direcciones\editar-evento.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2><i class="fas fa-edit"></i> Editar Evento - {{ $evento->titulo }}</h2>
    </x-slot>
    
    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('admin.areas.eventos', $evento->area) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Eventos
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-calendar-edit"></i> Información del Evento</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.eventos.update', $evento) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Título del Evento: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="titulo" value="{{ old('titulo', $evento->titulo) }}" required>
                            @error('titulo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Orden:</label>
                            <input type="number" class="form-control" name="orden" value="{{ old('orden', $evento->orden) }}">
                            @error('orden')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Descripción: <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="descripcion" rows="4" required>{{ old('descripcion', $evento->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Enlaces con descripciones -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6><i class="fas fa-link"></i> Enlaces del Evento</h6>
                    </div>
                    <div class="card-body">
                        @for($i = 1; $i <= 5; $i++)
                        <div class="form-row mb-3">
                            <div class="col-md-6">
                                <label>Enlace {{ $i }}:</label>
                                <input type="url" 
                                       class="form-control" 
                                       name="enlace_{{ $i }}" 
                                       value="{{ old('enlace_' . $i, $evento->{'enlace_' . $i}) }}"
                                       placeholder="https://...">
                                @error('enlace_' . $i)
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>Descripción Enlace {{ $i }}:</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="descripcion_enlace_{{ $i }}" 
                                       value="{{ old('descripcion_enlace_' . $i, $evento->{'descripcion_enlace_' . $i}) }}"
                                       placeholder="Descripción del enlace">
                                @error('descripcion_enlace_' . $i)
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Enlace Externo Principal:</label>
                    <input type="url" class="form-control" name="enlace_externo" value="{{ old('enlace_externo', $evento->enlace_externo) }}" placeholder="https://...">
                    <small class="form-text text-muted">Este enlace aparecerá como botón principal "Ver más"</small>
                    @error('enlace_externo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Estado:</label>
                    <select class="form-control" name="activo">
                        <option value="1" {{ old('activo', $evento->activo) ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ !old('activo', $evento->activo) ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('activo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Actualizar Evento
                    </button>
                    <a href="{{ route('admin.areas.eventos', $evento->area) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>