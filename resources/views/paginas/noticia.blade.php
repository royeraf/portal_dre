@extends('principal.plantilla')
@section('title', $noticia->titulo . ' | DRE HUÁNUCO')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet">
<style>
    /* ── Fuente serif para lectura ─────────────────────────── */
    .prose-noticia {
        font-family: 'Lora', Georgia, 'Times New Roman', serif;
        color: #374151;
        font-size: 1.125rem;
        line-height: 1.9;
        font-weight: 400;

        /* Justificado con silabización automática (requiere lang="es") */
        text-align: justify;
        -webkit-hyphens: auto;
        -ms-hyphens: auto;
        hyphens: auto;
        hyphenate-limit-chars: 6 3 3;

        /* Evita desbordamiento por palabras largas (URLs, etc.) */
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .prose-noticia p {
        margin-bottom: 1.75rem;
        text-align: justify;
        text-align-last: left; /* última línea del párrafo siempre alineada a la izquierda */
    }

    .prose-noticia h2, .prose-noticia h3, .prose-noticia h4 {
        font-family: 'Rubik', sans-serif;
        font-weight: 700;
        color: #111827;
        margin-top: 3rem;
        margin-bottom: 1.25rem;
        line-height: 1.3;
        text-align: left; /* los títulos no se justifican */
        hyphens: none;
    }
    .prose-noticia h2 { font-size: 1.75rem; }
    .prose-noticia h3 { font-size: 1.5rem; }
    .prose-noticia h4 { font-size: 1.25rem; }

    .prose-noticia img {
        border-radius: 1.5rem;
        margin: 3rem auto;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        width: 100%;
        height: auto;
    }
    .prose-noticia a {
        color: #013072;
        text-decoration: underline;
        text-underline-offset: 4px;
        font-weight: 500;
        transition: color 0.3s;
        /* Los links no se cortan con guiones */
        hyphens: none;
        overflow-wrap: anywhere;
    }
    .prose-noticia a:hover { color: #facc15; }
    .prose-noticia ul, .prose-noticia ol { margin-bottom: 2rem; padding-left: 1.5rem; text-align: left; }
    .prose-noticia li { margin-bottom: 0.5rem; }
    .prose-noticia strong, .prose-noticia b { font-weight: 700; color: #111827; }
    .prose-noticia blockquote {
        border-left: 4px solid #facc15;
        padding: 1.25rem 1.5rem;
        font-style: italic;
        color: #4b5563;
        margin: 2rem 0;
        background: #fdfdfd;
        border-radius: 0 1rem 1rem 0;
        text-align: left;
    }

    /* ── Optimización móvil ─────────────────────────────────── */
    @media (max-width: 640px) {
        .prose-noticia {
            font-size: 1rem;
            line-height: 1.8;
        }
        .prose-noticia p { margin-bottom: 1.5rem; }
        .prose-noticia h2 { font-size: 1.4rem; }
        .prose-noticia h3 { font-size: 1.2rem; }
        .prose-noticia img {
            border-radius: 0.75rem;
            margin: 1.75rem auto;
        }
    }
</style>
@endpush

@section('content')

{{-- ── BREADCRUMB HERO ──────────────────────────────────────── --}}
<div class="relative h-36 sm:h-52 bg-cover bg-center overflow-hidden"
     style="background-image: url('{{ asset('img/bc.jpeg') }}')">
    <div class="absolute inset-0 bg-dre-dark/80 backdrop-blur-[2px]"></div>
    <div class="relative h-full max-w-screen-xl mx-auto px-4 md:px-8 flex flex-col justify-center">
        <h1 class="font-display text-white text-2xl sm:text-3xl font-bold uppercase tracking-widest drop-shadow-md">
            Noticia Institucional
        </h1>
        <nav class="flex items-center gap-1.5 text-xs text-white/60 mt-2">
            <a href="{{ url('/') }}" class="hover:text-yellow-400 transition-colors">Inicio</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-white/90">Noticias</span>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-yellow-400 truncate max-w-[150px] sm:max-w-xs">{{ $noticia->titulo }}</span>
        </nav>
    </div>
</div>

<main class="bg-white py-12 lg:py-24">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 md:px-8">
        <div style="display: flex; flex-wrap: wrap; gap: 3rem;">
            
            {{-- ── SECCIÓN PRINCIPAL DE LECTURA ─────────────────────────── --}}
            <article style="flex: 1 1 0%; min-width: 300px; max-width: 100%;">
                
                {{-- Metadata --}}
                <div class="flex flex-wrap items-center gap-4 mb-8">
                    @if($noticia->fechapubli)
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 text-dre-primary text-[10px] sm:text-xs font-bold uppercase tracking-widest border border-blue-100">
                        <i class="fas fa-calendar-alt"></i> 
                        {{ date('d M Y', strtotime($noticia->fechapubli)) }}
                    </span>
                    @endif
                    <span class="text-xs sm:text-sm text-gray-400 flex items-center gap-1.5 font-medium uppercase tracking-widest">
                        <i class="fas fa-pen-nib"></i> DRE Huánuco
                    </span>
                </div>

                {{-- Título Principal --}}
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-display font-black text-dre-darker leading-[1.15] mb-12 text-balance tracking-tight">
                    {{ $noticia->titulo }}
                </h2>

                {{-- Image Gallery Slider (Reemplazo moderno del Carousel Bootstrap) --}}
                @php
                    $images = [];
                    if(!empty($noticia->img1) && $noticia->img1 != 'default.jpg') $images[] = $noticia->img1;
                    if(!empty($noticia->img2)) $images[] = $noticia->img2;
                    if(!empty($noticia->img3)) $images[] = $noticia->img3;
                @endphp
                
                @if(count($images) > 0)
                <div class="mb-14 p-2 sm:p-4 bg-gray-50 rounded-[2.5rem] border border-gray-100">
                    <div x-data="{ currentSlide: 0, total: {{ count($images) }} }" class="relative rounded-[2rem] overflow-hidden shadow-xl group bg-black isolate">
                        
                        <div class="flex transition-transform duration-700 cubic-bezier(0.16, 1, 0.3, 1) h-[300px] sm:h-[450px] md:h-[550px]" 
                             :style="`transform: translateX(-${currentSlide * 100}%)`">
                            @foreach($images as $img)
                            <div class="w-full h-full shrink-0 relative bg-gray-100 flex items-center justify-center">
                                <img src="{{ asset('img/noticias/'.$img) }}" alt="{{ $noticia->titulo }}" class="w-full h-full object-contain" onerror="this.parentElement.style.display='none'">
                                {{-- sutil gradiente para profundidad --}}
                                <div class="absolute inset-x-0 bottom-0 h-[30%] bg-gradient-to-t from-black/20 to-transparent"></div>
                            </div>
                            @endforeach
                        </div>
                        
                        @if(count($images) > 1)
                        {{-- Flechas de Navegación --}}
                        <button @click="currentSlide = currentSlide > 0 ? currentSlide - 1 : total - 1" 
                                class="absolute left-4 sm:left-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-white hover:text-black hover:scale-110 shadow-2xl transform -translate-x-4 group-hover:translate-x-0 z-10">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button @click="currentSlide = currentSlide < total - 1 ? currentSlide + 1 : 0" 
                                class="absolute right-4 sm:right-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-white hover:text-black hover:scale-110 shadow-2xl transform translate-x-4 group-hover:translate-x-0 z-10">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        
                        {{-- Indicadores (Dots) --}}
                        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex items-center gap-2.5 px-5 py-2.5 rounded-full bg-black/40 backdrop-blur-md border border-white/10 shadow-xl z-10">
                            @foreach($images as $index => $img)
                            <button @click="currentSlide = {{ $index }}" 
                                    :class="currentSlide === {{ $index }} ? 'w-8 bg-white' : 'w-2.5 bg-white/40 hover:bg-white/80'"
                                    class="h-2.5 rounded-full transition-all duration-500 ease-out"></button>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                
                {{-- Contenido Textual Enriquecido --}}
                <div class="prose-noticia max-w-none">
                    {!! $noticia->contenido !!}
                </div>
            </article>

            {{-- ── SIDEBAR DERECHO ──────────────────────────────────── --}}
            <aside style="width: 340px; flex-shrink: 0; max-width: 100%;">
                <div class="sticky top-32 flex flex-col gap-4">

                    {{-- Facebook --}}
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        {{-- Label instrument-panel --}}
                        <div class="flex items-center gap-2 px-4 py-2.5 border-b border-gray-200 bg-gray-50">
                            <svg class="w-3.5 h-3.5 text-[#1877f2] shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            <span class="font-mono text-[10px] font-bold tracking-[0.14em] uppercase text-gray-400 select-none">
                                Redes Sociales
                            </span>
                        </div>
                        {{-- FB embed --}}
                        <div class="bg-white min-h-[480px]">
                            <div class="fb-page"
                                data-href="https://www.facebook.com/direccionregionaldeeducacion"
                                data-tabs="timeline"
                                data-width=""
                                data-height="600"
                                data-small-header="true"
                                data-adapt-container-width="true"
                                data-hide-cover="false"
                                data-show-facepile="false">
                                <blockquote cite="https://www.facebook.com/direccionregionaldeeducacion" class="fb-xfbml-parse-ignore">
                                    <a href="https://www.facebook.com/direccionregionaldeeducacion">Educación DreHco</a>
                                </blockquote>
                            </div>
                        </div>
                    </div>

                    {{-- Compartir --}}
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        {{-- Label --}}
                        <div class="flex items-center gap-2 px-4 py-2.5 border-b border-gray-200 bg-gray-50">
                            <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185z"/>
                            </svg>
                            <span class="font-mono text-[10px] font-bold tracking-[0.14em] uppercase text-gray-400 select-none">
                                Compartir Noticia
                            </span>
                        </div>

                        {{-- Botones --}}
                        <div class="p-4 flex flex-col gap-2.5 bg-white">
                            <a target="_blank"
                               href="https://www.facebook.com/sharer.php?u={{ url('noticia/' . $noticia->id) }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg
                                      text-white text-[11px] font-mono font-bold uppercase tracking-[0.1em]
                                      transition-opacity duration-150 hover:opacity-80 active:opacity-60"
                               style="background-color: #1877f2;">
                                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Compartir en Facebook
                            </a>

                            <a target="_blank"
                               href="https://wa.me/?text={{ urlencode('Mira esta noticia: ' . url('noticia/' . $noticia->id)) }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg
                                      text-white text-[11px] font-mono font-bold uppercase tracking-[0.1em]
                                      transition-opacity duration-150 hover:opacity-80 active:opacity-60"
                               style="background-color: #25d366;">
                                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/>
                                </svg>
                                Compartir en WhatsApp
                            </a>
                        </div>
                    </div>

                </div>
            </aside>

        </div> 
    </div> 
</main>
@endsection

@push('scripts')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v16.0" nonce="9urXt4qV"></script>
@endpush
