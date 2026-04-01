<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel SIAGIE - Reportes Creados
        </h2>
    </x-slot>

    <div class="container-fluid mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>¡Éxito!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error:</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="h5 mb-1">Reportes Creados</h3>
                <p class="text-muted small mb-0">Administra los reportes creados desde la API externa</p>
            </div>
            <a href="{{ route('admin.siagie.reports.create') }}" 
               class="btn btn-primary">
                <i class="fa fa-plus"></i> Crear Nuevo Reporte
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                @if(isset($reports) && $reports->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Título</th>
                                    <th>Fecha Creación</th>
                                    <th>Gráficos</th>
                                    <th>Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $report->title }}</div>
                                            <small class="text-muted">Slug: {{ $report->slug }}</small>
                                        </td>
                                        <td class="text-nowrap">
                                            <small>{{ $report->created_at->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td>
                                            @php
                                                $globalCount = $report->charts()->where('is_global', true)->count();
                                                $specificCount = $report->charts()->where('is_global', false)->count();
                                            @endphp
                                            <div>
                                                <span class="badge bg-success">
                                                    <i class="fa fa-globe"></i> Global: {{ $globalCount }}
                                                </span>
                                                <span class="badge bg-info ms-1">
                                                    <i class="fa fa-chart-line"></i> Específicos: {{ $specificCount }}
                                                </span>
                                            </div>
                                            <small class="text-muted">Total: {{ $report->charts->count() }}</small>
                                        </td>
                                        <td>
                                            @if($report->is_available)
                                                <span class="badge bg-success">
                                                    <i class="fa fa-check-circle"></i> Publicado
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="fa fa-circle"></i> No Publicado
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <!-- Ver -->
                                                <a href="{{ route('siagie.show', $report->slug) }}" 
                                                   target="_blank"
                                                   class="btn btn-outline-primary" 
                                                   title="Ver reporte público">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                <!-- Editar -->
                                                <a href="{{ route('admin.siagie.reports.edit', $report) }}" 
                                                   class="btn btn-outline-secondary" 
                                                   title="Editar">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <!-- Publicar/Despublicar -->
                                                <form method="POST" 
                                                      action="{{ route('admin.siagie.reports.toggle-publish', $report) }}" 
                                                      class="d-inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="btn btn-outline-{{ $report->is_available ? 'warning' : 'success' }}"
                                                            title="{{ $report->is_available ? 'Despublicar' : 'Publicar' }}">
                                                        <i class="fa fa-{{ $report->is_available ? 'eye-slash' : 'eye' }}"></i>
                                                    </button>
                                                </form>

                                                <!-- Eliminar -->
                                                <form method="POST" 
                                                      action="{{ route('admin.siagie.reports.destroy', $report) }}" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('¿Está seguro de eliminar este reporte? Esta acción no se puede deshacer.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-outline-danger" 
                                                            title="Eliminar">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-3">
                        {{ $reports->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fa fa-inbox text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="mb-2">No hay reportes creados</h4>
                        <p class="text-muted mb-4">Comienza creando tu primer reporte desde la API externa</p>
                        <a href="{{ route('admin.siagie.reports.create') }}" 
                           class="btn btn-primary">
                            <i class="fa fa-plus"></i> Crear Primer Reporte
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @endpush
</x-app-layout>