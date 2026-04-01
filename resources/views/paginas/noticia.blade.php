@extends('principal.plantilla')
@section('title', $noticia->titulo . ' | DRE HUÁNUCO')

@push('styles')
<style>
    /* Styling for the rich text editor HTML content to ensure readability */
    .prose-noticia {
        color: #374151; /* gray-700 */
        font-size: 1.125rem; /* 18px */
        line-height: 1.85;
        font-weight: 300;
    }
    .prose-noticia p { 
        margin-bottom: 2rem; 
    }
    .prose-noticia h2, .prose-noticia h3, .prose-noticia h4 { 
        font-family: 'Rubik', sans-serif; 
        font-weight: 700; 
        color: #111827; 
        margin-top: 3rem; 
        margin-bottom: 1.25rem; 
        line-height: 1.3;
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
    }
    .prose-noticia a:hover { color: #facc15; }
    .prose-noticia ul, .prose-noticia ol { margin-bottom: 2rem; padding-left: 1.5rem; }
    .prose-noticia li { margin-bottom: 0.5rem; }
    .prose-noticia strong, .prose-noticia b { font-weight: 700; color: #111827; }
    .prose-noticia blockquote {
        border-left: 4px solid #facc15;
        padding-left: 1.5rem;
        font-style: italic;
        color: #4b5563;
        margin: 2rem 0;
        background: #fdfdfd;
        padding: 1.5rem;
        border-radius: 0 1rem 1rem 0;
    }
    
    @media (max-width: 640px) {
        .prose-noticia { font-size: 1.05rem; }
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
            <aside style="width: 380px; flex-shrink: 0; max-width: 100%;">
                <div class="sticky top-32">
                    <div class="bg-gray-50 rounded-[2rem] p-4 sm:p-6 border border-gray-100 shadow-sm relative overflow-hidden mb-8">
                        {{-- Decorative graphic --}}
                        <div class="absolute top-0 right-0 w-32 h-32 bg-dre-primary opacity-5 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none"></div>

                        <div class="flex items-center gap-3 mb-6 relative z-10">
                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-dre-primary shadow-sm border border-gray-100">
                                <i class="fas fa-satellite-dish"></i>
                            </div>
                            <h3 class="font-display font-bold text-dre-darker tracking-widest uppercase text-sm">Redes Sociales</h3>
                        </div>

                        {{-- Facebook page plugin code preserved --}}
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm relative z-10 w-full min-h-[500px]">
                            <div class="fb-page"
                                data-href="https://www.facebook.com/direccionregionaldeeducacion"
                                data-tabs="timeline"
                                data-width=""
                                data-height="600"
                                data-small-header="false"
                                data-adapt-container-width="true"
                                data-hide-cover="false"
                                data-show-facepile="true">
                                <blockquote cite="https://www.facebook.com/direccionregionaldeeducacion" class="fb-xfbml-parse-ignore">
                                    <a href="https://www.facebook.com/direccionregionaldeeducacion">Educación DreHco</a>
                                </blockquote>
                            </div>
                        </div>
                    </div>

                    {{-- ── NUEVO PANEL DE COMPARTIR EDITORIAL ──────────────────────── --}}
                    <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-xl relative overflow-hidden group hover:shadow-2xl transition-all duration-500">
                        {{-- Fondo Decorativo --}}
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-green-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative z-10 flex flex-col items-center text-center">
                            <div class="w-12 h-12 rounded-full bg-dre-primary/10 text-dre-primary flex items-center justify-center mb-4 transition-transform group-hover:scale-110 duration-500">
                                <i class="fas fa-share-nodes text-xl"></i>
                            </div>
                            <h3 class="font-display font-black text-xl text-dre-darker tracking-wide mb-2 uppercase">Amplifica la Voz</h3>
                            <p class="text-xs text-gray-400 font-medium mb-8 leading-relaxed max-w-[250px]">Comparte esta noticia institucional y ayúdanos a llegar a más personas en Huánuco.</p>
                            
                            <div class="w-full flex flex-col gap-3">
                                <a target="_blank" href="https://www.facebook.com/sharer.php?u={{ url('noticia/' . $noticia->id) }}" 
                                   class="w-full relative overflow-hidden flex items-center justify-center gap-3 px-6 py-4 rounded-xl text-white text-xs font-bold uppercase tracking-widest hover:-translate-y-1 transition-all group/btn"
                                   style="background-color: #1877f2; box-shadow: 0 10px 20px -5px rgba(24,119,242,0.4);">
                                    <div class="absolute inset-0 bg-white/20 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></div>
                                    <svg class="w-4 h-4 fill-current relative z-10" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg> 
                                    <span class="relative z-10">Facebook</span>
                                </a>
                                <a target="_blank" href="https://wa.me/51935179345?text=Mira esta noticia: {{ url('noticia/' . $noticia->id) }}" 
                                   class="w-full relative overflow-hidden flex items-center justify-center gap-3 px-6 py-4 rounded-xl text-white text-xs font-bold uppercase tracking-widest hover:-translate-y-1 transition-all group/btn"
                                   style="background-color: #25d366; box-shadow: 0 10px 20px -5px rgba(37,211,102,0.4);">
                                    <div class="absolute inset-0 bg-white/20 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></div>
                                    <svg class="w-4 h-4 fill-current relative z-10" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg> 
                                    <span class="relative z-10">WhatsApp</span>
                                </a>
                            </div>
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
