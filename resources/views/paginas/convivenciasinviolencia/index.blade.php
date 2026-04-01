@extends('principal.plantilla')
@section('title', 'En Huánuco Todos Unidos por una Convivencia Sin Violencia')
@section('content')

{{-- ── BREADCRUMB HERO (Uniformizado) ──────────────────────────────────────── --}}
<div class="relative h-36 sm:h-52 bg-cover bg-center overflow-hidden"
     style="background-image: url('{{ asset('img/bc.jpeg') }}')">
    <div class="absolute inset-0 bg-dre-dark/80"></div>
    <div class="relative h-full max-w-screen-xl mx-auto px-4 md:px-8 flex flex-col justify-center">
        <h1 class="font-display text-white text-3xl sm:text-4xl font-extrabold uppercase tracking-widest drop-shadow-lg">
            Convivencia Sin Violencia
        </h1>
        <nav class="flex items-center gap-1.5 text-xs text-white/60 mt-2">
            <a href="/" class="hover:text-yellow-400 transition-colors">Home</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white/90">Convivencia Sin Violencia</span>
        </nav>
    </div>
</div>

{{-- ── BIENVENIDA Y PROPÓSITO ──────────────────────────────────────── --}}
<section class="py-16 lg:py-24 bg-white relative overflow-hidden">
    {{-- Decorative background shape --}}
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-blue-50 rounded-full opacity-50 blur-3xl pointer-events-none"></div>

    <div class="max-w-screen-xl mx-auto px-4 md:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            
            {{-- Texto Principal --}}
            <div x-data="{ shown: false }" x-intersect.once="shown = true"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-12'"
                 class="transition-all duration-1000 ease-out">
                 
                <span class="inline-block py-1.5 px-4 rounded-full bg-blue-50 text-dre-accent text-[10px] md:text-xs font-bold tracking-widest uppercase mb-6 border border-blue-100 shadow-sm">
                    Bienvenidos a Nuestra Estrategia
                </span>
                
                <h2 class="font-display text-4xl sm:text-5xl font-extrabold text-dre-darker leading-tight mb-6">
                    En Huánuco <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-500 to-yellow-600">Todos Unidos</span><br>
                    por una Convivencia <br>
                    <span class="text-red-500">Sin Violencia</span>
                </h2>
                
                <p class="text-gray-600 text-lg leading-relaxed mb-8 border-l-4 border-dre-accent pl-6 bg-gray-50/50 py-3 rounded-r-xl">
                    Representa nuestro compromiso firme con la construcción de espacios educativos seguros, donde cada estudiante pueda desarrollarse plenamente en un ambiente de respeto, tolerancia y paz.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-10">
                    {{-- Feature 1 --}}
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 shrink-0 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center shadow-sm">
                            <i data-lucide="user-check" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Prevención</h4>
                            <p class="text-sm text-gray-500 leading-tight">Estrategias proactivas para crear ambientes seguros.</p>
                        </div>
                    </div>
                    {{-- Feature 2 --}}
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 shrink-0 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-sm">
                            <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Formación Integral</h4>
                            <p class="text-sm text-gray-500 leading-tight">Desarrollo de habilidades socioemocionales.</p>
                        </div>
                    </div>
                    {{-- Feature 3 --}}
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 shrink-0 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center shadow-sm">
                            <i data-lucide="users" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Comunidad</h4>
                            <p class="text-sm text-gray-500 leading-tight">Involucramiento de familias y comunidad.</p>
                        </div>
                    </div>
                    {{-- Feature 4 --}}
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 shrink-0 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center shadow-sm">
                            <i data-lucide="heart" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Cultura de Paz</h4>
                            <p class="text-sm text-gray-500 leading-tight">Promoción de valores y resolución pacífica.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Imagen --}}
            <div x-data="{ shown: false }" x-intersect.once="shown = true"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                 class="transition-all duration-1000 ease-out delay-300 relative justify-self-center lg:justify-self-end w-full max-w-lg">
                <div class="absolute inset-0 bg-gradient-to-tr from-dre-primary to-dre-accent rounded-[2.5rem] transform rotate-3 scale-105 opacity-20 hidden sm:block"></div>
                <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl border border-gray-100 bg-white">
                    <img src="{{ asset('img/convivencia/bienvenido.jpg') }}" 
                         alt="Convivencia Sin Violencia" 
                         loading="lazy"
                         class="w-full h-auto object-cover hover:scale-105 transition-transform duration-700">
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ── PROGRAMAS DESTACADOS ─────────────────────────────────── --}}
<section id="programas" class="py-16 lg:py-24 bg-gray-50 border-t border-gray-100">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-16" x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="transition-all duration-700">
            <h2 class="font-display text-3xl md:text-4xl font-extrabold text-dre-darker mb-4">Programas Destacados</h2>
            <div class="w-20 h-1.5 bg-dre-accent mx-auto rounded-full mb-6"></div>
            <p class="text-gray-600 text-lg">
                Conoce nuestros principales programas diseñados para promover y asegurar una convivencia pacífica.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" style="gap: 2rem;">
            
            @php
            $cards = [
                ['img' => 'img1.jpg', 'title' => 'Programa de Mediación Escolar', 'desc' => 'Formamos estudiantes mediadores que ayudan a resolver conflictos de manera pacífica, promoviendo el diálogo y la comprensión mutua entre compañeros.'],
                ['img' => 'img2.jpg', 'title' => 'Programa de Mediación Escolar', 'desc' => 'Formamos estudiantes mediadores que ayudan a resolver conflictos de manera pacífica, promoviendo el diálogo y la comprensión mutua entre compañeros.'],
                ['img' => 'img2.jpg', 'title' => 'Programa de Mediación Escolar', 'desc' => 'Formamos estudiantes mediadores que ayudan a resolver conflictos de manera pacífica, promoviendo el diálogo y la comprensión mutua entre compañeros.']
            ];
            @endphp
            
            @foreach($cards as $index => $card)
            <div x-data="{ shown: false }" x-intersect.once="shown = true"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                 class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-[0_20px_40px_rgba(0,0,0,0.06)] transition-all duration-500 border border-gray-100 flex flex-col h-full"
                 style="transition-delay: {{ $index * 150 }}ms;">
                
                {{-- Card Image --}}
                <div class="relative h-56 overflow-hidden bg-gray-100">
                    <img src="{{ asset('img/convivencia/'.$card['img']) }}" alt="{{ $card['title'] }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-60"></div>
                </div>

                {{-- Card Content --}}
                <div class="p-8 flex flex-col flex-1">
                    <h4 class="font-display text-xl font-bold text-dre-darker mb-4 group-hover:text-dre-accent transition-colors leading-tight">{{ $card['title'] }}</h4>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6 flex-1">
                        {{ $card['desc'] }}
                    </p>
                    
                    <div class="pt-6 border-t border-gray-100 flex items-center justify-between mt-auto">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-dre-primary text-white flex items-center justify-center shadow-sm">
                                <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Educación</p>
                                <p class="text-sm font-semibold text-dre-darker leading-none mt-1">UGEL Huacaybamba</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-green-500 text-white text-xs font-bold shadow-md hover:bg-green-600 transition-colors shadow-green-500/20">
                            <i data-lucide="file-text" class="w-3.5 h-3.5"></i> Descargar
                        </span>
                    </div>
                </div>
                
            </div>
            @endforeach

        </div>
    </div>
