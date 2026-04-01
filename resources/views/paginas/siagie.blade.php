@extends('principal.plantilla')

@section('content')
<div class="siagie-header">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center py-5">
                <h1 class="display-4 fw-bold mb-0 text-dark">
                    <i class="fas fa-chart-line me-2 text-primary"></i>Reportes SIAGIE
                </h1>
                </div>
        </div>
    </div>
</div>

<div class="container mt-0 mb-5">
    @if($reports->count() > 0)
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                {{-- Tarjeta de Búsqueda --}}
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                class="form-control border-0 shadow-none" 
                                id="searchReports" 
                                placeholder="Buscar reportes por título o descripción...">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 justify-content-center" id="reportsGrid">
            @foreach($reports as $report)
                <div class="col-lg-4 col-md-6 report-card" 
                    data-title="{{ strtolower($report->title) }}" 
                    data-description="{{ strtolower($report->description ?? '') }}">
                    {{-- Tarjeta de Reporte: borde y estilo minimalista --}}
                    <div class="card h-100 border rounded-0 p-3 report-card-custom">
                        <div class="card-body d-flex flex-column p-0">
                            
                            {{-- Categoría (gris oscuro) --}}
                            <small class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 0.75rem;">
                                {{ $report->description ?? 'REPORTE' }}
                            </small>
                            
                            {{-- Título (negro) --}}
                            <h5 class="card-title text-dark fw-normal mb-4" style="font-size: 1rem;">
                                {{ $report->title }}
                            </h5>

                            {{-- Fecha de Publicación (gris claro) --}}
                            <div class="text-muted mb-1" style="font-size: 0.85rem;">
                                <i class="far fa-calendar-alt me-2"></i>
                                {{ $report->published_at ? $report->published_at->format('d/m/Y') : $report->created_at->format('d/m/Y') }}
                            </div>

                            {{-- Enlace 'Ver Reporte Completo' (APLICANDO TAMAÑO MÁS PEQUEÑO Y COLOR) --}}
                            <div class="mt-auto text-center bg-primary text-white">
                                <a href="{{ route('siagie.show', $report->slug) }}" 
                                    class="text-white text-decoration-none fw-bold link-hover-primary">
                                    <i class="fas fa-eye" style="font-size: 1rem;"></i>
                                    <span class="d-block mt-1" style="font-size: 1rem;">Ver Reporte<br>Completo</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="noResults" class="text-center py-5 d-none">
            <div class="mb-4">
                <i class="fas fa-search fa-4x text-muted opacity-50"></i>
            </div>
            <h4 class="text-muted">No se encontraron reportes</h4>
            <p class="text-muted">Intenta con otros términos de búsqueda</p>
        </div>
    @else
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card border-0 shadow-lg">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-folder-open fa-5x text-muted opacity-50"></i>
                        </div>
                        <h3 class="mb-3">No hay reportes publicados</h3>
                        <p class="text-muted mb-0">Los reportes estarán disponibles próximamente</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    /* 1. Efecto Hover de la Tarjeta */
    .report-card-custom {
        /* Quita la sombra por defecto de Bootstrap y prepara la transición */
        box-shadow: none !important;
        border-color: #ddd; /* Borde inicial gris claro */
        transition: box-shadow 0.2s ease-in-out, border-color 0.2s ease-in-out;
    }
    .report-card-custom:hover {
        /* Sombra sutil y BORDE PRINCIPAL (AZUL) al hacer hover */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05) !important;
        border-color: var(--bs-primary) !important; 
    }

    /* 2. Estilo del Enlace de Ver Reporte */
    .link-hover-primary:hover {
        /* Oscurece ligeramente el color primario al pasar el ratón */
        color: #0056b3 !important; /* Un tono de azul más oscuro */
    }
    .link-hover-primary:hover i {
        color: #0056b3 !important;
    }
    
    /* Ocultar elementos no deseados de la versión original */
    .badge.bg-success {
        display: none !important;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchReports');
    const reportCards = document.querySelectorAll('.report-card');
    const noResults = document.getElementById('noResults');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            let visibleCount = 0;

            reportCards.forEach(card => {
                const title = card.dataset.title;
                const description = card.dataset.description;
                const matches = title.includes(searchTerm) || description.includes(searchTerm);
                
                if (matches) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (noResults) {
                noResults.classList.toggle('d-none', visibleCount > 0);
            }
        });
    }
});
</script>
@endpush
@endsection