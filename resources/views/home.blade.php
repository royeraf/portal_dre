@extends('principal.plantilla')
@section('title', 'DRE - HUANUCO')
@section('content')

{{-- ── NEWS TICKER ──────────────────────────────────────────── --}}
<div class="bg-yellow-400 overflow-hidden flex items-stretch h-10">

    {{-- Label --}}
    <div class="shrink-0 flex items-center gap-1.5 sm:gap-2 bg-dre-primary text-white px-3 sm:px-5 uppercase tracking-wider whitespace-nowrap">
        <span class="w-1.5 h-1.5 rounded-full bg-red-400 animate-pulse shrink-0"></span>
        <span class="font-display font-bold text-[11px] hidden sm:inline">Últimas Noticias</span>
    </div>

    {{-- Divider arrow --}}
    <svg class="h-10 w-5 shrink-0 text-dre-primary fill-current" viewBox="0 0 20 40" preserveAspectRatio="none">
        <polygon points="0,0 20,20 0,40"/>
    </svg>

    {{-- Ticker --}}
    <div class="overflow-hidden flex-1 relative flex items-center">
        <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-yellow-400 to-transparent z-10 pointer-events-none"></div>
        <div class="animate-ticker inline-flex items-center gap-2 whitespace-nowrap hover:[animation-play-state:paused] px-3">
            @foreach ($noticias as $item)
                <a href="{{ route('noticia', $item->id) }}" target="_blank"
                   class="inline-block bg-white/40 hover:bg-dre-primary hover:text-white text-black/80 text-xs font-semibold px-3 py-1 rounded-full transition-all duration-200 whitespace-nowrap">
                    {{ $item->titulo }}
                </a>
            @endforeach
            @foreach ($noticias as $item)
                <a href="{{ route('noticia', $item->id) }}" target="_blank"
                   class="inline-block bg-white/40 hover:bg-dre-primary hover:text-white text-black/80 text-xs font-semibold px-3 py-1 rounded-full transition-all duration-200 whitespace-nowrap">
                    {{ $item->titulo }}
                </a>
            @endforeach
        </div>
    </div>

</div>

{{-- ── HERO SLIDER ──────────────────────────────────────────── --}}
<section class="sm:px-4 md:px-12 sm:py-3"
         x-data="{ current: 0, total: {{ count($sliders) }}, autoplay: null }"
         x-init="autoplay = setInterval(() => current = (current + 1) % total, 5000)"
         @mouseenter="clearInterval(autoplay)"
         @mouseleave="autoplay = setInterval(() => current = (current + 1) % total, 5000)">
    <div class="relative sm:rounded-2xl overflow-hidden shadow-xl min-h-[42vh] sm:min-h-[52vh] md:min-h-[60vh]">
        @foreach($sliders as $i => $row)
            <div x-show="current === {{ $i }}"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 bg-cover bg-center"
                 style="background-image:url('{{ asset('img/slider/'.$row->img_slider) }}');">
                <div class="absolute inset-0 flex items-center justify-center bg-black/40">
                    <div class="text-center text-white px-6 max-w-3xl mx-auto">
                        <h2 class="font-display text-3xl md:text-5xl font-extrabold uppercase tracking-wider drop-shadow-lg">
                            {{ $row->titulo }}
                        </h2>
                        <p class="mt-3 text-base md:text-lg drop-shadow">
                            {{ Str::lower($row->descripcioncorta) }}
                        </p>
                        @if ($row->link != null && $row->link != '')
                            <a href="{{ $row->link }}"
                               class="mt-5 inline-block bg-yellow-400 text-black font-bold px-8 py-2.5 hover:bg-yellow-300 transition-colors uppercase text-sm tracking-wider rounded">
                                Leer Más
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Controls --}}
        <button @click="current = (current - 1 + total) % total"
                class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white w-10 h-10 rounded-full flex items-center justify-center transition-colors z-10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button @click="current = (current + 1) % total"
                class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white w-10 h-10 rounded-full flex items-center justify-center transition-colors z-10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>

        {{-- Dots --}}
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
            @foreach($sliders as $i => $row)
                <button @click="current = {{ $i }}"
                        :class="current === {{ $i }} ? 'bg-yellow-400 w-6' : 'bg-white/60 w-2'"
                        class="h-2 rounded-full transition-all duration-300"></button>
            @endforeach
        </div>
    </div>
