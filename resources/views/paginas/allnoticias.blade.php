@extends('principal.plantilla')
@section('title', 'Noticias — DRE Huánuco')
@section('content')

<section class="max-w-screen-xl mx-auto px-4 md:px-12 py-10">

    {{-- ── Encabezado de sección ─────────────────────────────── --}}
    <div class="flex items-center gap-3 mb-8">
        <span class="font-display bg-dre-primary text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap tracking-wide uppercase">
            Noticias
        </span>
        <div class="flex-1 h-px bg-blue-200"></div>
        <span class="font-mono text-[10px] tracking-widest uppercase text-gray-400 hidden sm:inline shrink-0">
            DRE Huánuco
        </span>
    </div>

    {{-- ── Grid de noticias ──────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach ($noticias as $item)
        @php
            $date = date_create($item->fechapubli);
        @endphp

        <article class="group bg-white rounded-2xl border border-gray-100 shadow-sm
                        hover:shadow-xl hover:-translate-y-1.5
                        transition-all duration-300 overflow-hidden flex flex-col">

            {{-- Imagen --}}
            <a href="{{ route('noticia', $item->id) }}" class="block relative overflow-hidden aspect-[16/9] shrink-0">
                <img src="{{ asset('img/noticias/'.$item->img1) }}"
                     alt="{{ $item->titulo }}"
                     loading="lazy"
                     class="w-full h-full object-cover
                            group-hover:scale-105 transition-transform duration-500 ease-out">

                {{-- Degradado inferior --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent pointer-events-none"></div>

                {{-- Fecha sobre la imagen --}}
                <span class="absolute bottom-2 right-2 bg-yellow-400 text-black text-[10px] font-bold
                             px-2 py-0.5 rounded font-mono tracking-wide">
                    {{ $date ? date_format($date, 'd/m/Y') : '' }}
                </span>
            </a>

            {{-- Contenido --}}
            <div class="flex flex-col flex-1 p-4 gap-2">

                {{-- Acento lateral + título --}}
                <div class="flex gap-2 items-start">
                    <span class="mt-1.5 shrink-0 w-[3px] h-4 bg-dre-primary rounded-full"></span>
                    <h3 class="font-display font-bold text-gray-800 text-sm leading-snug
                               group-hover:text-dre-accent transition-colors duration-200 line-clamp-2">
                        <a href="{{ route('noticia', $item->id) }}" title="{{ $item->titulo }}">
                            {{ $item->titulo }}
                        </a>
                    </h3>
                </div>

                {{-- Descripción corta --}}
                <p class="text-gray-500 text-xs leading-relaxed line-clamp-2 pl-[11px]">
                    {{ $item->descripcioncorta }}
                </p>

                {{-- Spacer + CTA --}}
                <div class="mt-auto pt-3 pl-[11px]">
                    <a href="{{ route('noticia', $item->id) }}"
                       class="inline-flex items-center gap-1.5 text-dre-primary hover:text-dre-accent
                              text-xs font-semibold transition-colors duration-200 group/link">
                        Ver más
                        <svg class="w-3.5 h-3.5 group-hover/link:translate-x-0.5 transition-transform duration-200"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

            </div>

        </article>
        @endforeach

    </div>

    {{-- ── Paginación ────────────────────────────────────────── --}}
    @if ($noticias->hasPages())
    <div class="mt-6">
        {{ $noticias->links('pagination::tailwind') }}
    </div>
    @endif

</section>

@endsection
