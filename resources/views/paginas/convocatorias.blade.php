@extends('principal.plantilla')
@section('title', 'Convocatorias — DRE Huánuco')
@section('content')

{{-- ── BREADCRUMB HERO ──────────────────────────────────────── --}}
<div class="relative h-36 sm:h-52 bg-cover bg-center overflow-hidden"
     style="background-image: url('{{ asset('img/bc.jpeg') }}')">
    <div class="absolute inset-0 bg-dre-dark/80"></div>
    <div class="relative h-full max-w-screen-xl mx-auto px-4 md:px-8 flex flex-col justify-center">
        <h1 class="font-display text-white text-3xl sm:text-4xl font-extrabold uppercase tracking-widest drop-shadow-lg">
            Convocatorias
        </h1>
        <nav class="flex items-center gap-1.5 text-xs text-white/60 mt-2">
            <a href="/" class="hover:text-yellow-400 transition-colors">Home</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white/90">Convocatorias</span>
        </nav>
    </div>
</div>

{{-- ── CONTENIDO ────────────────────────────────────────────── --}}
<section class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8">

        {{-- ── WRAPPER ALPINE ───────────────────────────────── --}}
        <div
            x-data="{
                view:  localStorage.getItem('conv_view') || 'list',
                modal: null,
                openModal(data)  { this.modal = data; document.body.style.overflow = 'hidden'; },
                closeModal()     { this.modal = null; document.body.style.overflow = ''; }
            }"
            x-init="$watch('view', v => localStorage.setItem('conv_view', v))"
            @keydown.escape.window="closeModal()">

            {{-- ── FILTROS ───────────────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <div class="flex items-center gap-2">
                        <i data-lucide="sliders-horizontal" class="w-4 h-4 text-dre-accent shrink-0"></i>
                        <span class="font-display font-bold text-gray-800 text-sm uppercase tracking-wider">Filtrar Convocatorias</span>
                    </div>
                    <div class="flex items-center gap-1 shrink-0">
                        <button @click="view = 'list'"
                                :class="view === 'list' ? 'bg-dre-primary text-white shadow-sm' : 'bg-gray-100 text-gray-400 hover:text-gray-600 hover:bg-gray-200'"
                                class="p-2 rounded-lg transition-all duration-200" title="Vista lista">
                            <i data-lucide="list" class="w-4 h-4 pointer-events-none"></i>
                        </button>
                        <button @click="view = 'grid'"
                                :class="view === 'grid' ? 'bg-dre-primary text-white shadow-sm' : 'bg-gray-100 text-gray-400 hover:text-gray-600 hover:bg-gray-200'"
                                class="p-2 rounded-lg transition-all duration-200" title="Vista cuadrícula">
                            <i data-lucide="layout-grid" class="w-4 h-4 pointer-events-none"></i>
                        </button>
                    </div>
                </div>

                <form action="{{ route('convocatoriaweb') }}" method="GET">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tipo de convocatoria</label>
                            <select name="tipo" class="form-select w-full rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-700 px-3 py-2.5 focus:border-dre-accent focus:ring-2 focus:ring-dre-accent/20 focus:outline-none transition-colors">
                                <option value="">Todas las convocatorias</option>
                                <option value="CAS"                {{ request('tipo') == 'CAS'                ? 'selected' : '' }}>CAS</option>
                                <option value="CAP"                {{ request('tipo') == 'CAP'                ? 'selected' : '' }}>CAP</option>
                                <option value="DOCENTE"            {{ request('tipo') == 'DOCENTE'            ? 'selected' : '' }}>Docente</option>
                                <option value="DIRECTIVO"          {{ request('tipo') == 'DIRECTIVO'          ? 'selected' : '' }}>Directivo</option>
                                <option value="LOCACION DE SERVICIO" {{ request('tipo') == 'LOCACION DE SERVICIO' ? 'selected' : '' }}>Locación de servicio</option>
                                <option value="REASIGNACION"       {{ request('tipo') == 'REASIGNACION'       ? 'selected' : '' }}>Reasignación</option>
                                <option value="276"                {{ request('tipo') == '276'                ? 'selected' : '' }}>276</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Buscar por título</label>
                            <div class="relative">
                                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                                <input type="text" name="buscarTitulo" value="{{ request('buscarTitulo') }}" placeholder="Escribe un título..."
                                       class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-700 focus:border-dre-accent focus:ring-2 focus:ring-dre-accent/20 focus:outline-none transition-colors">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Rango de fecha</label>
                            <div class="flex gap-2">
                                <input type="date" name="startDate" value="{{ request('startDate') }}"
                                       class="flex-1 min-w-0 px-3 py-2.5 rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-700 focus:border-dre-accent focus:ring-2 focus:ring-dre-accent/20 focus:outline-none transition-colors">
                                <input type="date" name="endDate" value="{{ request('endDate') }}"
                                       class="flex-1 min-w-0 px-3 py-2.5 rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-700 focus:border-dre-accent focus:ring-2 focus:ring-dre-accent/20 focus:outline-none transition-colors">
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <p class="text-xs text-gray-400">
                            <span class="font-semibold text-gray-600">{{ $convocatorias->total() }}</span> convocatoria(s) encontrada(s)
                        </p>
                        <div class="flex gap-2">
                            <a href="{{ route('convocatoriaweb') }}" class="flex items-center gap-1.5 px-4 py-2 rounded-lg border border-gray-200 text-gray-600 text-sm font-medium hover:bg-gray-50 transition-colors">
                                <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                Limpiar
                            </a>
                            <button type="submit" class="flex items-center gap-1.5 px-5 py-2 rounded-lg bg-dre-primary text-white text-sm font-semibold hover:bg-dre-accent transition-colors shadow-sm">
                                <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                                Aplicar filtro
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- ── CARDS ─────────────────────────────────────── --}}
            @php
            $tipoStyles = [
                'CAS'                  => ['pill'=>'bg-blue-100 text-blue-700',      'bar'=>'bg-blue-500',    'hbg'=>'bg-blue-50',    'hbd'=>'border-blue-100'],
                'CAP'                  => ['pill'=>'bg-indigo-100 text-indigo-700',  'bar'=>'bg-indigo-500',  'hbg'=>'bg-indigo-50',  'hbd'=>'border-indigo-100'],
                'DOCENTE'              => ['pill'=>'bg-emerald-100 text-emerald-700','bar'=>'bg-emerald-500', 'hbg'=>'bg-emerald-50', 'hbd'=>'border-emerald-100'],
                'DIRECTIVO'            => ['pill'=>'bg-dre-50 text-dre-primary',     'bar'=>'bg-dre-primary', 'hbg'=>'bg-dre-50',     'hbd'=>'border-dre-primary/20'],
                'LOCACION DE SERVICIO' => ['pill'=>'bg-amber-100 text-amber-700',    'bar'=>'bg-amber-500',   'hbg'=>'bg-amber-50',   'hbd'=>'border-amber-100'],
                'REASIGNACION'         => ['pill'=>'bg-orange-100 text-orange-700',  'bar'=>'bg-orange-500',  'hbg'=>'bg-orange-50',  'hbd'=>'border-orange-100'],
                '276'                  => ['pill'=>'bg-purple-100 text-purple-700',  'bar'=>'bg-purple-500',  'hbg'=>'bg-purple-50',  'hbd'=>'border-purple-100'],
            ];
            @endphp

            <div :class="view === 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4' : 'flex flex-col gap-3'">

                @forelse ($convocatorias as $row)
                @php
                    $ts      = $tipoStyles[$row->tipo] ?? ['pill'=>'bg-gray-100 text-gray-600','bar'=>'bg-gray-400','hbg'=>'bg-gray-50','hbd'=>'border-gray-100'];
                    $abierto = strtoupper($row->estado) === 'ABIERTO';
                    $detail  = $row->descripcion || count($row->archivos) > 0;
                    $fi      = $row->fecha_inicio  ? \Carbon\Carbon::parse($row->fecha_inicio)->format('d/m/Y')  : '—';
                    $ft      = $row->fecha_termino ? \Carbon\Carbon::parse($row->fecha_termino)->format('d/m/Y') : '—';
                    $mdata   = [
                        'tipo'        => $row->tipo,
                        'pill'        => $ts['pill'],
                        'hbg'         => $ts['hbg'],
                        'hbd'         => $ts['hbd'],
                        'titulo'      => $row->titulo,
                        'estado'      => strtoupper($row->estado),
                        'abierto'     => $abierto,
                        'fi'          => $fi,
                        'ft'          => $ft,
                        'descripcion' => $row->descripcion,
                        'archivos'    => collect($row->archivos)->map(fn($a) => [
                            'nom' => $a['nom_archivo'],
                            'url' => $a['url_archivo'],
                        ])->values()->toArray(),
                    ];
                @endphp

                <article class="group bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col
                                border transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5
                                {{ $abierto ? 'border-emerald-200' : 'border-gray-100' }}">

                    {{-- Zone 1: Category header --}}
                    <div class="flex items-center gap-2 px-5 py-2.5 {{ $ts['hbg'] }} border-b {{ $ts['hbd'] }}">
                        <span class="shrink-0 inline-flex px-2.5 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-widest {{ $ts['pill'] }}">
                            {{ $row->tipo }}
                        </span>
                        @if($abierto)
                            <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-white text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                ABIERTO
                            </span>
                        @else
                            <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-white/70 text-gray-400 border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                                {{ strtoupper($row->estado) }}
                            </span>
                        @endif
                    </div>

                    {{-- Zone 2: Title --}}
                    <div :class="view === 'grid' ? 'px-4 pt-3 pb-2' : 'px-5 pt-4 pb-3'">
                        <h3 class="font-display font-bold text-gray-900 leading-snug group-hover:text-dre-accent transition-colors duration-200"
                            :class="view === 'grid' ? 'text-sm line-clamp-3' : 'text-base sm:text-[17px]'">
                            {{ $row->titulo }}
                        </h3>
                    </div>

                    {{-- Zone 3: Meta + CTA --}}
                    <div class="mt-auto border-t border-gray-100 bg-gray-50/50"
                         :class="view === 'grid' ? 'px-4 py-3' : 'flex flex-wrap items-center gap-x-4 gap-y-2 px-5 py-3'">

                        {{-- Lista --}}
                        <template x-if="view === 'list'">
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 w-full">
                                <div class="flex items-center gap-1.5 text-xs text-gray-400">
                                    <i data-lucide="calendar-days" class="w-3.5 h-3.5 text-dre-accent shrink-0"></i>
                                    <span>Inicia: <span class="font-semibold text-gray-600">{{ $fi }}</span></span>
                                    <span class="text-gray-300 mx-0.5">·</span>
                                    <i data-lucide="calendar-days" class="w-3.5 h-3.5 {{ $abierto ? 'text-amber-500' : 'text-gray-400' }} shrink-0"></i>
                                    <span class="{{ $abierto ? 'text-amber-500' : '' }}">Termina: <span class="font-semibold {{ $abierto ? 'text-amber-600' : 'text-gray-600' }}">{{ $ft }}</span></span>
                                </div>
                                @if(count($row->archivos) > 0)
                                <div class="flex items-center gap-1.5 text-xs text-gray-400">
                                    <i data-lucide="paperclip" class="w-3.5 h-3.5 shrink-0"></i>
                                    <span>{{ count($row->archivos) }} archivo{{ count($row->archivos) > 1 ? 's' : '' }}</span>
                                </div>
                                @endif
                                @if($detail)
                                <button data-modal="{{ json_encode($mdata) }}"
                                        @click="openModal(JSON.parse($el.dataset.modal))"
                                        class="ml-auto flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition-all duration-200
                                               {{ $abierto ? 'bg-emerald-500 text-white hover:bg-emerald-600 shadow-emerald-200' : 'bg-dre-primary text-white hover:bg-dre-accent shadow-blue-200' }}">
                                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Ver detalle
                                </button>
                                @endif
                            </div>
                        </template>

                        {{-- Cuadrícula --}}
                        <template x-if="view === 'grid'">
                            <div class="w-full space-y-2">
                                <div class="flex flex-col gap-1 text-[11px] text-gray-400">
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="calendar-days" class="w-3 h-3 text-dre-accent shrink-0"></i>
                                        <span>Inicia: <span class="font-semibold text-gray-600">{{ $fi }}</span></span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="calendar-days" class="w-3 h-3 {{ $abierto ? 'text-amber-500' : 'text-gray-400' }} shrink-0"></i>
                                        <span class="{{ $abierto ? 'text-amber-500' : '' }}">Termina: <span class="font-semibold {{ $abierto ? 'text-amber-600' : 'text-gray-600' }}">{{ $ft }}</span></span>
                                    </div>
                                    @if(count($row->archivos) > 0)
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="paperclip" class="w-3 h-3 shrink-0"></i>
                                        <span>{{ count($row->archivos) }} archivo{{ count($row->archivos) > 1 ? 's' : '' }}</span>
                                    </div>
                                    @endif
                                </div>
                                @if($detail)
                                <button data-modal="{{ json_encode($mdata) }}"
                                        @click="openModal(JSON.parse($el.dataset.modal))"
                                        class="w-full flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-xs font-bold shadow-sm transition-all duration-200
                                               {{ $abierto ? 'bg-emerald-500 text-white hover:bg-emerald-600 shadow-emerald-200' : 'bg-dre-primary text-white hover:bg-dre-accent shadow-blue-200' }}">
                                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Ver detalle
                                </button>
                                @endif
                            </div>
                        </template>

                    </div>
                </article>

                @empty
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center col-span-full">
                    <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="inbox" class="w-7 h-7 text-gray-400"></i>
                    </div>
                    <h3 class="font-display font-bold text-gray-700 text-lg mb-1">Sin resultados</h3>
                    <p class="text-sm text-gray-400">No se encontraron convocatorias con los filtros aplicados.</p>
                    <a href="{{ route('convocatoriaweb') }}" class="inline-flex items-center gap-1.5 mt-4 text-sm font-semibold text-dre-accent hover:text-dre-primary transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Ver todas las convocatorias
                    </a>
                </div>
                @endforelse

            </div>

            {{-- ── PAGINACIÓN ────────────────────────────────── --}}
            @if($convocatorias->hasPages())
            <div class="mt-6">
                {{ $convocatorias->links('pagination::tailwind') }}
            </div>
            @endif

            {{-- ══════════════════════════════════════════════ --}}
            {{-- ── MODAL ────────────────────────────────────── --}}
            {{-- ══════════════════════════════════════════════ --}}
            <div x-show="modal"
                 x-cloak
                 class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4"
                 role="dialog" aria-modal="true">

                {{-- Backdrop --}}
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
                     x-show="modal"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="closeModal()">
                </div>

                {{-- Panel: wrapper exterior recorta el scrollbar con overflow-hidden + border-radius --}}
                <div class="relative w-full sm:max-w-2xl rounded-t-2xl sm:rounded-2xl shadow-2xl overflow-hidden"
                     x-show="modal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
                     @click.stop>
                {{-- Interior: scrollea aquí, el scrollbar queda dentro del border-radius --}}
                <div class="bg-white overflow-y-auto max-h-[92dvh] sm:max-h-[85vh]
                            [&::-webkit-scrollbar]:w-1.5
                            [&::-webkit-scrollbar-track]:bg-gray-100
                            [&::-webkit-scrollbar-thumb]:rounded-full
                            [&::-webkit-scrollbar-thumb]:bg-gray-300">

                    {{-- Header: sticky top-0 — siempre visible --}}
                    <div class="sticky top-0 z-20 flex items-start justify-between gap-4 px-6 py-4 border-b border-black/5"
                         :class="modal?.hbg ?? 'bg-white'">
                        <div class="flex flex-col gap-2 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="inline-flex px-2.5 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-widest"
                                      :class="modal?.pill"
                                      x-text="modal?.tipo">
                                </span>
                                <template x-if="modal?.abierto">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-white text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        ABIERTO
                                    </span>
                                </template>
                                <template x-if="!modal?.abierto">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-white/80 text-gray-400 border border-gray-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                                        <span x-text="modal?.estado"></span>
                                    </span>
                                </template>
                            </div>
                            <h2 class="font-display font-bold text-gray-900 text-base sm:text-lg leading-snug"
                                x-text="modal?.titulo">
                            </h2>
                        </div>
                        <button @click="closeModal()"
                                class="shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-black/5 hover:bg-black/10 text-gray-500 hover:text-gray-800 transition-all duration-200 mt-0.5">
                            <i data-lucide="x" class="w-4 h-4 pointer-events-none"></i>
                        </button>
                    </div>

                    {{-- Meta (fechas) — scrollea con el contenido --}}
                    <div class="flex flex-wrap items-center gap-x-5 gap-y-1.5 px-6 py-3 bg-gray-50 border-b border-gray-100 text-xs">
                        <div class="flex items-center gap-1.5 text-gray-500">
                            <i data-lucide="calendar-days" class="w-3.5 h-3.5 text-dre-accent shrink-0"></i>
                            Inicia: <span class="font-semibold text-gray-700 ml-1" x-text="modal?.fi"></span>
                        </div>
                        <div class="flex items-center gap-1.5"
                             :class="modal?.abierto ? 'text-amber-500' : 'text-gray-500'">
                            <i data-lucide="calendar-days" class="w-3.5 h-3.5 shrink-0"></i>
                            Termina: <span class="font-semibold ml-1"
                                          :class="modal?.abierto ? 'text-amber-600' : 'text-gray-700'"
                                          x-text="modal?.ft"></span>
                        </div>
                    </div>

                    {{-- Cuerpo — scrollea con el contenido --}}
                    <div class="px-6 py-5 space-y-6">

                        {{-- Descripción --}}
                        <template x-if="modal?.descripcion">
                            <div>
                                <p class="flex items-center gap-1.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3">
                                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>
                                    Descripción
                                </p>
                                <div class="text-sm text-gray-700 leading-relaxed prose prose-sm max-w-none"
                                     x-html="modal?.descripcion">
                                </div>
                            </div>
                        </template>

                        {{-- Archivos --}}
                        <template x-if="modal?.archivos?.length > 0">
                            <div>
                                <p class="flex items-center gap-1.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3">
                                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                                    Documentos adjuntos
                                    (<span x-text="modal?.archivos?.length"></span>)
                                </p>
                                <ul class="space-y-2">
                                    <template x-for="(archivo, i) in modal?.archivos" :key="i">
                                        <li>
                                            <a :href="archivo.url" target="_blank"
                                               class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50
                                                      hover:bg-dre-50 hover:border-dre-accent/30 transition-all duration-200 group/file">
                                                <span class="w-8 h-8 rounded-lg bg-red-50 border border-red-100 flex items-center justify-center shrink-0 group-hover/file:bg-red-100 transition-colors">
                                                    <svg class="w-4 h-4 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>
                                                </span>
                                                <span class="flex-1 min-w-0 text-xs font-medium text-gray-700 group-hover/file:text-dre-accent transition-colors truncate"
                                                      x-text="archivo.nom">
                                                </span>
                                                <svg class="w-3.5 h-3.5 text-gray-300 group-hover/file:text-dre-accent shrink-0 transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
                                            </a>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </template>

                    </div>

                    {{-- Footer: sticky bottom-0 — siempre visible --}}
                    <div class="sticky bottom-0 z-20 px-6 py-4 border-t border-gray-100 bg-gray-50/95 backdrop-blur-sm flex justify-end">
                        <button @click="closeModal()"
                                class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-dre-primary text-white text-sm font-semibold hover:bg-dre-accent transition-colors shadow-sm">
                            <i data-lucide="x" class="w-4 h-4 pointer-events-none"></i>
                            Cerrar
                        </button>
                    </div>

                </div>{{-- fin interior scrollable --}}
                </div>{{-- fin wrapper exterior --}}
            </div>
            {{-- ── FIN MODAL ─────────────────────────────────── --}}

        </div>{{-- fin x-data --}}
    </div>
</section>

@endsection
