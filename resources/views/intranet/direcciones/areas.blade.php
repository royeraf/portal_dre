<!-- filepath: c:\Users\liliana\Desktop\Sistemas DRE\drehco\resources\views\intranet\direcciones\areas.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2><i class="fas fa-list"></i> {{ $direccion->nombre }}
        <small class="mg-b-0">Gestión de Áreas</small></h2>
    </x-slot>
    
    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('admin.direcciones') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Direcciones
            </a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalNuevaArea">
                <i class="fas fa-plus"></i> Nueva Área
            </button>
            @if($direccion->areasMenu->count() > 0)
            <a href="{{ route('direcciones.show', $direccion->slug) }}" class="btn btn-info" target="_blank">
                <i class="fas fa-eye"></i> Ver Página Pública
            </a>
            @endif
        </div>
    </div>

    @if($direccion->areasMenu->count() > 0)
    <div class="row">
        <div class="col">
            <table class="table table-hover small">
                <thead class="thead-light">
                    <tr>
                        <th class="border border-slate-500">Orden</th>
                        <th class="border border-slate-500">Nombre del Área</th>
                        <th class="border border-slate-500">Estado</th>
                        <th class="border border-slate-500">Recursos</th>
                        <th class="border border-slate-500">Fecha Creación</th>
                        <th class="border border-slate-500">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($direccion->areasMenu->sortBy('orden') as $area)
                <tr>
                    <td class="border border-slate-500">
                        <span class="badge badge-secondary">{{ $area->orden }}</span>
                    </td>
                    <td class="border border-slate-500">
                        <strong>{{ $area->nombre }}</strong>
                        @if($area->descripcion)
                        <br><small class="text-muted">{{ \Str::limit($area->descripcion, 80) }}</small>
                        @endif
                    </td>
                    <td class="border border-slate-500">
                        <span class="badge {{ $area->activo ? 'badge-success' : 'badge-danger' }}">
                            {{ $area->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="border border-slate-500">
                        <div class="d-flex gap-1">
                            @if($area->imagen_funcionario) 
                                <span class="badge badge-info" title="Imagen Funcionario"><i class="fas fa-user"></i></span>
                            @endif
                            @if($area->imagen_organigrama) 
                                <span class="badge badge-warning" title="Organigrama"><i class="fas fa-sitemap"></i></span>
                            @endif
                            @if($area->link_descarga_1) 
                                <span class="badge badge-primary" title="Descarga 1"><i class="fas fa-download"></i></span>
                            @endif
                            @if($area->link_descarga_2) 
                                <span class="badge badge-primary" title="Descarga 2"><i class="fas fa-download"></i></span>
                            @endif
                        </div>
                    </td>
                    <td class="border border-slate-500">{{ $area->created_at->format('d/m/Y H:i') }}</td>
                    <td class="border border-slate-500">
                        <div class="btn-group" role="group">
                            <button type="button" 
                                    class="btn btn-danger btn-sm" 
                                    onclick="eliminarArea({{ $area->id }})" 
                                    title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-warning" 
                                    onclick="abrirModalEditar(
                                        {{ $area->id }}, 
                                        '{{ addslashes($area->nombre) }}', 
                                        '{{ addslashes($area->descripcion) }}', 
                                        {{ $area->orden ?? 0 }}, 
                                        '{{ addslashes($area->texto_descarga_1 ?? '') }}', 
                                        '{{ addslashes($area->link_descarga_1 ?? '') }}', 
                                        '{{ addslashes($area->texto_descarga_2 ?? '') }}', 
                                        '{{ addslashes($area->link_descarga_2 ?? '') }}', 
                                        {{ $area->activo ? 1 : 0 }}, 
                                        '{{ $area->imagen_funcionario ? url($area->imagen_funcionario) : '' }}', 
                                        '{{ $area->imagen_organigrama ? url($area->imagen_organigrama) : '' }}'
                                    )">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <a href="{{ route('direcciones.area', [$direccion->slug, $area->slug]) }}" 
                               class="btn btn-info btn-sm" 
                               title="Ver" 
                               target="_blank">
                                <i class="fa fa-eye"></i>
                            </a>
                            
                            <!-- ⭐ NUEVO BOTÓN PARA EVENTOS -->
                            <a href="{{ route('admin.areas.eventos', $area) }}" 
                               class="btn btn-success btn-sm" 
                               title="Gestionar Eventos">
                                <i class="fas fa-calendar-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="alert alert-warning" role="alert">
        <i class="fas fa-exclamation-triangle"></i> 
        Esta dirección aún no tiene áreas configuradas. Haz clic en "Nueva Área" para comenzar.
    </div>
    @endif

    <!-- Modal Nueva Área -->
    <div class="modal fade" id="modalNuevaArea" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Área - {{ $direccion->nombre }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.areas.store', $direccion->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nombre">Nombre del Área: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nombre" required placeholder="Ej: Área de Supervisión y Monitoreo">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="orden">Orden de Visualización:</label>
                                    <input type="number" class="form-control" name="orden" value="{{ $direccion->areasMenu->count() + 1 }}" min="1">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="descripcion">Descripción del Área: <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="descripcion" rows="4" required placeholder="Describe las funciones y responsabilidades de esta área..."></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="imagen_funcionario">Imagen del Funcionario a Cargo:</label>
                                    <input type="file" class="form-control-file" name="imagen_funcionario" accept="image/*">
                                    <small class="form-text text-muted">Formatos: JPG, PNG, GIF. Máximo 2MB</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="imagen_organigrama">Imagen del Organigrama:</label>
                                    <input type="file" class="form-control-file" name="imagen_organigrama" accept="image/*">
                                    <small class="form-text text-muted">Formatos: JPG, PNG, GIF. Máximo 2MB</small>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        <h6><i class="fas fa-download"></i> Enlaces de Descarga</h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="texto_descarga_1">Texto para Descarga 1:</label>
                                    <input type="text" class="form-control" name="texto_descarga_1" placeholder="Ej: Manual de Procedimientos">
                                </div>
                                <div class="form-group">
                                    <label for="link_descarga_1">Enlace de Descarga 1:</label>
                                    <input type="url" class="form-control" name="link_descarga_1" placeholder="https://...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="texto_descarga_2">Texto para Descarga 2:</label>
                                    <input type="text" class="form-control" name="texto_descarga_2" placeholder="Ej: Reglamento Interno">
                                </div>
                                <div class="form-group">
                                    <label for="link_descarga_2">Enlace de Descarga 2:</label>
                                    <input type="url" class="form-control" name="link_descarga_2" placeholder="https://...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Área
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Área -->
    <div class="modal fade" id="editAreaModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit"></i> Editar Área: <span id="areaNombre"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editAreaForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="edit_nombre">Nombre del Área: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_orden">Orden:</label>
                                    <input type="number" class="form-control" id="edit_orden" name="orden" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_descripcion">Descripción: <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_descripcion" name="descripcion" rows="4" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_imagen_funcionario">Imagen del Funcionario:</label>
                                    <input type="file" class="form-control-file" id="edit_imagen_funcionario" name="imagen_funcionario" accept="image/*">
                                    <small class="form-text text-muted">Formatos: JPG, PNG, GIF. Máximo 2MB.</small>
                                    <div id="current_funcionario_image" class="mt-2"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_imagen_organigrama">Imagen del Organigrama:</label>
                                    <input type="file" class="form-control-file" id="edit_imagen_organigrama" name="imagen_organigrama" accept="image/*">
                                    <small class="form-text text-muted">Formatos: JPG, PNG, GIF. Máximo 2MB.</small>
                                    <div id="current_organigrama_image" class="mt-2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_texto_descarga_1">Texto Descarga 1:</label>
                                    <input type="text" class="form-control" id="edit_texto_descarga_1" name="texto_descarga_1" placeholder="Ej: Manual de Funciones">
                                </div>
                                <div class="form-group">
                                    <label for="edit_link_descarga_1">Link Descarga 1:</label>
                                    <input type="url" class="form-control" id="edit_link_descarga_1" name="link_descarga_1" placeholder="https://ejemplo.com/documento1.pdf">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_texto_descarga_2">Texto Descarga 2:</label>
                                    <input type="text" class="form-control" id="edit_texto_descarga_2" name="texto_descarga_2" placeholder="Ej: Organigrama Funcional">
                                </div>
                                <div class="form-group">
                                    <label for="edit_link_descarga_2">Link Descarga 2:</label>
                                    <input type="url" class="form-control" id="edit_link_descarga_2" name="link_descarga_2" placeholder="https://ejemplo.com/documento2.pdf">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_activo">Estado:</label>
                            <select class="form-control" id="edit_activo" name="activo" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Actualizar Área
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function abrirModalEditar(areaId, areaNombre, areaDescripcion, areaOrden, areaTextoDescarga1, areaLinkDescarga1, areaTextoDescarga2, areaLinkDescarga2, areaActivo, areaImagenFuncionario, areaImagenOrganigrama) {
    // Configurar el modal
    document.getElementById('areaNombre').textContent = areaNombre;
    document.getElementById('editAreaForm').action = '/admin/areas-menu/' + areaId;
    
    // Llenar los campos
    document.getElementById('edit_nombre').value = areaNombre;
    document.getElementById('edit_descripcion').value = areaDescripcion;
    document.getElementById('edit_orden').value = areaOrden || '';
    document.getElementById('edit_texto_descarga_1').value = areaTextoDescarga1 || '';
    document.getElementById('edit_link_descarga_1').value = areaLinkDescarga1 || '';
    document.getElementById('edit_texto_descarga_2').value = areaTextoDescarga2 || '';
    document.getElementById('edit_link_descarga_2').value = areaLinkDescarga2 || '';
    document.getElementById('edit_activo').value = areaActivo;
    
    // Mostrar imágenes actuales si existen
    const funcionarioContainer = document.getElementById('current_funcionario_image');
    const organigramaContainer = document.getElementById('current_organigrama_image');
    
    funcionarioContainer.innerHTML = '';
    organigramaContainer.innerHTML = '';
    
    if (areaImagenFuncionario) {
        funcionarioContainer.innerHTML = `
            <div class="current-image">
                <small class="text-muted">Imagen actual:</small><br>
                <img src="${areaImagenFuncionario}" alt="Funcionario actual" style="max-height: 80px; max-width: 100%;" class="img-thumbnail">
            </div>
        `;
    }
    
    if (areaImagenOrganigrama) {
        organigramaContainer.innerHTML = `
            <div class="current-image">
                <small class="text-muted">Imagen actual:</small><br>
                <img src="${areaImagenOrganigrama}" alt="Organigrama actual" style="max-height: 80px; max-width: 100%;" class="img-thumbnail">
            </div>
        `;
    }
    
    // Mostrar el modal
    $('#editAreaModal').modal('show');
}

function eliminarArea(areaId) {
    if (confirm('¿Está seguro de eliminar esta área? Esta acción no se puede deshacer.')) {
        fetch(`/admin/areas-menu/${areaId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Error al eliminar el área');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar el área');
        });
    }
}

// Mostrar mensajes de éxito/error
@if(session('success'))
    $(document).ready(function() {
        alert('{{ session('success') }}');
    });
@endif

@if(session('error'))
    $(document).ready(function() {
        alert('{{ session('error') }}');
    });
@endif
</script>