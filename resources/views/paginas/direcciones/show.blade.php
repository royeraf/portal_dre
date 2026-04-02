@extends('principal.plantilla')
@section('title', $direccion->nombre . ' — DRE Huánuco')

@section('content')
@php
    $todosLosEventos = collect();
    foreach($direccion->areasMenu as $area) {
        if($area->eventos) {
            foreach($area->eventos as $evento) {
                $todosLosEventos->push($evento);
            }
        }
    }
    $eventosChunks = $todosLosEventos->chunk(3);
@endphp

{{-- ── HERO / BREADCRUMB ─────────────────────────────────────── --}}
<div class="relative h-36 sm:h-52 bg-cover bg-center overflow-hidden"
     style="background-image: url('{{ asset('img/bc.jpeg') }}')">
    <div class="absolute inset-0 bg-dre-dark/80"></div>
    <div class="relative h-full max-w-screen-xl mx-auto px-4 md:px-8 flex flex-col justify-center">
        <h1 class="font-display text-white text-3xl sm:text-4xl font-extrabold uppercase tracking-widest drop-shadow-lg">
            {{ $direccion->nombre }}
        </h1>
        <nav class="flex items-center gap-1.5 text-xs text-white/60 mt-2">
            <a href="/" class="hover:text-yellow-400 transition-colors">Inicio</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white/90">{{ $direccion->nombre }}</span>
        </nav>
    </div>
</div>

