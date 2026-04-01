<!-- filepath: c:\Users\liliana\Desktop\Sistemas DRE\drehco\resources\views\intranet\direcciones\contenido.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2><i class="fas fa-edit"></i> Contenido - {{ $direccion->nombre }}
        <small class="mg-b-0">Administrar página web</small></h2>
    </x-slot>
    
    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('admin.direcciones') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Direcciones
            </a>
            <a href="{{ route('admin.direcciones.areas', $direccion->id) }}" class="btn btn-info">
                <i class="fas fa-list"></i> Gestionar Áreas
            </a>
            @if($direccion->pagina)
            <a href="/menus/paginaweb/{{ $direccion->idpagina }}" class="btn btn-success" target="_blank">
                <i class="fas fa-eye"></i> Ver Página Web
            </a>
            @endif
        </div>
    </div>

    <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle"></i> 
        Esta página se muestra en la web a través del menú con ID: {{ $direccion->idpagina }}
        <br><strong>URL:</strong> /menus/paginaweb/{{ $direccion->idpagina }}
    </div>

    <form action="{{ route('admin.direcciones.contenido.update', $direccion->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-lg-8">
                <div class="form-group">
                    <label class="form-control-label" for="nom_pagina">Título de la Página: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="nom_pagina" id="nom_pagina" 
                           value="{{ $direccion->pagina ? $direccion->pagina->nom_pagina : $direccion->nombre }}" 
                           placeholder="Título de la página" required>
                    <x-input-error :messages="$errors->get('nom_pagina')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-control-label">Estado de la Dirección:</label>
                    <br>
                    <span class="badge {{ $direccion->activo ? 'badge-success' : 'badge-danger' }} badge-lg">
                        {{ $direccion->activo ? 'Activa' : 'Inactiva' }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-control-label" for="descripcion">Descripción de la Dirección:</label>
                    <textarea class="form-control" name="descripcion" rows="3" 
                              placeholder="Descripción breve de la dirección">{{ $direccion->descripcion }}</textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <label class="form-control-label" for="cont_pagina">Contenido de la Página: <span class="tx-danger">*</span></label>
                <textarea rows="12" class="form-control mg-t-20" name="cont_pagina" id="mysummernote" required>{{ $direccion->pagina ? $direccion->pagina->cont_pagina : '' }}</textarea>
                <x-input-error :messages="$errors->get('cont_pagina')" class="mt-2" />
            </div>
        </div>
        
        <br>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Contenido
                </button>
                <a href="{{ route('admin.direcciones') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
    </form>

    <hr>
    
    <!-- Estadísticas de áreas -->
    <div class="row mt-4">
        <div class="col">
            <h5><i class="fas fa-chart-bar"></i> Estadísticas de Áreas</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h4>{{ $direccion->areasMenu->count() }}</h4>
                            <p class="mb-0">Total Áreas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h4>{{ $direccion->areasMenu->where('activo', true)->count() }}</h4>
                            <p class="mb-0">Áreas Activas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h4>{{ $direccion->areasMenu->where('imagen_funcionario', '!=', null)->count() }}</h4>
                            <p class="mb-0">Con Funcionarios</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h4>{{ $direccion->areasMenu->where('link_descarga_1', '!=', null)->count() }}</h4>
                            <p class="mb-0">Con Descargas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>