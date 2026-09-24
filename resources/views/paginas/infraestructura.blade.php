@extends('principal.plantilla')
@section('title', 'Infraestructura — DRE Huánuco')
@section('content')

{{-- ── BREADCRUMB HERO ──────────────────────────────────────── --}}
<div class="relative h-36 sm:h-52 bg-cover bg-center overflow-hidden"
     style="background-image: url('{{ asset('img/bc.jpeg') }}')">
    <div class="absolute inset-0 bg-dre-dark/80"></div>
    <div class="relative h-full max-w-screen-xl mx-auto px-4 md:px-8 flex flex-col justify-center">
        <h1 class="font-display text-white text-3xl sm:text-4xl font-extrabold uppercase tracking-widest drop-shadow-lg">
            Infraestructura
        </h1>
        <nav class="flex items-center gap-1.5 text-xs text-white/60 mt-2">
            <a href="/" class="hover:text-yellow-400 transition-colors">Home</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white/90">Área de Infraestructura</span>
        </nav>
    </div>
</div>

{{-- ── CONTENIDO ─────────────────────────────────────────────── --}}
<section class="py-10 bg-gray-50 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">

        {{-- ── ENCABEZADO ─────────────────────────────────────── --}}
        <div class="flex items-center gap-3 mb-8">
            <div class="w-12 h-12 rounded-xl bg-dre-primary flex items-center justify-center shrink-0 shadow-md">
                <i data-lucide="building-2" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-dre-accent uppercase tracking-[0.2em]">Dirección de Gestión Institucional</p>
                <h2 class="font-display font-extrabold text-dre-dark text-xl sm:text-2xl leading-tight">
                    Área de Infraestructura
                </h2>
            </div>
            <div class="ml-auto flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-2">
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">DRE Huánuco</span>
                    <div class="w-1 h-1 rounded-full bg-dre-accent"></div>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ date('Y') }}</span>
                </div>
                @if(count($registros) > 0)
                <a href="{{ route('infraestructura.galeria') }}"
                   class="inline-flex items-center gap-2 bg-dre-primary text-white
                          text-xs font-bold px-4 py-2 rounded-xl shadow-md
                          hover:bg-dre-accent transition-all duration-200">
                    <i data-lucide="images" class="w-3.5 h-3.5 shrink-0"></i>
                    Ver todas las imágenes
                </a>
                @endif
            </div>
        </div>

        {{-- ── GALERÍA DE IMÁGENES ─────────────────────────────── --}}
        @if(count($registros) > 0)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8"
             x-data="{ slide: 0, total: {{ count($registros) }}, modal: false }">

            {{-- Slider principal --}}
            <div class="relative overflow-hidden bg-dre-dark"
                 style="height: clamp(220px, 45vw, 520px);">

                <div class="flex h-full transition-transform duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]"
                     :style="`transform: translateX(-${slide * 100}%)`">
                    @foreach($registros as $row)
                    <div class="w-full h-full shrink-0">
                        <img src="{{ asset('img/infraestructura/'.$row->imagen) }}"
                             alt="Infraestructura DRE Huánuco"
                             class="w-full h-full object-cover"
                             onerror="this.style.display='none'">
                    </div>
                    @endforeach
                </div>

                {{-- Overlay degradado --}}
                <div class="absolute inset-0 bg-gradient-to-t from-dre-dark/50 via-transparent to-transparent pointer-events-none"></div>

                {{-- Controles --}}
                @if(count($registros) > 1)
                <button @click="slide = (slide - 1 + total) % total"
                        class="absolute left-3 top-1/2 -translate-y-1/2 z-10
                               w-10 h-10 rounded-full bg-dre-dark text-white shadow-lg
                               border-2 border-dre-accent/60
                               flex items-center justify-center
                               hover:bg-dre-accent hover:border-dre-accent transition-all duration-200">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </button>
                <button @click="slide = (slide + 1) % total"
                        class="absolute right-3 top-1/2 -translate-y-1/2 z-10
                               w-10 h-10 rounded-full bg-dre-dark text-white shadow-lg
                               border-2 border-dre-accent/60
                               flex items-center justify-center
                               hover:bg-dre-accent hover:border-dre-accent transition-all duration-200">
                    <i data-lucide="chevron-right" class="w-5 h-5"></i>
                </button>
                @endif

                {{-- Contador + botón de zoom --}}
                <div class="absolute bottom-4 right-4 z-10 flex items-center gap-2">
                    <button @click="modal = true"
                            class="flex items-center gap-1.5 bg-black/40 backdrop-blur-sm text-white
                                   text-xs font-bold px-3 py-1.5 rounded-full border border-white/20
                                   hover:bg-dre-accent hover:border-dre-accent transition-all duration-200">
                        <i data-lucide="expand" class="w-3.5 h-3.5 shrink-0"></i>
                        Ver imagen
                    </button>
                    <div class="bg-black/40 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full border border-white/20">
                        <span x-text="slide + 1"></span> / {{ count($registros) }}
                    </div>
                </div>
            </div>

            {{-- Dots --}}
            @if(count($registros) > 1)
            <div class="flex items-center justify-center gap-1.5 py-3 px-4 bg-gray-50 border-t border-gray-100">
                @foreach($registros as $i => $row)
                <button @click="slide = {{ $i }}"
                        :class="slide === {{ $i }} ? 'w-6 bg-dre-primary' : 'w-2 bg-gray-300 hover:bg-gray-400'"
                        class="h-2 rounded-full transition-all duration-300"></button>
                @endforeach
            </div>
            @endif

            {{-- ── MODAL LIGHTBOX ──────────────────────────────── --}}
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

                {{-- Contador en modal --}}
                <div class="absolute top-4 left-1/2 -translate-x-1/2 z-10
                            bg-black/50 backdrop-blur-sm text-white text-xs font-bold
                            px-3 py-1.5 rounded-full border border-white/20">
                    <span x-text="slide + 1"></span> / {{ count($registros) }}
                </div>

                {{-- Imagen --}}
                <div class="relative w-full max-w-5xl">
                    <div class="overflow-hidden rounded-xl shadow-2xl">
                        <div class="flex transition-transform duration-500 ease-[cubic-bezier(0.16,1,0.3,1)]"
                             :style="`transform: translateX(-${slide * 100}%)`">
                            @foreach($registros as $row)
                            <div class="w-full shrink-0">
                                <img src="{{ asset('img/infraestructura/'.$row->imagen) }}"
                                     alt="Infraestructura DRE Huánuco"
                                     class="w-full max-h-[82vh] object-contain bg-black">
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Nav del modal --}}
                    @if(count($registros) > 1)
                    <button @click="slide = (slide - 1 + total) % total"
                            class="absolute left-3 top-1/2 -translate-y-1/2
                                   w-11 h-11 rounded-full bg-dre-dark text-white shadow-xl
                                   border-2 border-dre-accent/60
                                   flex items-center justify-center
                                   hover:bg-dre-accent hover:border-dre-accent transition-all duration-200">
                        <i data-lucide="chevron-left" class="w-5 h-5"></i>
                    </button>
                    <button @click="slide = (slide + 1) % total"
                            class="absolute right-3 top-1/2 -translate-y-1/2
                                   w-11 h-11 rounded-full bg-dre-dark text-white shadow-xl
                                   border-2 border-dre-accent/60
                                   flex items-center justify-center
                                   hover:bg-dre-accent hover:border-dre-accent transition-all duration-200">
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </button>
                    @endif
                </div>
            </div>

        </div>
        @endif

        {{-- ── RESPONSABLE ─────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5
                    flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-dre-50 border-2 border-dre-accent/30
                        flex items-center justify-center shrink-0">
                <i data-lucide="user-check" class="w-5 h-5 text-dre-accent"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Responsable del Área</p>
                <p class="font-display font-bold text-gray-900 text-base">Ing. Miguel A. Cruz Venancio</p>
                <p class="text-xs text-dre-accent font-semibold">Ingeniero II — Área de Infraestructura</p>
            </div>
            <div class="ml-auto hidden sm:flex items-center gap-1.5 text-xs text-gray-400">
                <i data-lucide="building" class="w-3.5 h-3.5 text-dre-accent shrink-0"></i>
                <span>DGI · DRE Huánuco</span>
            </div>
        </div>

    </div>
</section>

@endsection