</section>

{{-- ── ACCESOS RÁPIDOS + BANNER EPR ────────────────────────── --}}
<section class="max-w-screen-xl mx-auto px-4 md:px-12 py-5">
    <div class="flex flex-col lg:flex-row gap-5">

        {{-- Grid accesos rápidos --}}
        <div class="flex-1" x-data="{ shown: false }" x-intersect.once="shown = true">

            {{-- Cabecera --}}
            <div class="flex items-center gap-2 mb-3">
                <span class="font-display bg-dre-primary text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">Accesos Rápidos</span>
                <div class="flex-1 h-px bg-blue-200"></div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">

                @php
                $quickLinks = [
                    ['url' => route('directorioweb'),           'icon' => 'users',          'label' => 'Directorio Institucional', 'target' => '_blank',
                     'ibg' => 'bg-blue-100',    'ico' => 'text-blue-600',    'bar' => 'bg-blue-500',    'hbg' => 'group-hover:bg-blue-50/50'],
                    ['url' => '/resoluciones',                   'icon' => 'bar-chart-3',    'label' => 'Resoluciones',             'target' => '_blank',
                     'ibg' => 'bg-indigo-100',  'ico' => 'text-indigo-600',  'bar' => 'bg-indigo-500',  'hbg' => 'group-hover:bg-indigo-50/50'],
                    ['url' => route('documentosdegestionweb'),   'icon' => 'folder-open',    'label' => 'Gestión de Documentos',    'target' => '_blank',
                     'ibg' => 'bg-amber-100',   'ico' => 'text-amber-600',   'bar' => 'bg-amber-500',   'hbg' => 'group-hover:bg-amber-50/50'],
                    ['url' => route('galerias'),                 'icon' => 'camera',         'label' => 'Galería de Imágenes',      'target' => '_blank',
                     'ibg' => 'bg-rose-100',    'ico' => 'text-rose-500',    'bar' => 'bg-rose-500',    'hbg' => 'group-hover:bg-rose-50/50'],
                    // ['url' => '#',                               'icon' => 'heart',          'label' => 'Integridad',               'target' => null,
                    //  'ibg' => 'bg-emerald-100', 'ico' => 'text-emerald-600', 'bar' => 'bg-emerald-500', 'hbg' => 'group-hover:bg-emerald-50/50'],
                    ['url' => '/siagie',                         'icon' => 'pie-chart',      'label' => 'SIAGIE',                   'target' => null,
                     'ibg' => 'bg-cyan-100',    'ico' => 'text-cyan-600',    'bar' => 'bg-cyan-500',    'hbg' => 'group-hover:bg-cyan-50/50'],
                    ['url' => 'https://www.transparencia.gob.pe/reportes_directos/pte_transparencia_info_finan.aspx?id_entidad=14163&id_tema=19&ver=',
                                                                 'icon' => 'dollar-sign',    'label' => 'Presupuesto',              'target' => '_blank',
                     'ibg' => 'bg-green-100',   'ico' => 'text-green-600',   'bar' => 'bg-green-500',   'hbg' => 'group-hover:bg-green-50/50'],
                    ['url' => 'https://www.transparencia.gob.pe/reportes_directos/pte_transparencia_reg_visitas.aspx?id_entidad=14163&ver=&id_tema=500',
                                                                 'icon' => 'clipboard-list', 'label' => 'Registro de Visitas',      'target' => '_blank',
                     'ibg' => 'bg-orange-100',  'ico' => 'text-orange-500',  'bar' => 'bg-orange-500',  'hbg' => 'group-hover:bg-orange-50/50'],
                    // ['url' => '#',                               'icon' => 'book-open',      'label' => 'Aprende Huánuco',          'target' => null,
                    //  'ibg' => 'bg-purple-100',  'ico' => 'text-purple-600',  'bar' => 'bg-purple-500',  'hbg' => 'group-hover:bg-purple-50/50'],
                    ['url' => route('convivenciasinviolencia'),   'icon' => 'newspaper',      'label' => 'Boletín Informativo',      'target' => null,
                     'ibg' => 'bg-red-100',     'ico' => 'text-red-500',     'bar' => 'bg-red-500',     'hbg' => 'group-hover:bg-red-50/50'],
                    ['url' => 'https://drive.google.com/file/d/1HggIH8vWMyCGRxHbyK6-33la7yHcBjcY/view?usp=sharing',
                                                                 'icon' => 'link',           'label' => 'Directorio DRE-UGEL',      'target' => '_blank',
                     'ibg' => 'bg-teal-100',    'ico' => 'text-teal-600',    'bar' => 'bg-teal-500',    'hbg' => 'group-hover:bg-teal-50/50'],
                    ['url' => 'https://gestion.drehuanuco.gob.pe/tablas/evepublics',
                                                                 'icon' => 'calendar-days',  'label' => 'Agenda Directoral',        'target' => '_blank',
                     'ibg' => 'bg-yellow-100',  'ico' => 'text-yellow-600',  'bar' => 'bg-yellow-400',  'hbg' => 'group-hover:bg-yellow-50/50'],
                ];
                @endphp

                @foreach($quickLinks as $i => $link)
                <div :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'"
                     style="transition-delay: {{ $i * 50 }}ms;"
                     class="group rounded-xl bg-white border border-gray-100 shadow-sm overflow-hidden relative
                            hover:shadow-lg hover:-translate-y-1.5 transition-all duration-500 ease-out">
                    {{-- Left accent bar --}}
                    <span class="absolute inset-y-0 left-0 w-[3px] {{ $link['bar'] }}"></span>
                    <a href="{{ $link['url'] }}" @if($link['target']) target="{{ $link['target'] }}" @endif
                       class="flex flex-col items-center gap-2.5 py-4 px-3 w-full min-h-[92px] justify-center
                              {{ $link['hbg'] }} transition-colors duration-200">
                        <span class="{{ $link['ibg'] }} {{ $link['ico'] }} rounded-xl p-2.5
                                     group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="{{ $link['icon'] }}" class="w-5 h-5 block"></i>
                        </span>
                        <span class="text-gray-700 text-[11px] font-semibold text-center leading-tight
                                     group-hover:text-gray-900 transition-colors duration-200 px-1">
                            {{ $link['label'] }}
                        </span>
                    </a>
                </div>
                @endforeach

            </div>
        </div>

        {{-- EPR Banner --}}
        <div class="w-full lg:w-52 flex-shrink-0 flex items-center justify-center">
            <a href="{{ route('epr.index') }}" class="block w-full">
                <div class="relative rounded-xl overflow-hidden border-2 border-blue-700 bg-gradient-to-br from-blue-500 to-blue-800 hover:shadow-xl hover:scale-[1.02] transition-all duration-300 cursor-pointer">
                    <img src="{{ asset('img/per.jpg') }}"
                         alt="EPR - Documentos Digitales"
                         class="w-full object-cover block h-48 sm:h-[270px]">
                    <div class="absolute bottom-3 left-0 right-0 text-center text-white pointer-events-none">
                        <h4 class="font-display font-bold text-xl drop-shadow-lg">EPR</h4>
                        <p class="text-xs drop-shadow">Documentos Digitales</p>
                    </div>
                </div>
            </a>
        </div>

    </div>