{{-- ── LAYOUT PRINCIPAL ──────────────────────────────────────── --}}
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-6">

            {{-- ── SIDEBAR ──────────────────────────────────────── --}}
            <aside class="lg:w-72 shrink-0">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden lg:sticky lg:top-6">

                    {{-- Cabecera sidebar --}}
                    <div class="bg-dre-primary px-4 py-3 flex items-center gap-2">
                        <i data-lucide="layers" class="w-4 h-4 text-yellow-400 shrink-0"></i>
                        <span class="text-white font-semibold text-sm uppercase tracking-wide">Áreas Organizacionales</span>
                    </div>

                    {{-- Nav de áreas --}}
                    <nav class="max-h-[420px] overflow-y-auto divide-y divide-gray-50">
                        @if($direccion->areasMenu && $direccion->areasMenu->count() > 0)
                            @foreach($direccion->areasMenu as $area)
                                <a href="/menus/paginaweb/{{ $direccion->idpagina }}?area={{ $area->slug }}"
                                   class="flex items-start gap-3 px-4 py-3 transition-all hover:bg-dre-50 group
                                          border-l-[3px] {{ $area_actual && $area_actual->id === $area->id
                                              ? 'border-dre-accent bg-dre-50'
                                              : 'border-transparent' }}">
                                    <i data-lucide="chevron-right"
                                       class="w-3.5 h-3.5 mt-0.5 shrink-0 transition-colors
                                              {{ $area_actual && $area_actual->id === $area->id
                                                  ? 'text-dre-accent'
                                                  : 'text-gray-300 group-hover:text-dre-accent' }}"></i>
                                    <span class="flex flex-col min-w-0">
                                        <span class="text-sm font-medium leading-snug
                                                     {{ $area_actual && $area_actual->id === $area->id
                                                         ? 'text-dre-primary'
                                                         : 'text-gray-700 group-hover:text-dre-primary' }}">
                                            {{ $area->nombre }}
                                        </span>
                                        @if($area->descripcion)
                                            <span class="text-[11px] text-gray-400 mt-0.5 leading-snug">
                                                {{ Str::limit($area->descripcion, 55) }}
                                            </span>
                                        @endif
                                    </span>
                                </a>
                            @endforeach
                        @else
                            <div class="px-4 py-8 text-center text-gray-400">
                                <i data-lucide="info" class="w-6 h-6 mx-auto mb-2 opacity-50"></i>
                                <p class="text-sm">No hay áreas configuradas</p>
                            </div>
                        @endif
                    </nav>
                </div>
            </aside>

            {{-- ── CONTENIDO PRINCIPAL ──────────────────────────── --}}
            <main class="flex-1 min-w-0">

                @if($area_actual)
                {{-- ── VISTA DE ÁREA ESPECÍFICA ─────────────────── --}}

                    {{-- Cabecera del área --}}
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-5">
                        <div class="px-6 py-5 border-b border-gray-100 flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-bold text-gray-800 leading-tight">{{ $area_actual->nombre }}</h2>
                                <p class="text-xs text-gray-400 mt-1 uppercase tracking-wide">{{ $direccion->nombre }}</p>
                            </div>
                            <span class="shrink-0 inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-full
                                         {{ $area_actual->activo ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $area_actual->activo ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                {{ $area_actual->activo ? 'Operativo' : 'Inactivo' }}
                            </span>
                        </div>

                        @if($area_actual->descripcion)
                            <div class="px-6 py-4 bg-dre-50/40 border-b border-gray-100">
                                <p class="text-sm text-gray-600 leading-relaxed">{!! nl2br(e($area_actual->descripcion)) !!}</p>
                            </div>
                        @endif
                    </div>

                    {{-- Imágenes --}}
                    @if($area_actual->imagen_funcionario || $area_actual->imagen_organigrama)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                            @if($area_actual->imagen_funcionario)
                                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                                    <div class="flex items-center gap-2 mb-3">
                                        <i data-lucide="user" class="w-4 h-4 text-dre-accent"></i>
                                        <h3 class="text-sm font-semibold text-gray-700">Responsable del Área</h3>
                                    </div>
                                    <img src="{{ url($area_actual->imagen_funcionario) }}"
                                         alt="Funcionario a cargo"
                                         class="w-full h-48 object-cover rounded-lg"
                                         onerror="this.src='{{ url('img/default/no-image.png') }}'">
                                </div>
                            @endif

                            @if($area_actual->imagen_organigrama)
                                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                                    <div class="flex items-center gap-2 mb-3">
                                        <i data-lucide="network" class="w-4 h-4 text-dre-accent"></i>
                                        <h3 class="text-sm font-semibold text-gray-700">Estructura Organizacional</h3>
                                    </div>
                                    <img src="{{ url($area_actual->imagen_organigrama) }}"
                                         alt="Organigrama"
                                         class="w-full h-48 object-cover rounded-lg cursor-pointer hover:opacity-90 transition-opacity"
                                         onclick="openModal(this.src)"
                                         onerror="this.src='{{ url('img/default/no-image.png') }}'">
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Documentos descargables --}}
                    @if($area_actual->link_descarga_1 || $area_actual->link_descarga_2)
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mb-5">
                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="download" class="w-4 h-4 text-dre-accent"></i>
                                <h3 class="text-sm font-semibold text-gray-700">Documentos del Área</h3>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @if($area_actual->link_descarga_1)
                                    <div class="flex items-center justify-between gap-3 border border-gray-100 rounded-lg p-3">
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-gray-700 truncate">{{ $area_actual->texto_descarga_1 ?: 'Documento 1' }}</p>
                                            <p class="text-xs text-gray-400">Documento oficial</p>
                                        </div>
                                        <a href="{{ $area_actual->link_descarga_1 }}" target="_blank"
                                           class="shrink-0 flex items-center gap-1.5 bg-dre-primary hover:bg-dre-accent text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                            <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                            Descargar
                                        </a>
                                    </div>
                                @endif
                                @if($area_actual->link_descarga_2)
                                    <div class="flex items-center justify-between gap-3 border border-gray-100 rounded-lg p-3">
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-gray-700 truncate">{{ $area_actual->texto_descarga_2 ?: 'Documento 2' }}</p>
                                            <p class="text-xs text-gray-400">Documento oficial</p>
                                        </div>
                                        <a href="{{ $area_actual->link_descarga_2 }}" target="_blank"
                                           class="shrink-0 flex items-center gap-1.5 bg-dre-primary hover:bg-dre-accent text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                            <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                            Descargar
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Eventos del área --}}
                    @php
                        $eventosArea   = $area_actual->eventos ?? collect();
                        $eventosChunks = $eventosArea->chunk(3);
                    @endphp
                    @if($eventosArea->count() > 0)
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                            <div class="text-center mb-5">
                                <h3 class="text-base font-bold text-gray-800">Eventos y Actividades</h3>
                                <p class="text-xs text-gray-400 mt-0.5">Últimas actividades del {{ $area_actual->nombre }}</p>
                            </div>
                            @include('paginas.direcciones._eventos_carousel', [
                                'chunks'   => $eventosChunks,
                                'trackId'  => 'eventsCarouselTrack',
                                'dotsId'   => 'eventsCarouselDots',
                            ])
                        </div>
                    @endif

                @else
                {{-- ── VISTA PRINCIPAL DE LA DIRECCIÓN ─────────── --}}

                    {{-- Descripción --}}
                    @if($direccion->descripcion)
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mb-5">
                            <div class="flex items-center gap-2 mb-3">
                                <i data-lucide="info" class="w-4 h-4 text-dre-accent"></i>
                                <h3 class="text-sm font-semibold text-gray-700">Acerca de esta Dirección</h3>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $direccion->descripcion }}</p>
                        </div>
                    @endif

                    {{-- Contenido de página --}}
                    @if($direccion->pagina && $direccion->pagina->cont_pagina)
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mb-5 prose prose-sm max-w-none text-gray-600">
                            {!! $direccion->pagina->cont_pagina !!}
                        </div>
                    @endif

                    {{-- Grid de áreas --}}
                    @if($direccion->areasMenu && $direccion->areasMenu->count() > 0)
                        <div class="mb-5">
                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="network" class="w-4 h-4 text-dre-accent"></i>
                                <h3 class="text-base font-bold text-gray-800">Áreas Organizacionales</h3>
                            </div>
                            <p class="text-sm text-gray-400 mb-4">Selecciona un área para ver su información detallada.</p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($direccion->areasMenu as $area)
                                    <a href="/menus/paginaweb/{{ $direccion->idpagina }}?area={{ $area->slug }}"
                                       class="group bg-white rounded-xl border border-gray-100 shadow-sm p-4
                                              hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                                        <div class="flex items-start gap-3 mb-3">
                                            <span class="flex items-center justify-center bg-dre-primary/5 group-hover:bg-dre-primary/10
                                                         rounded-lg p-2 shrink-0 transition-colors">
                                                <i data-lucide="building-2" class="w-5 h-5 text-dre-primary"></i>
                                            </span>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-semibold text-gray-800 leading-snug group-hover:text-dre-primary transition-colors">
                                                    {{ $area->nombre }}
                                                </h4>
                                                <span class="inline-flex items-center gap-1 mt-1 text-[10px] font-medium px-2 py-0.5 rounded-full
                                                             {{ $area->activo ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-400' }}">
                                                    <span class="w-1.5 h-1.5 rounded-full {{ $area->activo ? 'bg-emerald-400' : 'bg-gray-300' }}"></span>
                                                    {{ $area->activo ? 'Operativo' : 'Inactivo' }}
                                                </span>
                                            </div>
                                        </div>

                                        @if($area->descripcion)
                                            <p class="text-xs text-gray-400 leading-relaxed mb-3">{{ Str::limit($area->descripcion, 100) }}</p>
                                        @endif

                                        {{-- Badges de contenido --}}
                                        <div class="flex flex-wrap gap-1.5 pt-3 border-t border-gray-50">
                                            @if($area->imagen_funcionario)
                                                <span class="flex items-center gap-1 text-[10px] font-medium bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full">
                                                    <i data-lucide="user" class="w-3 h-3"></i> Funcionario
                                                </span>
                                            @endif
                                            @if($area->imagen_organigrama)
                                                <span class="flex items-center gap-1 text-[10px] font-medium bg-green-50 text-green-600 px-2 py-0.5 rounded-full">
                                                    <i data-lucide="network" class="w-3 h-3"></i> Organigrama
                                                </span>
                                            @endif
                                            @if($area->eventos && $area->eventos->count() > 0)
                                                <span class="flex items-center gap-1 text-[10px] font-medium bg-amber-50 text-amber-600 px-2 py-0.5 rounded-full">
                                                    <i data-lucide="calendar" class="w-3 h-3"></i> {{ $area->eventos->count() }} eventos
                                                </span>
                                            @endif
                                            @if($area->link_descarga_1 || $area->link_descarga_2)
                                                <span class="flex items-center gap-1 text-[10px] font-medium bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">
                                                    <i data-lucide="download" class="w-3 h-3"></i> Documentos
                                                </span>
                                            @endif
                                        </div>

                                        <div class="flex justify-end mt-2">
                                            <span class="text-xs text-dre-accent font-medium flex items-center gap-1 group-hover:gap-2 transition-all">
                                                Explorar <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-10 text-center mb-5">
                            <i data-lucide="alert-circle" class="w-10 h-10 mx-auto text-amber-400 mb-3"></i>
                            <h4 class="text-sm font-semibold text-gray-700 mb-1">No hay áreas configuradas</h4>
                            <p class="text-xs text-gray-400">Esta dirección aún no tiene áreas organizacionales definidas.</p>
                        </div>
                    @endif

                    {{-- Todos los eventos --}}
                    @if($todosLosEventos->count() > 0)
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                            <div class="text-center mb-5">
                                <h3 class="text-base font-bold text-gray-800">Últimas Actividades</h3>
                                <p class="text-xs text-gray-400 mt-0.5">Eventos recientes de {{ $direccion->nombre }}</p>
                            </div>
                            @include('paginas.direcciones._eventos_carousel', [
                                'chunks'   => $eventosChunks,
                                'trackId'  => 'allEventsCarouselTrack',
                                'dotsId'   => 'allEventsCarouselDots',
                            ])
                        </div>
                    @endif

                @endif
            </main>
        </div>
    </div>
</div>

{{-- ── MODAL ORGANIGRAMA ─────────────────────────────────────── --}}
<div id="imageModal"
     class="fixed inset-0 z-[9995] bg-black/80 hidden items-center justify-center p-4"
     onclick="closeModal()">
    <div class="relative max-w-4xl max-h-full" onclick="event.stopPropagation()">
        <button onclick="closeModal()"
                class="absolute -top-4 -right-4 w-8 h-8 bg-white rounded-full shadow-lg
                       flex items-center justify-center text-gray-700 hover:text-red-600 transition-colors z-10">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        <img id="modalImage" src="" alt="Organigrama"
             class="max-w-full max-h-[85vh] rounded-xl shadow-2xl object-contain">
    </div>
</div>

@push('scripts')
<script>
// ── Modal organigrama ──────────────────────────────────────────
function openModal(src) {
    const modal = document.getElementById('imageModal');
    document.getElementById('modalImage').src = src;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
}
function closeModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

// ── Carousels de eventos ───────────────────────────────────────
document.querySelectorAll('[data-carousel]').forEach(carousel => {
    const track  = carousel.querySelector('[data-track]');
    const dots   = carousel.querySelectorAll('[data-dot]');
    let current  = 0;
    const total  = dots.length;

    function go(n) {
        current = (n + total) % total;
        track.style.transform = `translateX(-${current * 100}%)`;
        dots.forEach((d, i) => {
            d.classList.toggle('bg-dre-accent', i === current);
            d.classList.toggle('scale-125',     i === current);
            d.classList.toggle('bg-gray-200',   i !== current);
        });
    }

    carousel.querySelector('[data-prev]')?.addEventListener('click', () => go(current - 1));
    carousel.querySelector('[data-next]')?.addEventListener('click', () => go(current + 1));
    dots.forEach((d, i) => d.addEventListener('click', () => go(i)));
});
</script>
@endpush

@endsection
