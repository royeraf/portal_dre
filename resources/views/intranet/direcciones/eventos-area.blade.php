<!-- filepath: c:\Users\liliana\Desktop\Sistemas DRE\drehco\resources\views\intranet\direcciones\eventos-area.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2><i class="fas fa-calendar-alt"></i> Eventos - {{ $area->nombre }}</h2>
    </x-slot>
    
    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('admin.direcciones.areas', $area->direccion->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Áreas
            </a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalNuevoEvento">
                <i class="fas fa-plus"></i> Nuevo Evento
            </button>
        </div>
    </div>

    @if($eventos->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Orden</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Enlaces</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eventos as $evento)
                <tr>
                    <td>{{ $evento->orden }}</td>
                    <td><strong>{{ $evento->titulo }}</strong></td>
                    <td>{{ Str::limit($evento->descripcion, 80) }}</td>
                    <td>
                        @if($evento->tiene_enlaces)
                            @foreach($evento->enlaces as $enlace)
                                <span class="badge badge-info mr-1" title="{{ $enlace['descripcion'] }}">
                                    <i class="fas fa-link"></i> {{ $enlace['numero'] }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-muted">Sin enlaces</span>
                        @endif
                        
                        @if($evento->enlace_externo)
                            <span class="badge badge-success">
                                <i class="fas fa-external-link-alt"></i> Ext
                            </span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $evento->activo ? 'badge-success' : 'badge-danger' }}">
                            {{ $evento->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.eventos.edit', $evento) }}" 
                               class="btn btn-sm btn-warning" 
                               title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger" 
                                    onclick="eliminarEvento({{ $evento->id }})"
                                    title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {{ $eventos->links() }}
    @else
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> No hay eventos configurados para esta área.
    </div>
    @endif

    <!-- Modal Nuevo Evento -->
    <div class="modal fade" id="modalNuevoEvento" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Evento - {{ $area->nombre }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.eventos.store', $area) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Título del Evento: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="titulo" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Orden:</label>
                                    <input type="number" class="form-control" name="orden" value="0">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Descripción: <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="descripcion" rows="4" required></textarea>
                        </div>
                        
                        <!-- Enlaces con descripciones -->
                        <div class="card">
                            <div class="card-header">
                                <h6><i class="fas fa-link"></i> Enlaces del Evento</h6>
                            </div>
                            <div class="card-body">
                                @for($i = 1; $i <= 5; $i++)
                                <div class="form-row mb-2">
                                    <div class="col-md-6">
                                        <label>Enlace {{ $i }}:</label>
                                        <input type="url" class="form-control" name="enlace_{{ $i }}" placeholder="https://...">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Descripción Enlace {{ $i }}:</label>
                                        <input type="text" class="form-control" name="descripcion_enlace_{{ $i }}" placeholder="Descripción del enlace">
                                    </div>
                                </div>
                                @endfor
                            </div>
                        </div>
                        
                        <div class="form-group mt-3">
                            <label>Enlace Externo Principal:</label>
                            <input type="url" class="form-control" name="enlace_externo" placeholder="https://...">
                            <small class="form-text text-muted">Este enlace aparecerá como botón principal "Ver más"</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Evento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function eliminarEvento(id) {
    if (confirm('¿Está seguro de eliminar este evento?')) {
        fetch(`/admin/eventos/${id}`, {
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
                alert('Error al eliminar el evento');
            }
        });
    }
}
</script>