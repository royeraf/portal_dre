@extends('principal.plantilla')
@section('title', 'Documentos de Gestión | DRE Huánuco')
@section('content')

{{-- ── BREADCRUMB HERO ──────────────────────────────────────── --}}
<div class="relative h-36 sm:h-52 bg-cover bg-center overflow-hidden"
     style="background-image: url('{{ asset('img/bc.jpeg') }}')">
    <div class="absolute inset-0 bg-dre-dark/80"></div>
    <div class="relative h-full max-w-screen-xl mx-auto px-4 md:px-8 flex flex-col justify-center">
        <h1 class="font-display text-white text-3xl sm:text-4xl font-extrabold uppercase tracking-widest drop-shadow-lg">
            Documentos de Gestión
        </h1>
        <nav class="flex items-center gap-1.5 text-xs text-white/60 mt-2">
            <a href="/" class="hover:text-yellow-400 transition-colors">Home</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white/90">Gestión de Documentos</span>
        </nav>
    </div>
</div>

<!-- CONTENT SECTION -->
<section class="py-16 md:py-24 bg-gray-50/50 relative">
    <!-- Abstract ambient shapes -->
    <div class="absolute top-0 right-0 -mr-40 -mt-20 w-96 h-96 rounded-full bg-dre-100/30 blur-[80px] opacity-70 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -ml-40 mb-20 w-[30rem] h-[30rem] rounded-full bg-dre-200/20 blur-[100px] opacity-60 pointer-events-none"></div>

    <div class="container mx-auto px-4 sm:px-6 max-w-5xl relative z-10">
        
        <!-- Table / List Layout -->
        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100/80 backdrop-blur-sm relative z-20">
            
            <!-- List Header (Desktop) -->
            <div class="hidden md:grid md:grid-cols-12 gap-6 px-8 py-5 bg-gray-50/80 border-b border-gray-100 text-xs font-bold text-gray-500 tracking-widest uppercase rounded-t-3xl">
                <div class="col-span-8 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-4 h-4 text-gray-400"></i>
                    Título del Documento
                </div>
                <div class="col-span-4 text-right flex items-center justify-end gap-2">
                    <i data-lucide="link" class="w-4 h-4 text-gray-400"></i>
                    Archivos Adjuntos
                </div>
            </div>

            <div class="divide-y divide-gray-50">
                @forelse ($registros as $item)
                    <div class="group flex flex-col md:flex-row md:items-center justify-between p-6 md:px-8 hover:bg-dre-50/40 transition-all duration-400 @if($loop->last) rounded-b-3xl @endif">
                        
                        <!-- Title & Meta -->
                        <div class="flex items-start gap-5 mb-5 md:mb-0 md:w-2/3 pr-6">
                            <div class="mt-1 flex-shrink-0 w-12 h-12 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 text-gray-400 flex items-center justify-center group-hover:from-dre-100 group-hover:to-dre-50 group-hover:text-dre-primary group-hover:shadow-md group-hover:-translate-y-0.5 transition-all duration-300 transform border border-gray-100/50">
                                <i data-lucide="book-open" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-800 leading-snug group-hover:text-dre-primary transition-colors duration-300">
                                    {{ $item->titulo }}
                                </h3>
                                <div class="mt-2 flex items-center gap-4 text-xs font-medium text-gray-400">
                                    <span class="flex items-center gap-1.5 bg-gray-100/80 px-2.5 py-1 rounded-md text-gray-500 group-hover:bg-white group-hover:text-dre-primary/80 transition-colors">
                                        <i data-lucide="paperclip" class="w-3.5 h-3.5"></i>
                                        {{ $item->archivos->count() }} archivo{{ $item->archivos->count() != 1 ? 's' : '' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions Dropdown (Alpine.js) -->
                        <div x-data="{ open: false }" class="relative md:w-1/3 flex md:justify-end" @click.away="open = false">
                            <button @click="open = !open" 
                                class="w-full md:w-auto flex items-center justify-center gap-2 px-6 py-2.5 bg-white border-2 border-gray-100 rounded-xl text-sm font-semibold text-gray-600 hover:border-dre-primary hover:bg-dre-primary hover:text-white focus:outline-none focus:ring-4 focus:ring-dre-primary/10 transition-all duration-300 shadow-sm"
                                :class="{'bg-dre-primary border-dre-primary text-white shadow-md': open}"
                            >
                                <i data-lucide="folder-search" class="w-4 h-4"></i>
                                <span>Ver archivos</span>
                                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-300" :class="{'rotate-180': open}"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                class="absolute right-0 top-full mt-3 w-full md:w-80 rounded-2xl bg-white shadow-xl shadow-dre-dark/10 border border-gray-100 overflow-hidden z-20"
                                style="display: none;"
                            >
                                <div class="p-2">
                                    @if(count($item->archivos) > 0)
                                        @foreach ($item->archivos as $row)
                                            <a href="{{ $row['url_archivo'] }}" target="_blank" rel="noopener noreferrer" class="flex items-start p-3 rounded-xl text-sm text-gray-600 hover:bg-dre-50 hover:text-dre-primary transition-all duration-200 group/link">
                                                <div class="mt-0.5 mr-3 bg-gray-100 p-1.5 rounded-lg group-hover/link:bg-white group-hover/link:shadow-sm transition-colors">
                                                    <i data-lucide="download" class="w-4 h-4 text-gray-400 group-hover/link:text-dre-accent transition-colors"></i>
                                                </div>
                                                <span class="flex-1 font-medium leading-tight pt-1">
                                                    {{ $row['nombre'] ?: 'Descargar adjunto' }}
                                                </span>
                                            </a>
                                        @endforeach
                                    @else
                                        <div class="py-6 px-4 text-sm text-gray-400 text-center flex flex-col items-center">
                                            <i data-lucide="file-x" class="w-8 h-8 text-gray-200 mb-2"></i>
                                            Sin archivos adjuntos
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="p-16 text-center text-gray-500">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-dre-50 mb-6 shadow-inner">
                            <i data-lucide="database" class="w-10 h-10 text-dre-200"></i>
                        </div>
                        <h4 class="text-xl font-semibold text-gray-800 font-display">No hay documentos registrados</h4>
                        <p class="mt-2 text-gray-500 font-light max-w-md mx-auto">Actualmente no existen documentos de gestión disponibles en la plataforma.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