</section>

{{-- ── NOTICIAS ─────────────────────────────────────────────── --}}
<section class="bg-gray-50 border-y border-gray-200 py-5">
    <div class="max-w-screen-xl mx-auto px-4 md:px-12"
         x-data="{ page: 0, pages: {{ ceil(count($noticias) / 3) }} }">

        <div class="flex flex-wrap items-center gap-x-2 gap-y-2 mb-4">
            <span class="font-display bg-dre-primary text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">Noticias</span>
            <div class="hidden sm:block flex-1 h-px bg-blue-200"></div>
            <div class="ml-auto flex items-center gap-3">
                <a href="{{ route('allnoticias') }}"
                   class="text-dre-primary text-xs font-semibold flex items-center gap-1 whitespace-nowrap group transition-colors hover:text-dre-accent">
                    <span class="group-hover:underline underline-offset-2">Ver más</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5"></i>
                </a>
                <div class="flex items-center gap-1.5">
                    <button @click="page = (page - 1 + pages) % pages"
                            class="w-8 h-8 rounded-full border-2 border-dre-accent text-dre-accent flex items-center justify-center hover:bg-dre-accent hover:text-white transition-all duration-200">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </button>
                    <span class="text-xs text-gray-400 font-medium tabular-nums w-7 text-center select-none">
                        <span x-text="page + 1"></span>/<span x-text="pages"></span>
                    </span>
                    <button @click="page = (page + 1) % pages"
                            class="w-8 h-8 rounded-full border-2 border-dre-accent text-dre-accent flex items-center justify-center hover:bg-dre-accent hover:text-white transition-all duration-200">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="grid [&>div]:col-start-1 [&>div]:row-start-1">
        @foreach($noticias->chunk(3) as $ci => $chunk)
            <div x-show="page === {{ $ci }}" x-transition.opacity
                 class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($chunk as $item)
                    <a href="{{ route('noticia', $item->id) }}"
                       class="group relative bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl hover:border-transparent transition-all duration-300 flex flex-col">
                        {{-- Imagen con overlay --}}
                        <div class="relative h-48 sm:h-52 overflow-hidden shrink-0 skeleton img-wrap">
                            <img src="{{ asset('img/noticias/'.$item->img1) }}"
                                 alt="{{ $item->titulo }}"
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                            <span class="absolute top-3 left-3 bg-dre-primary text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">
                                Prensa
                            </span>
                            @php $date = date_create($item->fechapubli); @endphp
                            <div class="absolute bottom-3 left-3 flex items-center gap-1 text-white/80 text-[10px]">
                                <i data-lucide="calendar-days" class="w-3 h-3 shrink-0"></i>
                                <time datetime="{{ $item->fechapubli }}">{{ date_format($date, 'd M Y') }}</time>
                            </div>
                        </div>
                        {{-- Contenido --}}
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="font-display text-gray-900 text-base font-bold leading-snug mb-4 group-hover:text-dre-accent transition-colors duration-200">
                                {{ $item->titulo }}
                            </h3>
                            <div class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-[10px] text-gray-400 uppercase tracking-wide font-medium">DRE Huánuco</span>
                                <span class="flex items-center gap-1 text-dre-accent text-xs font-bold group-hover:gap-2 transition-all duration-200">
                                    Leer <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </span>
                            </div>
                        </div>
                        {{-- Barra de acento --}}
                        <div class="h-0.5 bg-dre-accent scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left shrink-0"></div>
                    </a>
                @endforeach
            </div>
        @endforeach
        </div>

    </div>
