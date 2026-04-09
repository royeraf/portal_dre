@extends('principal.plantilla')
@section('title', $galeria->titulo . ' — DRE Huánuco')
@section('content')

{{-- ── BREADCRUMB ──────────────────────────────────────────── --}}
<div class="bg-dre-darker border-b border-white/10">
    <div class="max-w-screen-xl mx-auto px-4 md:px-12 py-3 flex items-center gap-2 text-xs text-white/50">
        <a href="{{ url('/') }}" class="hover:text-yellow-400 transition-colors">Inicio</a>
        <i data-lucide="chevron-right" class="w-3 h-3"></i>
        <a href="{{ route('galerias') }}" class="hover:text-yellow-400 transition-colors">Galería</a>
        <i data-lucide="chevron-right" class="w-3 h-3"></i>
        <span class="text-white/80 truncate max-w-[200px]">{{ $galeria->titulo }}</span>
    </div>
</div>

{{-- ── GALERÍA DETALLE ─────────────────────────────────────── --}}
<section class="bg-white min-h-screen"
         x-data="{
             current: 0,
             total: {{ count($imagenes) }},
             prev() { this.current = (this.current - 1 + this.total) % this.total; this.scrollThumb(); },
             next() { this.current = (this.current + 1) % this.total; this.scrollThumb(); },
             scrollThumb() {
                 this.$nextTick(() => {
                     const strip = this.$refs.thumbs;
                     if (!strip) return;
                     const thumb = strip.children[this.current];
                     if (!thumb) return;
                     thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                 });
             }
         }">

    <div class="max-w-screen-xl mx-auto px-4 md:px-12 py-8">

        {{-- Badge + título --}}
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-3">
                <span class="font-display bg-dre-primary text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap flex items-center gap-1.5">
                    <i data-lucide="image" class="w-4 h-4"></i>
                    Galería Institucional
                </span>
                <div class="flex-1 h-px bg-blue-200"></div>
            </div>
            <h1 class="font-display text-2xl md:text-3xl font-extrabold text-dre-primary leading-tight">
                {{ $galeria->titulo }}
            </h1>
            @if($galeria->descripcion)
                <p class="mt-2 text-gray-500 text-sm leading-relaxed max-w-2xl">{{ $galeria->descripcion }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ── Visor principal ── --}}
            <div class="lg:col-span-2">
                <div class="relative rounded-2xl overflow-hidden bg-gray-100 shadow-xl aspect-[4/3]">

                    @foreach($imagenes as $i => $img)
                        <div x-show="current === {{ $i }}"
                             x-transition:enter="transition ease-out duration-400"
                             x-transition:enter-start="opacity-0 scale-[1.02]"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="absolute inset-0">
                            <img src="{{ asset('img/imageneventos/' . $img->archivo_img) }}"
                                 alt="{{ $galeria->titulo }} — imagen {{ $i + 1 }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endforeach

                    {{-- Controles --}}
                    @if(count($imagenes) > 1)
                        {{-- Anterior --}}
                        <button @click="prev()"
                                class="group absolute left-0 top-0 h-full w-20 flex items-center justify-start pl-3 z-10
                                       bg-gradient-to-r from-black/40 to-transparent
                                       hover:from-black/60 transition-all duration-300">
                            <span class="flex items-center justify-center w-11 h-11 rounded-full
                                         bg-white/15 border border-white/30 backdrop-blur-md
                                         text-white shadow-lg
                                         group-hover:bg-yellow-400 group-hover:border-yellow-400 group-hover:text-black
                                         transition-all duration-300 group-hover:scale-110">
                                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                            </span>
                        </button>

                        {{-- Siguiente --}}
                        <button @click="next()"
                                class="group absolute right-0 top-0 h-full w-20 flex items-center justify-end pr-3 z-10
                                       bg-gradient-to-l from-black/40 to-transparent
                                       hover:from-black/60 transition-all duration-300">
                            <span class="flex items-center justify-center w-11 h-11 rounded-full
                                         bg-white/15 border border-white/30 backdrop-blur-md
                                         text-white shadow-lg
                                         group-hover:bg-yellow-400 group-hover:border-yellow-400 group-hover:text-black
                                         transition-all duration-300 group-hover:scale-110">
                                <i data-lucide="arrow-right" class="w-5 h-5"></i>
                            </span>
                        </button>
                    @endif

                    {{-- Contador + dots --}}
                    <div class="absolute bottom-4 left-0 right-0 flex flex-col items-center gap-2 z-10">
                        <div class="flex gap-1.5">
                            @foreach($imagenes as $i => $img)
                                <button @click="current = {{ $i }}"
                                        :class="current === {{ $i }} ? 'bg-yellow-400 w-5' : 'bg-white/50 w-2 hover:bg-white/80'"
                                        class="h-2 rounded-full transition-all duration-300"></button>
                            @endforeach
                        </div>
                        <div class="bg-black/60 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full">
                            <span x-text="current + 1"></span> / {{ count($imagenes) }}
                        </div>
                    </div>
                </div>

                {{-- Miniaturas --}}
                @if(count($imagenes) > 1)
                    <div class="mt-5 flex items-center gap-2">

                        {{-- Botón anterior --}}
                        <button @click="prev()"
                                class="shrink-0 w-9 h-9 rounded-lg border border-gray-200 bg-white hover:bg-dre-primary hover:border-dre-primary hover:text-white
                                       text-gray-500 flex items-center justify-center transition-all duration-200 shadow-sm">
                            <i data-lucide="chevron-left" class="w-4 h-4"></i>
                        </button>

                        {{-- Strip de miniaturas --}}
                        <div class="flex-1 overflow-x-auto pb-1 scrollbar-hide">
                            <div class="flex gap-2" x-ref="thumbs">
                                @foreach($imagenes as $i => $img)
                                    <button @click="current = {{ $i }}; scrollThumb()"
                                            :class="current === {{ $i }}
                                                ? 'ring-2 ring-dre-primary ring-offset-2 opacity-100'
                                                : 'opacity-50 hover:opacity-80'"
                                            class="shrink-0 w-16 h-16 rounded-lg overflow-hidden transition-all duration-200">
                                        <img src="{{ asset('img/imageneventos/' . $img->archivo_img) }}"
                                             alt="miniatura {{ $i + 1 }}"
                                             class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Botón siguiente --}}
                        <button @click="next()"
                                class="shrink-0 w-9 h-9 rounded-lg border border-gray-200 bg-white hover:bg-dre-primary hover:border-dre-primary hover:text-white
                                       text-gray-500 flex items-center justify-center transition-all duration-200 shadow-sm">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </button>

                    </div>
                @endif
            </div>

            {{-- ── Panel lateral ── --}}
            <div class="flex flex-col gap-4">

                {{-- Info card --}}
                <div class="bg-dre-primary/5 border border-dre-primary/15 rounded-2xl p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-dre-primary rounded-lg flex items-center justify-center">
                            <i data-lucide="info" class="w-4 h-4 text-white"></i>
                        </div>
                        <span class="font-display font-bold text-dre-primary text-sm uppercase tracking-wide">Información</span>
                    </div>
                    <dl class="space-y-3 text-sm">
                        <div class="flex items-start gap-2">
                            <i data-lucide="images" class="w-4 h-4 text-dre-primary shrink-0 mt-0.5"></i>
                            <div>
                                <dt class="text-gray-400 text-xs uppercase tracking-wide">Total de imágenes</dt>
                                <dd class="font-semibold text-gray-800">{{ count($imagenes) }} foto{{ count($imagenes) !== 1 ? 's' : '' }}</dd>
                            </div>
                        </div>
                    </dl>
                </div>

                {{-- Volver --}}
                <a href="{{ route('galerias') }}"
                   class="flex items-center justify-center gap-2 bg-dre-primary text-white text-sm font-bold px-4 py-2.5 rounded-lg hover:bg-dre-dark transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Volver a Galería
                </a>
            </div>

        </div>
    </div>
</section>

@endsection