</section>

{{-- ── CALL TO ACTION ───────────────────────────────────────── --}}
<section class="relative overflow-hidden" style="padding-top: 6rem; padding-bottom: 6rem;">
    {{-- Dynamic Background Layering --}}
    <div class="absolute inset-0 bg-dre-darker"></div>
    <div class="absolute inset-0 bg-cover bg-center mix-blend-overlay opacity-20" style="background-image: url('{{ asset('img/bc.jpeg') }}')"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-dre-primary/95 to-dre-accent/95"></div>
    
    <div class="max-w-screen-md mx-auto px-4 relative z-10 text-center text-white" x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'opacity-100 scale-100' : 'opacity-0 scale-95'" class="transition-all duration-700">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/10 backdrop-blur-md mb-6 border border-white/20">
            <i data-lucide="heart" class="w-8 h-8 text-yellow-400"></i>
        </div>
        <h2 class="font-display text-4xl md:text-5xl font-extrabold mb-6 drop-shadow-lg">¡Únete a Nuestra Misión!</h2>
        <p class="text-lg md:text-xl font-light text-blue-100 mb-10 leading-relaxed max-w-2xl mx-auto">
            Juntos podemos construir un futuro donde la violencia no tenga lugar en nuestras escuelas. 
            Tu participación activa es fundamental para lograr el cambio.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="#programas" class="px-8 py-4 bg-yellow-400 text-dre-darker rounded-full font-bold uppercase tracking-widest text-sm hover:bg-white hover:-translate-y-1 transition-all shadow-[0_10px_20px_rgba(250,204,21,0.2)] flex items-center justify-center gap-2">
                <span>Participar Ahora</span>
            </a>
            <a href="#programas" class="px-8 py-4 bg-white/10 backdrop-blur-md text-white border border-white/30 rounded-full font-bold uppercase tracking-widest text-sm hover:bg-white/20 hover:-translate-y-1 transition-all flex items-center justify-center gap-2">
                <span>Más Info</span>
            </a>
        </div>
    </div>
</section>

@endsection