</section>

{{-- ── ENLACES EXTERNOS ────────────────────────────────────── --}}
<section class="py-5">
    <div class="max-w-screen-xl mx-auto px-4 md:px-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach ($mainrightitem as $item)
                <a href="{{ $item->url }}" title="{{ $item->nombre }}"
                   class="block rounded-xl overflow-hidden shadow hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                    <img src="{{ asset('img/mainright/'.$item->imagen) }}"
                         alt="{{ $item->nombre }}"
                         loading="lazy"
                         class="w-full object-cover max-h-32 sm:max-h-48 md:max-h-[200px]">
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ── CONTADORES ───────────────────────────────────────────── --}}
<section class="bg-blue-900 py-10 bg-cover bg-center"
         style="background-image: url('{{ asset('plantillas/eduglobal/assets/images/pattern_bg4.png') }}')">
    <div class="max-w-screen-xl mx-auto px-4 md:px-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 text-center text-white">

            <div>
                <img src="{{ asset('plantillas/eduglobal/assets/images/counter_icon1.png') }}" alt="" class="h-14 mx-auto mb-3">
                <h3 class="font-display text-4xl font-extrabold"
                    x-data="{ count: 0, target: 252392 }"
                    x-intersect.once="let i = setInterval(() => { count += Math.ceil(target/60); if(count >= target) { count = target; clearInterval(i); } }, 30)"
                    x-text="count.toLocaleString() + '+'">0</h3>
                <a target="_blank" href="https://docs.google.com/spreadsheets/d/1ZsMZTp6z_-k2CJB-31A7gf3UKE0XLfzf/edit?usp=share_link"
                   class="mt-3 inline-flex items-center gap-1.5 bg-yellow-400 text-gray-900
                          text-xs font-black uppercase tracking-wider px-3 py-1.5 rounded-full
                          hover:bg-yellow-300 transition-colors shadow-lg group">
                    <i data-lucide="users" class="w-3.5 h-3.5 shrink-0"></i>
                    Estudiantes
                    <i data-lucide="external-link" class="w-3 h-3 shrink-0 opacity-60 group-hover:opacity-100"></i>
                </a>
            </div>

            <div>
                <img src="{{ asset('plantillas/eduglobal/assets/images/counter_icon2.png') }}" alt="" class="h-14 mx-auto mb-3">
                <h3 class="font-display text-4xl font-extrabold"
                    x-data="{ count: 0, target: 4415 }"
                    x-intersect.once="let i = setInterval(() => { count += Math.ceil(target/60); if(count >= target) { count = target; clearInterval(i); } }, 30)"
                    x-text="count.toLocaleString()">0</h3>
                <a target="_blank" href="https://docs.google.com/spreadsheets/d/1meqfy82jyk-qrXsaWpndBni3jfBf3koZ/edit?usp=share_link"
                   class="mt-3 inline-flex items-center gap-1.5 bg-yellow-400 text-gray-900
                          text-xs font-black uppercase tracking-wider px-3 py-1.5 rounded-full
                          hover:bg-yellow-300 transition-colors shadow-lg group">
                    <i data-lucide="school" class="w-3.5 h-3.5 shrink-0"></i>
                    Colegios
                    <i data-lucide="external-link" class="w-3 h-3 shrink-0 opacity-60 group-hover:opacity-100"></i>
                </a>
            </div>

            <div>
                <img src="{{ asset('plantillas/eduglobal/assets/images/counter_icon3.png') }}" alt="" class="h-14 mx-auto mb-3">
                <h3 class="font-display text-4xl font-extrabold"
                    x-data="{ count: 0, target: 17042 }"
                    x-intersect.once="let i = setInterval(() => { count += Math.ceil(target/60); if(count >= target) { count = target; clearInterval(i); } }, 30)"
                    x-text="count.toLocaleString() + '+'">0</h3>
                <a target="_blank" href="https://docs.google.com/spreadsheets/d/1kM5rohSYy0zS8kqak7sWWflUPun9n6jc/edit?usp=share_link"
                   class="mt-3 inline-flex items-center gap-1.5 bg-yellow-400 text-gray-900
                          text-xs font-black uppercase tracking-wider px-3 py-1.5 rounded-full
                          hover:bg-yellow-300 transition-colors shadow-lg group">
                    <i data-lucide="user-check" class="w-3.5 h-3.5 shrink-0"></i>
                    Docentes
                    <i data-lucide="external-link" class="w-3 h-3 shrink-0 opacity-60 group-hover:opacity-100"></i>
                </a>
            </div>

            <div>
                <img src="{{ asset('plantillas/eduglobal/assets/images/counter_icon4.png') }}" alt="" class="h-14 mx-auto mb-3">
                <h3 class="font-display text-4xl font-extrabold"
                    x-data="{ count: 0, target: 11 }"
                    x-intersect.once="let i = setInterval(() => { count++; if(count >= target) { count = target; clearInterval(i); } }, 100)"
                    x-text="count">0</h3>
                <p class="mt-1 text-blue-200 text-sm">Ugeles</p>
            </div>

        </div>
    </div>
