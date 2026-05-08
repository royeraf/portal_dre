@extends('principal.plantilla')
@section('title', 'Galería de Infraestructura — DRE Huánuco')
@section('content')

{{-- ── BREADCRUMB HERO ──────────────────────────────────────── --}}
<div class="relative h-36 sm:h-52 bg-cover bg-center overflow-hidden"
     style="background-image: url('{{ asset('img/bc.jpeg') }}')">
    <div class="absolute inset-0 bg-dre-dark/80"></div>
    <div class="relative h-full max-w-screen-xl mx-auto px-4 md:px-8 flex flex-col justify-center">
        <h1 class="font-display text-white text-3xl sm:text-4xl font-extrabold uppercase tracking-widest drop-shadow-lg">
            Galería de Infraestructura
        </h1>
        <nav class="flex items-center gap-1.5 text-xs text-white/60 mt-2">
            <a href="/" class="hover:text-yellow-400 transition-colors">Home</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <a href="{{ route('infraestructuraall') }}" class="hover:text-yellow-400 transition-colors">Área de Infraestructura</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white/90">Galería</span>
        </nav>
    </div>
</div>

{{-- ── CONTENIDO ─────────────────────────────────────────────── --}}
<section class="py-10 bg-gray-50 min-h-screen"
         x-data="{ modal: false, current: '' }">

    <div class="max-w-screen-xl mx-auto px-4 md:px-8">

        {{-- ── ENCABEZADO ─────────────────────────────────────── --}}
        <div class="flex items-center gap-3 mb-8">
            <div class="w-12 h-12 rounded-xl bg-dre-primary flex items-center justify-center shrink-0 shadow-md">
                <i data-lucide="images" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-dre-accent uppercase tracking-[0.2em]">Dirección de Gestión Institucional</p>
                <h2 class="font-display font-extrabold text-dre-dark text-xl sm:text-2xl leading-tight">
                    Galería — Área de Infraestructura
                </h2>
            </div>
            <div class="ml-auto hidden sm:flex items-center gap-2">
                <a href="{{ route('infraestructuraall') }}"
                   class="inline-flex items-center gap-1.5 text-xs font-bold text-dre-primary
                          border border-dre-primary/30 px-3 py-1.5 rounded-lg
                          hover:bg-dre-primary hover:text-white hover:border-dre-primary transition-all duration-200">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5 shrink-0"></i>
                    Volver
                </a>
            </div>
        </div>

        {{-- ── GRID DE IMÁGENES ────────────────────────────────── --}}
        @if(count($registros) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($registros as $row)
            <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm
                        hover:shadow-xl hover:-translate-y-1.5
                        transition-all duration-300 overflow-hidden flex flex-col">

                {{-- Imagen --}}
                <div class="relative overflow-hidden aspect-[4/3] shrink-0 bg-gray-100">
                    <img src="{{ asset('img/infraestructura/'.$row->imagen) }}"
                         alt="Infraestructura DRE Huánuco"
                         loading="lazy"
                         class="w-full h-full object-cover
                                group-hover:scale-105 transition-transform duration-500 ease-out"
                         onerror="this.parentElement.classList.add('bg-gray-200')">

                    {{-- Degradado inferior --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>

                    {{-- Badge Nuevo --}}
                    @if(\Carbon\Carbon::parse($row->created_at)->gte(now()->subDays(5)))
                    <span class="absolute top-2 left-2 bg-green-500 text-white
                                 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">
                        Nuevo
                    </span>
                    @endif

                    {{-- Fecha --}}
                    <span class="absolute bottom-2 left-2 bg-yellow-400 text-black
                                 text-[10px] font-mono font-bold px-2 py-0.5 rounded">
                        {{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}
                    </span>
                </div>

                {{-- Footer del card --}}
                <div class="p-4 flex items-center justify-between mt-auto">
                    <div class="flex items-center gap-2">
                        <span class="w-[3px] h-4 bg-dre-primary rounded-full shrink-0"></span>
                        <span class="text-xs font-bold text-gray-600">Infraestructura</span>
                    </div>
                    <button @click="modal = true; current = '{{ asset('img/infraestructura/'.$row->imagen) }}'"
                            class="inline-flex items-center gap-1.5 bg-dre-primary text-white
                                   text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm
                                   hover:bg-dre-accent transition-all duration-200">
                        <i data-lucide="expand" class="w-3.5 h-3.5 shrink-0"></i>
                        Ver imagen
                    </button>
                </div>

            </div>
            @endforeach
        </div>

        {{-- ── PAGINACIÓN ──────────────────────────────────────── --}}
        @if($registros->hasPages())
        <div class="mt-2 mb-6">
            {{ $registros->links('pagination::tailwind') }}
        </div>
        @endif

        @else
        <div class="flex flex-col items-center justify-center py-20 text-gray-400">
            <i data-lucide="image-off" class="w-12 h-12 mb-3 opacity-40"></i>
            <p class="text-sm font-semibold">No hay imágenes disponibles</p>
        </div>
        @endif

    </div>

    {{-- ── LIGHTBOX MODAL ──────────────────────────────────────── --}}
    <div x-show="modal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="modal = false"
         @keydown.escape.window="modal = false"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 backdrop-blur-sm p-4"
         style="display: none;">

        {{-- Cerrar --}}
        <button @click="modal = false"
                class="absolute top-4 right-4 z-10 w-10 h-10 rounded-full
                       bg-white/10 border border-white/20 text-white
                       flex items-center justify-center
                       hover:bg-white/25 transition-colors duration-200">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        {{-- Imagen --}}
        <div class="relative w-full max-w-5xl rounded-xl overflow-hidden shadow-2xl">
            <img :src="current"
                 alt="Infraestructura DRE Huánuco"
                 class="w-full max-h-[85vh] object-contain bg-black">
        </div>

    </div>

</section>

@endsection
