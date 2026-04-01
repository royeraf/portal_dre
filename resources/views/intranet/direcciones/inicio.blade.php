<!-- filepath: c:\Users\liliana\Desktop\Sistemas DRE\drehco\resources\views\intranet\direcciones\inicio.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2><i class="fas fa-building"></i> Direcciones Regionales
        <small class="mg-b-0">Gestión de Direcciones y Páginas Web</small></h2>
    </x-slot>
    
    <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle"></i> 
        Gestiona las direcciones regionales y su contenido web. Cada dirección está asociada a una página del menú principal.
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th class="border border-slate-500">Dirección</th>
                        <th class="border border-slate-500">Página ID</th>
                        <th class="border border-slate-500">Total Áreas</th>
                        <th class="border border-slate-500">Estado</th>
                        <th class="border border-slate-500">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($direcciones as $direccion)
                <tr>
                    <td class="border border-slate-500">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-building"></i>
                            </div>
                            <div>
                                <strong>{{ $direccion->nombre }}</strong>
                                @if($direccion->descripcion)
                                <br><small class="text-muted">{{ \Str::limit($direccion->descripcion, 60) }}</small>
                                @endif
                                @if($direccion->pagina)
                                <br><small class="text-info"><i class="fas fa-link"></i> {{ $direccion->pagina->nom_pagina }}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="border border-slate-500 text-center">
                        <span class="badge badge-info">{{ $direccion->idpagina }}</span>
                        @if($direccion->pagina)
                        <br><small class="text-success">Página configurada</small>
                        @else
                        <br><small class="text-danger">Página no encontrada</small>
                        @endif
                    </td>
                    <td class="border border-slate-500 text-center">
                        <span class="badge badge-secondary badge-lg">{{ $direccion->areasMenu->count() }}</span>
                        <br><small class="text-success">{{ $direccion->areasMenu->where('activo', true)->count() }} activas</small>
                    </td>
                    <td class="border border-slate-500">
                        <span class="badge {{ $direccion->activo ? 'badge-success' : 'badge-danger' }}">
                            {{ $direccion->activo ? 'Activa' : 'Inactiva' }}
                        </span>
                    </td>
                    <td class="border border-slate-500">
                        <div class="btn-group-vertical btn-group-sm" role="group">
                            <a href="{{ route('admin.direcciones.contenido', $direccion->id) }}" 
                               class="btn btn-warning btn-sm" 
                               title="Editar Contenido Web">
                                <i class="fas fa-edit"></i> Contenido Web
                            </a>
                            <a href="{{ route('admin.direcciones.areas', $direccion->id) }}" 
                               class="btn btn-primary btn-sm" 
                               title="Gestionar Áreas">
                                <i class="fas fa-list"></i> Gestionar Áreas
                            </a>
                            @if($direccion->pagina)
                            <a href="/menus/paginaweb/{{ $direccion->idpagina }}" 
                               class="btn btn-info btn-sm" 
                               title="Ver Página Web" 
                               target="_blank">
                                <i class="fa fa-eye"></i> Ver Web
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Estadísticas generales -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $direcciones->sum(function($d) { return $d->areasMenu->count(); }) }}</h4>
                            <p class="mb-0">Total Áreas</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-list fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $direcciones->sum(function($d) { return $d->areasMenu->where('activo', true)->count(); }) }}</h4>
                            <p class="mb-0">Áreas Activas</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $direcciones->where('pagina', '!=', null)->count() }}</h4>
                            <p class="mb-0">Páginas Configuradas</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-globe fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $direcciones->count() }}</h4>
                            <p class="mb-0">Direcciones</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-building fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>