</section>

{{-- ── COMUNICADOS ──────────────────────────────────────────── --}}
<section class="py-5">
    <div class="max-w-screen-xl mx-auto px-4 md:px-12"
         x-data="{ page: 0, pages: {{ ceil(count($comunicados) / 3) }} }">

        <div class="flex flex-wrap items-center gap-x-2 gap-y-2 mb-4">
            <span class="font-display bg-dre-primary text-white text-xs font-bold px-4 py-1.5 rounded-full whitespace-nowrap">Comunicados</span>
            <div class="hidden sm:block flex-1 h-px bg-blue-200"></div>
            <div class="ml-auto flex items-center gap-1.5">
                <button @click="page = (page - 1 + pages) % pages"
                        class="w-8 h-8 rounded-full border-2 border-dre-accent text-dre-accent flex items-center justify-center hover:bg-dre-accent hover:text-white transition-all duration-200">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
                <span class="text-xs text-gray-400 font-medium tabular-nums w-7 text-center select-none">
                    <span x-text="page + 1"></span>/<span x-text="pages"></span>
                </span>
                <button @click="page = (page + 1) % pages"
                        class="w-8 h-8 rounded-full border-2 border-dre-accent text-dre-accent flex items-center justify-center hover:bg-dre-accent hover:text-white transition-all duration-200">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <div class="grid [&>div]:col-start-1 [&>div]:row-start-1">
        @foreach($comunicados->chunk(3) as $ci => $chunk)
            <div x-show="page === {{ $ci }}" x-transition.opacity
                 class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($chunk as $item)
                    <div class="group relative bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl hover:border-transparent transition-all duration-300 flex flex-col">
                        {{-- Imagen con overlay --}}
                        <div class="relative h-48 sm:h-52 overflow-hidden shrink-0 skeleton img-wrap">
                            <img src="{{ asset('img/comunicados/'.$item->imagen) }}"
                                 alt="{{ $item->titulo }}"
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                            <span class="absolute top-3 left-3 bg-dre-primary text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">
                                Comunicado
                            </span>
                        </div>
                        {{-- Contenido --}}
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="font-display text-gray-900 text-base font-bold leading-snug mb-4 group-hover:text-dre-accent transition-colors duration-200">
                                {{ $item->titulo }}
                            </h3>
                            <div class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-[10px] text-gray-400 uppercase tracking-wide font-medium">DRE Huánuco</span>
                                @if($item->url != '' && $item->url != null)
                                    <a href="{{ $item->url }}" target="_blank"
                                       class="flex items-center gap-1 text-dre-accent text-xs font-bold group-hover:gap-2 transition-all duration-200">
                                        Ver Más <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        {{-- Barra de acento --}}
                        <div class="h-0.5 bg-dre-accent scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left shrink-0"></div>
                    </div>
                @endforeach
            </div>
        @endforeach
        </div>

    </div>
