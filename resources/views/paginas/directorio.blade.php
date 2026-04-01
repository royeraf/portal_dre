@extends('principal.plantilla')
@section('title', 'Directorio Institucional — DRE Huánuco')
@section('content')

{{-- ── BREADCRUMB HERO ──────────────────────────────────────── --}}
<div class="relative h-36 sm:h-52 bg-cover bg-center overflow-hidden"
     style="background-image: url('{{ asset('img/bc.jpeg') }}')">
    <div class="absolute inset-0 bg-dre-dark/80"></div>
    <div class="relative h-full max-w-screen-xl mx-auto px-4 md:px-8 flex flex-col justify-center">
        <h1 class="font-display text-white text-3xl sm:text-4xl font-extrabold uppercase tracking-widest drop-shadow-lg">
            Directorio
        </h1>
        <nav class="flex items-center gap-1.5 text-xs text-white/60 mt-2">
            <a href="/" class="hover:text-yellow-400 transition-colors">Home</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white/90">Directorio Institucional</span>
        </nav>
    </div>
</div>

{{-- ── CONTENIDO ────────────────────────────────────────────── --}}
<section class="py-10 bg-gray-50">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">

        {{-- ── AUTORIDADES PRINCIPALES ───────────────────────── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10"
             x-data="{ shown: false }" x-intersect.once="shown = true">

            {{-- Director Regional --}}
            @if($director)
            <div :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'"
                 style="transition: all 0.6s ease; transition-delay: 0ms;"
                 class="relative rounded-2xl overflow-hidden shadow-2xl
                        bg-gradient-to-br from-dre-dark via-dre-primary to-dre-accent">
                <div class="absolute inset-0 opacity-[0.07]"
                     style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 28px 28px;"></div>
                <div class="relative flex flex-col items-center gap-5 p-7 text-center h-full">
                    <div class="shrink-0 relative mt-2">
                        <div class="w-32 h-32 rounded-full overflow-hidden
                                    ring-4 ring-yellow-400 ring-offset-4 ring-offset-dre-primary shadow-2xl">
                            <img src="{{ asset('img/fotos/'.$director->foto) }}"
                                 alt="{{ $director->apenom }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 whitespace-nowrap
                                     bg-yellow-400 text-black text-[10px] font-black px-3 py-0.5
                                     rounded-full uppercase tracking-widest shadow-lg">
                            Máxima Autoridad
                        </span>
                    </div>
                    <div class="mt-2">
                        <p class="text-yellow-400/70 text-[10px] font-bold uppercase tracking-[0.2em] mb-1">
                            DRE Huánuco
                        </p>
                        <h2 class="font-display text-white text-xl sm:text-2xl font-extrabold mb-1 leading-tight uppercase">
                            {{ $director->cargo }}
                        </h2>
                        <p class="text-yellow-300 text-base font-semibold mb-4">{{ $director->apenom }}</p>
                        <div class="flex flex-col items-center gap-2 text-white/70 text-xs">
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="mail" class="w-3.5 h-3.5 text-yellow-400 shrink-0"></i>
                                <span>{{ $director->email }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="phone" class="w-3.5 h-3.5 text-yellow-400 shrink-0"></i>
                                <span>{{ $director->celular }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Director de Gestión Pedagógica --}}
            @if($jefeagp)
            <div :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'"
                 style="transition: all 0.6s ease; transition-delay: 100ms;"
                 class="relative rounded-2xl overflow-hidden shadow-2xl
                        bg-gradient-to-br from-blue-900 via-blue-700 to-dre-accent">
                <div class="absolute inset-0 opacity-[0.07]"
                     style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 28px 28px;"></div>
                <div class="relative flex flex-col items-center gap-5 p-7 text-center h-full">
                    <div class="shrink-0 relative mt-2">
                        <div class="w-32 h-32 rounded-full overflow-hidden
                                    ring-4 ring-blue-300 ring-offset-4 ring-offset-blue-800 shadow-2xl">
                            <img src="{{ asset('img/fotos/'.$jefeagp->foto) }}"
                                 alt="{{ $jefeagp->apenom }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 whitespace-nowrap
                                     bg-blue-300 text-blue-900 text-[10px] font-black px-3 py-0.5
                                     rounded-full uppercase tracking-widest shadow-lg">
                            Gestión Pedagógica
                        </span>
                    </div>
                    <div class="mt-2">
                        <p class="text-blue-300/70 text-[10px] font-bold uppercase tracking-[0.2em] mb-1">
                            DRE Huánuco
                        </p>
                        <h2 class="font-display text-white text-xl sm:text-2xl font-extrabold mb-1 leading-tight uppercase">
                            {{ $jefeagp->cargo }}
                        </h2>
                        <p class="text-blue-200 text-base font-semibold mb-4">{{ $jefeagp->apenom }}</p>
                        <div class="flex flex-col items-center gap-2 text-white/70 text-xs">
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="mail" class="w-3.5 h-3.5 text-blue-300 shrink-0"></i>
                                <span>{{ $jefeagp->email }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="phone" class="w-3.5 h-3.5 text-blue-300 shrink-0"></i>
                                <span>{{ $jefeagp->celular }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>

        {{-- ── EQUIPO DIRECTIVO ──────────────────────────────── --}}
        <div class="flex items-center gap-3 mb-5">
            <span class="font-display bg-dre-primary text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">
                Equipo Directivo
            </span>
            <div class="flex-1 h-px bg-dre-primary/20"></div>
        </div>

        @php
        $directivos = [
            ['person' => $jefeagi,  'bar' => 'bg-indigo-600', 'ring' => 'ring-indigo-400'],
            ['person' => $jefeaga,  'bar' => 'bg-teal-600',   'ring' => 'ring-teal-400'],
            ['person' => $jefead2,  'bar' => 'bg-purple-600', 'ring' => 'ring-purple-400'],
            ['person' => $jefehh,   'bar' => 'bg-amber-600',  'ring' => 'ring-amber-400'],
        ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-10"
             x-data="{ shown: false }" x-intersect.once="shown = true">
            @foreach($directivos as $idx => $d)
            @if($d['person'])
            <div :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                 style="transition: all 0.5s ease; transition-delay: {{ $idx * 80 }}ms;"
                 class="group flex items-stretch bg-white rounded-2xl border border-gray-100 shadow-sm
                        overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                {{-- Color bar --}}
                <span class="w-1.5 shrink-0 {{ $d['bar'] }}"></span>
                <div class="flex items-center gap-4 p-5 flex-1 min-w-0">
                    {{-- Photo --}}
                    <div class="shrink-0 w-[72px] h-[72px] rounded-full overflow-hidden
                                ring-2 ring-offset-2 {{ $d['ring'] }}">
                        <img src="{{ asset('img/fotos/'.$d['person']->foto) }}"
                             alt="{{ $d['person']->apenom }}"
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    {{-- Info --}}
                    <div class="min-w-0 flex-1">
                        <h4 class="font-display font-bold text-gray-900 text-sm leading-tight mb-1
                                   group-hover:text-dre-accent transition-colors line-clamp-2">
                            {{ $d['person']->cargo }}
                        </h4>
                        <p class="text-dre-primary text-xs font-bold mb-2 truncate">
                            {{ $d['person']->apenom }}
                        </p>
                        <div class="space-y-0.5">
                            <div class="flex items-center gap-1.5 text-gray-400 text-[11px]">
                                <i data-lucide="mail" class="w-3 h-3 shrink-0 text-dre-accent"></i>
                                <span class="truncate">{{ $d['person']->email }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-gray-400 text-[11px]">
                                <i data-lucide="phone" class="w-3 h-3 shrink-0 text-dre-accent"></i>
                                <span>{{ $d['person']->celular }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        {{-- ── PERSONAL ADMINISTRATIVO ───────────────────────── --}}
        <div class="flex items-center gap-3 mb-5">
            <span class="font-display bg-dre-primary text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">
                Personal Administrativo
            </span>
            <div class="flex-1 h-px bg-dre-primary/20"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3"
             x-data="{ shown: false }" x-intersect.once="shown = true">
            @foreach ($registros as $idx => $item)
            <div :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'"
                 style="transition: all 0.4s ease; transition-delay: {{ min($idx, 18) * 45 }}ms;"
                 class="group flex items-center gap-4 p-4 bg-white rounded-xl border border-gray-100
                        shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                {{-- Photo --}}
                <div class="shrink-0 w-14 h-14 rounded-full overflow-hidden
                            ring-2 ring-gray-200 group-hover:ring-dre-accent transition-all duration-300">
                    <img src="{{ asset('img/fotos/'.$item->foto) }}"
                         alt="{{ $item->apenom }}"
                         loading="lazy"
                         class="w-full h-full object-cover">
                </div>
                {{-- Info --}}
                <div class="min-w-0 flex-1">
                    <h6 class="font-semibold text-gray-900 text-xs leading-snug mb-0.5
                               group-hover:text-dre-accent transition-colors line-clamp-2">
                        {{ $item->cargo }}
                    </h6>
                    <p class="text-dre-primary text-xs font-bold mb-1 truncate">
                        {{ $item->apenom }}
                    </p>
                    <div class="flex items-center gap-1.5 text-gray-400 text-[11px]">
                        <i data-lucide="mail" class="w-3 h-3 shrink-0"></i>
                        <span class="truncate">{{ $item->email }}</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-gray-400 text-[11px]">
                        <i data-lucide="phone" class="w-3 h-3 shrink-0"></i>
                        <span>{{ $item->celular }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

@endsection
