@extends('principal.plantilla')
@section('title', 'Galería Fotográfica | DRE Huánuco')
@section('content')

{{-- ── BREADCRUMB HERO ──────────────────────────────────────── --}}
<div class="relative h-36 sm:h-52 bg-cover bg-center overflow-hidden"
     style="background-image: url('{{ asset('img/bc.jpeg') }}')">
    <div class="absolute inset-0 bg-dre-dark/80"></div>
    <div class="relative h-full max-w-screen-xl mx-auto px-4 md:px-8 flex flex-col justify-center">
        <h1 class="font-display text-white text-3xl sm:text-4xl font-extrabold uppercase tracking-widest drop-shadow-lg">
            Galería Fotográfica
        </h1>
        <nav class="flex items-center gap-1.5 text-xs text-white/60 mt-2">
            <a href="/" class="hover:text-yellow-400 transition-colors">Home</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white/90">Galería</span>
        </nav>
    </div>
</div>

{{-- ── CONTENIDO EDICIONAL ──────────────────────────────────── --}}
<section class="py-16 md:py-24 bg-gray-900 relative">
    <div class="max-w-screen-2xl mx-auto px-4 md:px-8 relative z-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8 hover:gap-8 transition-all">
            @forelse ($registrosgaleria as $index => $item)
                {{-- Efecto de entrada escalonado con Alpine --}}
                <div x-data="{ shown: false }" x-intersect.once="shown = true"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                     style="transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1); transition-delay: {{ ($index % 4) * 120 }}ms; padding-bottom: 20px;">
    
                    <a href="{{ route('portafoliodet', $item) }}" class="group relative flex flex-col w-full overflow-hidden rounded-3xl bg-dre-darker shadow-xl hover:shadow-2xl transition-all duration-500 border border-white/10" style="height: 400px;">
                        
                        {{-- Contenedor de la Imagen principal --}}
                        <div class="absolute inset-0 overflow-hidden">
                            <img src="{{ asset('img/imageneventos/' . $item->img) }}" 
                                 alt="{{ $item->titulo }}" 
                                 class="w-full h-full object-cover transition-transform duration-1000 ease-out group-hover:scale-110 opacity-70 group-hover:opacity-100">
                        </div>
                        
                        {{-- Malla de Gradientes Oscuros que realzan el texto --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent group-hover:via-black/70 transition-colors duration-700 ease-out z-0"></div>

                        {{-- Metadata (Fecha) arriba a la derecha --}}
                        <div class="relative pt-6 px-6 z-10 flex justify-end">
                            @if($item->fecha_publicacion)
                                <div class="bg-black/50 backdrop-blur-md border border-white/20 text-white text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-widest translate-x-4 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-500 ease-out shadow-lg">
                                    {{ $item->fecha_publicacion }}
                                </div>
                            @endif
                        </div>

                        {{-- Contenido Textual --}}
                        <div class="relative mt-auto p-6 lg:p-8 z-10 flex flex-col justify-end pr-20">
                            <h3 class="text-2xl font-display font-extrabold text-white leading-tight mb-2 drop-shadow-lg group-hover:text-yellow-400 transition-colors duration-300 line-clamp-2">
                                {{ $item->titulo }}
                            </h3>
                            
                            <p class="text-gray-300 text-sm font-light leading-relaxed line-clamp-2 drop-shadow-md">
                                {{ $item->descripcion }}
                            </p>

                            {{-- Botón icónico de "Ver Álbum" inferior --}}
                            <div class="absolute bottom-6 sm:bottom-8 right-6 sm:right-8 bg-yellow-400 text-black w-12 h-12 rounded-full flex items-center justify-center opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500 ease-out shadow-xl transform scale-90 group-hover:scale-100 pointer-events-none">
                                <i data-lucide="arrow-up-right" class="w-5 h-5 group-hover:rotate-12 transition-transform"></i>
                            </div>
                        </div>
                        
                        {{-- Animación decorativa de lectura --}}
                        <div class="absolute bottom-0 left-0 h-1 bg-yellow-400 w-0 group-hover:w-full transition-all duration-700 ease-in-out z-20"></div>
                    </a>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 xl:col-span-4 py-32 text-center relative">
                    <div class="inline-flex items-center justify-center w-28 h-28 rounded-full bg-gray-800 mb-8 border border-gray-700 relative z-10 shadow-2xl">
                        <i data-lucide="image" class="w-12 h-12 text-gray-400"></i>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-display font-bold text-white relative z-10">Galería Vacía</h2>
                    <p class="text-gray-400 mt-4 max-w-lg mx-auto text-lg font-light relative z-10">
                        Pronto compartiremos más momentos e iniciativas institucionales en esta sección.
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Paginación Tailwind --}}
        @if ($registrosgaleria->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $registrosgaleria->links() }}
            </div>
        @endif
    </div>
</section>

@endsection