</section>

{{-- ── MULTIMEDIA ──────────────────────────────────────────── --}}
<section class="bg-gray-50 py-6 overflow-hidden" data-multimedia>
    <div class="max-w-screen-xl mx-auto px-4 md:px-12">
        <div class="grid grid-cols-1 md:grid-cols-10 gap-4">

            {{-- Videos --}}
            <div class="md:col-span-4 min-w-0 flex flex-col">

                {{-- Cabecera --}}
                <div class="flex items-center gap-2 mb-2">
                    <span class="font-display bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">Galería de Videos</span>
                    <div class="flex-1 h-px bg-blue-200"></div>
                </div>

                {{-- Card --}}
                <div class="rounded-xl border border-gray-200 shadow-sm overflow-hidden bg-white flex flex-col">

                    {{-- Embed --}}
                    <?php foreach ($VideoEmbevidos as $video) { $video->contenido_base64 = base64_encode($video->contenido); } ?>
                    <div class="aspect-video overflow-hidden [&_iframe]:block [&_iframe]:w-full [&_iframe]:h-full [&_iframe]:border-0 skeleton"
                         id="videoPrincipalContainer">
                        @php $primerVideo = $VideoEmbevidos->first(); @endphp
                        {!! $primerVideo->contenido !!}
                    </div>

                    {{-- Playlist header bar --}}
                    <div class="bg-blue-600 px-3 py-1.5 flex items-center gap-2 shrink-0">
                        <svg class="w-3.5 h-3.5 text-white shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9h14V7H3v2zm0 4h14v-2H3v2zm0 4h8v-2H3v2zm16-5v8l6-4-6-4z"/></svg>
                        <span class="text-white text-[11px] font-bold uppercase tracking-wide">Lista de reproducción</span>
                    </div>

                    {{-- Playlist --}}
                    <ul class="divide-y divide-gray-100 overflow-y-auto max-h-40" id="listaVideos">
                        @foreach ($VideoEmbevidos as $video)
                            <li class="px-3 py-2 flex items-center gap-2 text-sm text-gray-700
                                       hover:bg-blue-50 cursor-pointer transition-colors leading-snug"
                                data-video-base64="{{ $video->contenido_base64 }}">
                                <span class="w-5 h-5 rounded-full bg-blue-600 text-white text-[10px]
                                             font-bold flex items-center justify-center shrink-0">{{ $loop->iteration }}</span>
                                {{ $video->titulo }}
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>

            {{-- TikTok --}}
            <div class="md:col-span-3 min-w-0 flex flex-col">
                <div class="flex items-center gap-2 mb-2">
                    <span class="font-display bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">TikTok</span>
                    <div class="flex-1 h-px bg-blue-200"></div>
                </div>
                <div class="rounded-xl border border-gray-200 shadow-sm overflow-hidden flex-1 min-h-[220px] sm:min-h-[300px] skeleton
                            [&_iframe]:w-full [&_iframe]:max-w-full">
                    <blockquote class="tiktok-embed"
                        style="margin:0;padding:0;border:none;"
                        cite="https://www.tiktok.com/@drehuanuco"
                        data-unique-id="drehuanuco"
                        data-embed-from="embed_page"
                        data-embed-type="creator">
                        <section style="margin:0;padding:0;">
                            <a target="_blank" href="https://www.tiktok.com/@drehuanuco?refer=creator_embed">@drehuanuco</a>
                        </section>
                    </blockquote>
                </div>
            </div>

            {{-- Facebook --}}
            <div class="md:col-span-3 min-w-0 flex flex-col">
                <div class="flex items-center gap-2 mb-2">
                    <span class="font-display bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">Facebook</span>
                    <div class="flex-1 h-px bg-blue-200"></div>
                </div>
                <div class="rounded-xl border border-gray-200 shadow-sm overflow-hidden flex-1 min-h-[220px] sm:min-h-[300px] skeleton
                            [&_iframe]:w-full [&_iframe]:max-w-full">
                    <div class="fb-page"
                         data-href="https://www.facebook.com/direccionregionaldeeducacion"
                         data-tabs="timeline"
                         data-width=""
                         data-height=""
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

        </div>
    </div>
