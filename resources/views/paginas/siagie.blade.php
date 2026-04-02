@extends('principal.plantilla')

@section('content')

{{-- ── HERO ──────────────────────────────────────────────────── --}}
<div class="bg-dre-primary relative overflow-hidden">
    {{-- Patrón decorativo --}}
    <div class="absolute inset-0 opacity-5"
         style="background-image: repeating-linear-gradient(45deg, #fff 0, #fff 1px, transparent 0, transparent 50%); background-size: 20px 20px;"></div>
    <div class="relative max-w-screen-xl mx-auto px-4 py-10 md:py-14">
        <div class="flex items-center gap-3 mb-3">
            <span class="flex items-center justify-center bg-white/10 rounded-lg p-2">
                <i data-lucide="pie-chart" class="w-6 h-6 text-yellow-400"></i>
            </span>
            <span class="text-yellow-400 text-xs font-bold uppercase tracking-widest">Sistema de Información</span>
        </div>
        <h1 class="text-white font-black text-3xl md:text-4xl leading-tight mb-2">
            Reportes SIAGIE
        </h1>
        <p class="text-blue-200 text-sm md:text-base max-w-xl">
            Consulta los reportes estadísticos del Sistema de Información de Apoyo a la Gestión de la Institución Educativa.
        </p>
    </div>
</div>

{{-- ── CONTENIDO ────────────────────────────────────────────── --}}
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 py-8">

        @if($reports->count() > 0)

            {{-- Buscador --}}
            <div class="max-w-xl mx-auto mb-8">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                    <input type="text"
                           id="searchReports"
                           placeholder="Buscar reportes por título o descripción…"
                           class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-xl shadow-sm text-sm
                                  focus:outline-none focus:ring-2 focus:ring-dre-accent focus:border-transparent
                                  placeholder:text-gray-400 transition">
                </div>
            </div>

            {{-- Contador --}}
            <p class="text-xs text-gray-400 text-center mb-6">
                <span id="visibleCount">{{ $reports->count() }}</span> reporte(s) disponibles
            </p>

            {{-- Grid de reportes --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" id="reportsGrid">
                @foreach($reports as $i => $report)
                    <div class="report-card group bg-white rounded-xl border border-gray-100 shadow-sm
                                hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden"
                         data-title="{{ strtolower($report->title) }}"
                         data-description="{{ strtolower($report->description ?? '') }}">

                        {{-- Barra superior de color --}}
                        <div class="h-1 bg-dre-accent w-full"></div>

                        <div class="flex flex-col flex-1 p-5">
                            {{-- Categoría --}}
                            @if($report->description)
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-widest text-dre-accent mb-2">
                                    <i data-lucide="tag" class="w-3 h-3"></i>
                                    {{ $report->description }}
                                </span>
                            @endif

                            {{-- Título --}}
                            <h3 class="text-gray-800 font-semibold text-sm leading-snug mb-4 flex-1">
                                {{ $report->title }}
                            </h3>

                            {{-- Fecha --}}
                            <div class="flex items-center gap-1.5 text-gray-400 text-xs mb-4">
                                <i data-lucide="calendar" class="w-3.5 h-3.5 shrink-0"></i>
                                <span>
                                    {{ ($report->published_at ?? $report->created_at)->format('d/m/Y') }}
                                </span>
                            </div>

                            {{-- CTA --}}
                            <a href="{{ route('siagie.show', $report->slug) }}"
                               class="flex items-center justify-center gap-2 w-full
                                      bg-dre-primary hover:bg-dre-accent text-white
                                      text-xs font-bold uppercase tracking-wide
                                      py-2.5 rounded-lg transition-colors">
                                <i data-lucide="eye" class="w-3.5 h-3.5 shrink-0"></i>
                                Ver Reporte
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Sin resultados --}}
            <div id="noResults" class="hidden text-center py-16">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                    <i data-lucide="search-x" class="w-8 h-8 text-gray-400"></i>
                </div>
                <h4 class="text-gray-600 font-semibold mb-1">Sin resultados</h4>
                <p class="text-gray-400 text-sm">Prueba con otros términos de búsqueda</p>
            </div>

        @else

            {{-- Estado vacío --}}
            <div class="max-w-sm mx-auto text-center py-20">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-dre-primary/5 rounded-2xl mb-5">
                    <i data-lucide="folder-open" class="w-10 h-10 text-dre-primary/40"></i>
                </div>
                <h3 class="text-gray-700 font-bold text-lg mb-2">No hay reportes publicados</h3>
                <p class="text-gray-400 text-sm">Los reportes estarán disponibles próximamente.</p>
            </div>

        @endif

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input       = document.getElementById('searchReports');
    const cards       = document.querySelectorAll('.report-card');
    const noResults   = document.getElementById('noResults');
    const countEl     = document.getElementById('visibleCount');

    if (!input) return;

    input.addEventListener('input', function () {
        const term = this.value.toLowerCase().trim();
        let visible = 0;

        cards.forEach(card => {
            const matches = card.dataset.title.includes(term) || card.dataset.description.includes(term);
            card.style.display = matches ? '' : 'none';
            if (matches) visible++;
        });

        if (countEl) countEl.textContent = visible;
        if (noResults) noResults.classList.toggle('hidden', visible > 0);
    });
});
</script>
@endpush

@endsection
