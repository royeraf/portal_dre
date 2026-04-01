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

        {{-- ── FILTROS ───────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
            <div class="flex items-center gap-2 mb-4">
                <i data-lucide="sliders-horizontal" class="w-4 h-4 text-dre-accent shrink-0"></i>
                <span class="font-display font-bold text-gray-800 text-sm uppercase tracking-wider">Filtrar Convocatorias</span>
            </div>
            <form action="{{ route('convocatoriaweb') }}" method="GET">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">

                    {{-- Tipo --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Tipo de convocatoria
                        </label>
                        <select name="tipo"
                                class="form-select w-full rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-700
                                       px-3 py-2.5 focus:border-dre-accent focus:ring-2 focus:ring-dre-accent/20 focus:outline-none
                                       transition-colors">
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

                    {{-- Búsqueda por título --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Buscar por título
                        </label>
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                            <input type="text" name="buscarTitulo"
                                   value="{{ request('buscarTitulo') }}"
                                   placeholder="Escribe un título..."
                                   class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-700
                                          focus:border-dre-accent focus:ring-2 focus:ring-dre-accent/20 focus:outline-none transition-colors">
                        </div>
                    </div>

                    {{-- Rango de fechas --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Rango de fecha
                        </label>
                        <div class="flex gap-2">
                            <input type="date" name="startDate"
                                   value="{{ request('startDate') }}"
                                   class="flex-1 min-w-0 px-3 py-2.5 rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-700
                                          focus:border-dre-accent focus:ring-2 focus:ring-dre-accent/20 focus:outline-none transition-colors">
                            <input type="date" name="endDate"
                                   value="{{ request('endDate') }}"
                                   class="flex-1 min-w-0 px-3 py-2.5 rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-700
                                          focus:border-dre-accent focus:ring-2 focus:ring-dre-accent/20 focus:outline-none transition-colors">
                        </div>
                    </div>

                </div>

                <div class="flex items-center justify-between gap-3 flex-wrap">
                    <p class="text-xs text-gray-400">
                        <span class="font-semibold text-gray-600">{{ $convocatorias->total() }}</span> convocatoria(s) encontrada(s)
                    </p>
                    <div class="flex gap-2">
                        <a href="{{ route('convocatoriaweb') }}"
                           class="flex items-center gap-1.5 px-4 py-2 rounded-lg border border-gray-200 text-gray-600
                                  text-sm font-medium hover:bg-gray-50 transition-colors">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            Limpiar
                        </a>
                        <button type="submit"
                                class="flex items-center gap-1.5 px-5 py-2 rounded-lg bg-dre-primary text-white
                                       text-sm font-semibold hover:bg-dre-accent transition-colors shadow-sm">
                            <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                            Aplicar filtro
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- ── LISTA DE CONVOCATORIAS ────────────────────────── --}}
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

        @forelse ($convocatorias as $row)
        @php
            $ts      = $tipoStyles[$row->tipo] ?? ['pill'=>'bg-gray-100 text-gray-600','bar'=>'bg-gray-400','hbg'=>'bg-gray-50','hbd'=>'border-gray-100'];
            $abierto = strtoupper($row->estado) === 'ABIERTO';
            $detail  = $row->descripcion || count($row->archivos) > 0;
            $fi      = $row->fecha_inicio  ? \Carbon\Carbon::parse($row->fecha_inicio)->format('d/m/Y')  : '—';
            $ft      = $row->fecha_termino ? \Carbon\Carbon::parse($row->fecha_termino)->format('d/m/Y') : '—';
        @endphp

        {{-- ── CARD ───────────────────────────────────────────── --}}
        <article class="group bg-white rounded-2xl shadow-sm overflow-hidden mb-3
                        border transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5
                        {{ $abierto ? 'border-emerald-200' : 'border-gray-100' }}"
                 x-data="{ expanded: false }">

            {{-- ── ZONE 1: Category header ─────────────────── --}}
            <div class="flex items-center justify-between gap-3 px-5 py-2.5
                        {{ $ts['hbg'] }} border-b {{ $ts['hbd'] }}">

                {{-- Left: tipo pill + estado badge --}}
                <div class="flex items-center gap-2 min-w-0">
                    <span class="shrink-0 inline-flex px-2.5 py-0.5 rounded-md
                                 text-[10px] font-extrabold uppercase tracking-widest {{ $ts['pill'] }}">
                        {{ $row->tipo }}
                    </span>
                    @if($abierto)
                        <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md
                                     text-[10px] font-bold bg-white text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            ABIERTO
                        </span>
                    @else
                        <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md
                                     text-[10px] font-bold bg-white/70 text-gray-400 border border-gray-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                            {{ strtoupper($row->estado) }}
                        </span>
                    @endif
                </div>

            </div>

            {{-- ── ZONE 2: Title ───────────────────────────── --}}
            <div class="px-5 pt-4 pb-3">
                <h3 class="font-display font-bold text-gray-900 text-base sm:text-[17px]
                           leading-snug group-hover:text-dre-accent transition-colors duration-200">
                    {{ $row->titulo }}
                </h3>
            </div>

            {{-- ── ZONE 3: Meta footer ─────────────────────── --}}
            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 px-5 py-3
                        border-t border-gray-100 bg-gray-50/50">

                {{-- Fechas inicio → cierre --}}
                <div class="flex items-center gap-1.5 text-xs text-gray-400">
                    <i data-lucide="calendar-days" class="w-3.5 h-3.5 text-dre-accent shrink-0"></i>
                    <span class="text-gray-400">Inicia:</span>
                    <span class="font-semibold text-gray-600">{{ $fi }}</span>
                    <span class="text-gray-300 mx-0.5">·</span>
                    <i data-lucide="calendar-days" class="w-3.5 h-3.5 shrink-0 {{ $abierto ? 'text-amber-500' : 'text-gray-400' }}"></i>
                    <span class="{{ $abierto ? 'text-amber-500' : 'text-gray-400' }}">Termina:</span>
                    <span class="font-semibold {{ $abierto ? 'text-amber-600' : 'text-gray-600' }}">{{ $ft }}</span>
                </div>

                {{-- File count --}}
                @if(count($row->archivos) > 0)
                <div class="flex items-center gap-1.5 text-xs text-gray-400">
                    <i data-lucide="paperclip" class="w-3.5 h-3.5 shrink-0"></i>
                    <span>{{ count($row->archivos) }} archivo{{ count($row->archivos) > 1 ? 's' : '' }}</span>
                </div>
                @endif

                {{-- Expand CTA --}}
                @if($detail)
                <button @click="expanded = !expanded"
                        class="ml-auto flex items-center gap-1.5 px-4 py-2 rounded-lg
                               text-xs font-bold shadow-sm transition-all duration-200
                               {{ $abierto
                                   ? 'bg-emerald-500 text-white hover:bg-emerald-600 shadow-emerald-200'
                                   : 'bg-dre-primary text-white hover:bg-dre-accent shadow-blue-200' }}"
                        :class="expanded ? 'opacity-80' : ''">
                    <span x-text="expanded ? 'Ocultar' : 'Ver detalle'">Ver detalle</span>
                    <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform duration-300 shrink-0"
                       :class="{ 'rotate-180': expanded }"></i>
                </button>
                @endif

            </div>

            {{-- ── ZONE 4: Expanded detail ─────────────────── --}}
            @if($detail)
            <div x-show="expanded" x-collapse x-cloak>
                <div class="border-t border-gray-100 bg-white px-5 py-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        @if($row->descripcion)
                        <div>
                            <p class="flex items-center gap-1.5 text-[11px] font-bold
                                       text-gray-400 uppercase tracking-wider mb-3">
                                <i data-lucide="file-text" class="w-3.5 h-3.5 shrink-0"></i>
                                Descripción
                            </p>
                            <div class="text-sm text-gray-700 leading-relaxed
                                        [&_p]:mb-2 [&_ul]:list-disc [&_ul]:pl-4 [&_li]:mb-1 [&_strong]:font-semibold">
                                {!! $row->descripcion !!}
                            </div>
                        </div>
                        @endif

                        @if(count($row->archivos) > 0)
                        <div>
                            <p class="flex items-center gap-1.5 text-[11px] font-bold
                                       text-gray-400 uppercase tracking-wider mb-3">
                                <i data-lucide="paperclip" class="w-3.5 h-3.5 shrink-0"></i>
                                Documentos adjuntos
                            </p>
                            <ul class="space-y-2">
                                @foreach ($row->archivos as $archivo)
                                <li>
                                    <a href="{{ $archivo['url_archivo'] }}" target="_blank"
                                       class="flex items-center gap-3 p-3 rounded-xl
                                              border border-gray-100 bg-gray-50
                                              hover:bg-dre-50 hover:border-dre-accent/30
                                              transition-all duration-200 group/file">
                                        <span class="w-8 h-8 rounded-lg bg-red-50 border border-red-100
                                                     flex items-center justify-center shrink-0
                                                     group-hover/file:bg-red-100 transition-colors">
                                            <i data-lucide="file-text" class="w-4 h-4 text-red-500"></i>
                                        </span>
                                        <span class="flex-1 min-w-0 text-xs font-medium text-gray-700
                                                     group-hover/file:text-dre-accent transition-colors truncate">
                                            {{ $archivo['nom_archivo'] }}
                                        </span>
                                        <i data-lucide="external-link"
                                           class="w-3.5 h-3.5 text-gray-300 group-hover/file:text-dre-accent shrink-0 transition-colors"></i>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            @endif

        </article>
        @empty
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
            <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="inbox" class="w-7 h-7 text-gray-400"></i>
            </div>
            <h3 class="font-display font-bold text-gray-700 text-lg mb-1">Sin resultados</h3>
            <p class="text-sm text-gray-400">No se encontraron convocatorias con los filtros aplicados.</p>
            <a href="{{ route('convocatoriaweb') }}"
               class="inline-flex items-center gap-1.5 mt-4 text-sm font-semibold text-dre-accent hover:text-dre-primary transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Ver todas las convocatorias
            </a>
        </div>
        @endforelse

        {{-- ── PAGINACIÓN ────────────────────────────────────── --}}
        @if($convocatorias->hasPages())
        <div class="mt-6">
            {{ $convocatorias->links('pagination::tailwind') }}
        </div>
        @endif

    </div>
</section>

@endsection