</section>

{{-- ── POPUP ────────────────────────────────────────────────── --}}
@if(isset($popup))
@php
    $popupLinks = $imagenes->pluck('enlace')->toArray();
@endphp
<div x-data="{ open: true }" x-show="open" x-transition.opacity x-cloak
     class="fixed inset-0 z-[9998] flex items-end sm:items-center justify-center bg-black/60 p-4 sm:p-6"
     @click.self="open = false">

    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="bg-white w-full sm:max-w-lg rounded-2xl shadow-2xl flex flex-col
                max-h-[88dvh] sm:max-h-[88vh] overflow-hidden">

        {{-- Barra superior --}}
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 shrink-0">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                {{ $popup->titulopopup ?? 'Comunicado' }}
            </span>
            <button @click="open = false" type="button"
                    class="flex items-center gap-1.5 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white text-xs font-semibold px-3 py-1.5 rounded-full transition-colors active:scale-95">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                Cerrar
            </button>
        </div>

        <div x-data="{ slide: 0, total: {{ count($imagenes) }}, links: {{ json_encode($popupLinks) }} }"
             class="flex flex-col flex-1 min-h-0">

            {{-- Imagen --}}
            <div class="relative flex-1 min-h-0 overflow-hidden bg-gray-50">
                @foreach($imagenes as $ri => $row)
                    <div x-show="slide === {{ $ri }}" x-transition.opacity class="h-full">
                        <img src="{{ asset('img/popup/'.$row->imagen) }}"
                             class="w-full h-full object-contain cursor-pointer"
                             alt="{{ $popup->titulopopup ?? '' }}"
                             @click="if(links[slide]) window.open(links[slide], '_blank')">
                    </div>
                @endforeach

                {{-- Flechas de navegación --}}
                <button x-show="total > 1" @click="slide = (slide - 1 + total) % total" type="button"
                        class="absolute left-2 top-1/2 -translate-y-1/2 z-20
                               bg-black/40 hover:bg-black/60 active:bg-black/70
                               text-white w-10 h-10 rounded-full
                               flex items-center justify-center transition-colors shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button x-show="total > 1" @click="slide = (slide + 1) % total" type="button"
                        class="absolute right-2 top-1/2 -translate-y-1/2 z-20
                               bg-black/40 hover:bg-black/60 active:bg-black/70
                               text-white w-10 h-10 rounded-full
                               flex items-center justify-center transition-colors shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>

                {{-- Indicadores de slide --}}
                <div x-show="total > 1" class="absolute bottom-2 left-0 right-0 flex justify-center gap-1.5 z-20">
                    @foreach($imagenes as $ri => $row)
                        <button @click="slide = {{ $ri }}" type="button"
                                class="w-2 h-2 rounded-full transition-all"
                                :class="slide === {{ $ri }} ? 'bg-white scale-125' : 'bg-white/50'">
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Botón CTA --}}
            <div x-show="links[slide] && links[slide].length > 0"
                 class="px-4 py-3 bg-white border-t border-gray-100 shrink-0">
                <a :href="links[slide]" target="_blank"
                   class="flex items-center justify-center gap-2 w-full
                          bg-dre-primary hover:bg-dre-accent active:bg-dre-primary
                          text-white font-semibold text-sm py-3 px-4 rounded-xl
                          transition-colors shadow-sm">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Ver Comunicado Completo
                </a>
            </div>

        </div>
    </div>
</div>
@endif

{{-- ── VISITAS ──────────────────────────────────────────────── --}}
<div class="fixed bottom-0 left-0 z-50 bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded-tr-lg shadow-lg">
    Visitas: {{ $contador }}
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var listaVideos = document.getElementById('listaVideos');
    var videoPrincipalContainer = document.getElementById('videoPrincipalContainer');

    function removeVideoSkeleton() {
        var iframe = videoPrincipalContainer.querySelector('iframe');
        if (iframe) iframe.addEventListener('load', function() {
            videoPrincipalContainer.classList.remove('skeleton');
        });
    }

    if (listaVideos && videoPrincipalContainer) {
        removeVideoSkeleton();
        listaVideos.addEventListener('click', function (e) {
            var li = e.target.closest('li[data-video-base64]');
            if (li) {
                videoPrincipalContainer.classList.add('skeleton');
                videoPrincipalContainer.innerHTML = atob(li.getAttribute('data-video-base64'));
                removeVideoSkeleton();
            }
        });
    }
});
</script>

<script>
// Lazy-load Facebook SDK + TikTok embed only when multimedia section enters viewport
(function () {
    var section = document.querySelector('[data-multimedia]');
    if (!section) return;
    var loaded = false;
    var observer = new IntersectionObserver(function (entries) {
        if (entries[0].isIntersecting && !loaded) {
            loaded = true;
            observer.disconnect();

            // Facebook SDK
            window.fbAsyncInit = function () { FB.init({ xfbml: true, version: 'v21.0' }); };
            var fbRoot = document.createElement('div'); fbRoot.id = 'fb-root';
            document.body.prepend(fbRoot);
            var fbScript = document.createElement('script');
            fbScript.async = fbScript.defer = true;
            fbScript.crossOrigin = 'anonymous';
            fbScript.src = 'https://connect.facebook.net/es_ES/sdk.js';
            document.body.appendChild(fbScript);

            // TikTok
            var ttScript = document.createElement('script');
            ttScript.async = true;
            ttScript.src = 'https://www.tiktok.com/embed.js';
            document.body.appendChild(ttScript);
        }
    }, { rootMargin: '300px' });
    observer.observe(section);
}());
</script>
@endpush
