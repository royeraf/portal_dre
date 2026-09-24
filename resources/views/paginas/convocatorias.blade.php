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
            x-data="{ view: localStorage.getItem('conv_view') || 'grid' }"
            x-init="$watch('view', v => { localStorage.setItem('conv_view', v); $nextTick(() => reInitLucideIcons()); })">

            {{-- ── FILTROS ───────────────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-slate-100/90 shadow-[0_4px_24px_-4px_rgba(1,48,114,0.04)] p-5 mb-6">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <div class="flex items-center gap-2">
                        <i data-lucide="sliders-horizontal" class="w-4 h-4 text-dre-accent shrink-0"></i>
                        <span class="font-display font-bold text-gray-800 text-sm uppercase tracking-wider">Filtrar Convocatorias</span>
                    </div>
                    <div class="hidden sm:flex items-center gap-1 shrink-0">
                        <button @click="view = 'grid'"
                                :class="view === 'grid' ? 'bg-dre-primary text-white shadow-sm' : 'bg-gray-100 text-gray-400 hover:text-gray-600 hover:bg-gray-200'"
                                class="p-2 rounded-lg transition-all duration-200" title="Vista cuadrícula">
                            <i data-lucide="layout-grid" class="w-4 h-4 pointer-events-none"></i>
                        </button>
                        <button @click="view = 'list'"
                                :class="view === 'list' ? 'bg-dre-primary text-white shadow-sm' : 'bg-gray-100 text-gray-400 hover:text-gray-600 hover:bg-gray-200'"
                                class="p-2 rounded-lg transition-all duration-200" title="Vista lista">
                            <i data-lucide="list" class="w-4 h-4 pointer-events-none"></i>
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
                'LOCACION DE SERVICIO' => ['pill'=>'bg-teal-100 text-teal-700',      'bar'=>'bg-teal-500',    'hbg'=>'bg-teal-50',    'hbd'=>'border-teal-100'],
                'LOCACION DE SERVICIOS'=> ['pill'=>'bg-teal-100 text-teal-700',      'bar'=>'bg-teal-500',    'hbg'=>'bg-teal-50',    'hbd'=>'border-teal-100'],
                'REASIGNACION'         => ['pill'=>'bg-orange-100 text-orange-700',  'bar'=>'bg-orange-500',  'hbg'=>'bg-orange-50',  'hbd'=>'border-orange-100'],
                'ROTACION'             => ['pill'=>'bg-lime-100 text-lime-700',      'bar'=>'bg-lime-500',    'hbg'=>'bg-lime-50',    'hbd'=>'border-lime-100'],
                '275'                  => ['pill'=>'bg-rose-100 text-rose-700',      'bar'=>'bg-rose-500',    'hbg'=>'bg-rose-50',    'hbd'=>'border-rose-100'],
                '276'                  => ['pill'=>'bg-purple-100 text-purple-700',  'bar'=>'bg-purple-500',  'hbg'=>'bg-purple-50',  'hbd'=>'border-purple-100'],
                'CAS DETERMINADO'      => ['pill'=>'bg-sky-100 text-sky-700',        'bar'=>'bg-sky-500',     'hbg'=>'bg-sky-50',     'hbd'=>'border-sky-100'],
                'CAS DIRECTIVO'        => ['pill'=>'bg-fuchsia-100 text-fuchsia-700','bar'=>'bg-fuchsia-500', 'hbg'=>'bg-fuchsia-50', 'hbd'=>'border-fuchsia-100'],
                'CAS TRANSITORIO'      => ['pill'=>'bg-amber-100 text-amber-700',    'bar'=>'bg-amber-500',   'hbg'=>'bg-amber-50',   'hbd'=>'border-amber-100'],
                'CONVOCATORIA'         => ['pill'=>'bg-cyan-100 text-cyan-700',      'bar'=>'bg-cyan-500',    'hbg'=>'bg-cyan-50',    'hbd'=>'border-cyan-100'],
                'LOCACIÓN'             => ['pill'=>'bg-teal-100 text-teal-700',      'bar'=>'bg-teal-500',    'hbg'=>'bg-teal-50',    'hbd'=>'border-teal-100'],
                'LOCACIÓN DE SERVICIO' => ['pill'=>'bg-teal-100 text-teal-700',      'bar'=>'bg-teal-500',    'hbg'=>'bg-teal-50',    'hbd'=>'border-teal-100'],
            ];
            @endphp

            <div :class="view === 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4' : 'flex flex-col gap-4'">

                @forelse ($convocatorias as $row)
                @php
                    $ts         = $tipoStyles[$row->tipo] ?? ['pill'=>'bg-gray-100 text-gray-600','bar'=>'bg-gray-400','hbg'=>'bg-gray-50','hbd'=>'border-gray-100'];
                    $abierto    = strtoupper($row->estado) === 'ABIERTO';
                    $detail     = $row->descripcion || count($row->archivos) > 0;
                    $fi         = $row->fecha_inicio  ? \Carbon\Carbon::parse($row->fecha_inicio)->format('d/m/Y')  : '—';
                    $ft         = $row->fecha_termino ? \Carbon\Carbon::parse($row->fecha_termino)->format('d/m/Y') : '—';
                    $finalizado = $row->fecha_termino && \Carbon\Carbon::parse($row->fecha_termino)->endOfDay()->isPast();
                    $fileIcon = function ($urlArchivo) {
                        $path = parse_url($urlArchivo ?? '', PHP_URL_PATH) ?: '';
                        $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                        $host = strtolower(parse_url($urlArchivo ?? '', PHP_URL_HOST) ?: '');
                        $appHost = strtolower(parse_url(config('app.url'), PHP_URL_HOST) ?: '');
                        $externo = $host !== '' && !str_contains($host, 'drehuanuco.gob.pe') && $host !== $appHost;

                        if ($ext === 'pdf') {
                            $icon = ['icon' => 'file-text', 'bg' => 'bg-red-50 border-red-100 group-hover/file:bg-red-100', 'text' => 'text-red-500'];
                        } elseif (in_array($ext, ['doc', 'docx'])) {
                            $icon = ['icon' => 'file-type', 'bg' => 'bg-blue-50 border-blue-100 group-hover/file:bg-blue-100', 'text' => 'text-blue-500'];
                        } elseif (in_array($ext, ['xls', 'xlsx', 'csv'])) {
                            $icon = ['icon' => 'file-spreadsheet', 'bg' => 'bg-emerald-50 border-emerald-100 group-hover/file:bg-emerald-100', 'text' => 'text-emerald-500'];
                        } elseif (in_array($ext, ['ppt', 'pptx'])) {
                            $icon = ['icon' => 'presentation', 'bg' => 'bg-orange-50 border-orange-100 group-hover/file:bg-orange-100', 'text' => 'text-orange-500'];
                        } elseif (in_array($ext, ['zip', 'rar', '7z'])) {
                            $icon = ['icon' => 'file-archive', 'bg' => 'bg-amber-50 border-amber-100 group-hover/file:bg-amber-100', 'text' => 'text-amber-500'];
                        } elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
                            $icon = ['icon' => 'file-image', 'bg' => 'bg-purple-50 border-purple-100 group-hover/file:bg-purple-100', 'text' => 'text-purple-500'];
                        } else {
                            $icon = ['icon' => 'file', 'bg' => 'bg-gray-100 border-gray-200 group-hover/file:bg-gray-200', 'text' => 'text-gray-500'];
                        }

                        $icon['externo'] = $externo;
                        return $icon;
                    };
                    $mdata   = [
                        'tipo'        => $row->tipo,
                        'pill'        => $ts['pill'],
                        'hbg'         => $ts['hbg'],
                        'hbd'         => $ts['hbd'],
                        'titulo'      => $row->titulo,
                        'estado'      => strtoupper($row->estado),
                        'abierto'     => $abierto,
                        'finalizado'  => $finalizado,
                        'fi'          => $fi,
                        'ft'          => $ft,
                        'descripcion' => $row->descripcion,
                        'archivos'    => collect($row->archivos)->map(function ($a) use ($fileIcon) {
                            $icon = $fileIcon($a['url_archivo']);
                            return [
                                'nom'      => $a['nom_archivo'],
                                'url'      => $a['url_archivo'],
                                'fecha'    => $a->created_at ? \Carbon\Carbon::parse($a->created_at)->format('d/m/Y') : null,
                                'nuevo'    => $a->created_at && \Carbon\Carbon::parse($a->created_at)->startOfDay()->diffInDays(now()->startOfDay()) <= 2,
                                'icon'     => $icon['icon'],
                                'iconBg'   => $icon['bg'],
                                'iconText' => $icon['text'],
                                'externo'  => $icon['externo'],
                            ];
                        })->values()->toArray(),
                    ];
                @endphp

                <article class="group bg-white rounded-2xl overflow-hidden flex flex-col
                                border transition-all duration-300 ease-out
                                {{ $abierto 
                                   ? 'border-emerald-200 shadow-[0_4px_24px_-4px_rgba(16,185,129,0.06)] hover:border-emerald-400 hover:shadow-[0_20px_48px_-10px_rgba(16,185,129,0.14)]' 
                                   : 'border-gray-200 shadow-[0_4px_24px_-4px_rgba(1,48,114,0.04)] hover:border-dre-accent/30 hover:shadow-[0_20px_48px_-10px_rgba(1,48,114,0.10)]' }}">

                    {{-- Zone 1: Header --}}
                    <div class="flex items-center min-h-[76px] px-4 py-3 sm:px-5 sm:py-3.5 {{ $ts['hbg'] }} border-b {{ $ts['hbd'] }}/50 transition-colors">
                        <h3 class="font-display font-bold text-gray-800 leading-snug line-clamp-2 break-words group-hover:text-dre-accent transition-colors duration-200"
                            :class="view === 'grid' ? 'text-sm' : 'text-[15px] sm:text-[17px]'">
                            {{ $row->titulo }}
                        </h3>
                    </div>

                    {{-- Footer --}}
                    <footer class="mt-auto border-t border-gray-100/60 bg-slate-50/50"
                            :class="view === 'grid' ? 'px-4 py-3.5' : 'px-4 py-3 sm:px-5 sm:py-3.5'">

                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1.5 pb-3 mb-3 border-b border-gray-200/70">
                            <span class="shrink-0 inline-flex px-2.5 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-widest {{ $ts['pill'] }}">
                                {{ $row->tipo }}
                            </span>
                            @if($finalizado)
                                <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-red-50 text-red-700 border border-red-100/80 shadow-sm">
                                    <i data-lucide="flag" class="w-3 h-3 text-red-500 shrink-0"></i>
                                    FINALIZADO
                                </span>
                            @elseif($abierto)
                                <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100/80 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    ABIERTO
                                </span>
                            @elseif (strtoupper($row->estado) !== 'PUBLICACION')
                                <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-slate-50 text-slate-600 border border-slate-200/80 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    {{ strtoupper($row->estado) }}
                                </span>
                            @endif
                        </div>

                        {{-- Lista --}}
                        <template x-if="view === 'list'">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 w-full">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-y-2 gap-x-4 w-full sm:w-auto">
                                    {{-- Fechas --}}
                                    <div class="flex flex-col min-[480px]:flex-row min-[480px]:items-center gap-y-1.5 gap-x-3 text-xs text-gray-500">
                                        <div class="flex items-center gap-1.5">
                                            <i data-lucide="calendar-days" class="w-3.5 h-3.5 text-dre-accent shrink-0"></i>
                                            <span>Inicia: <span class="font-semibold text-gray-700">{{ $fi }}</span></span>
                                        </div>
                                        <span class="hidden min-[480px]:inline text-gray-300">·</span>
                                        <div class="flex items-center gap-1.5">
                                            <i data-lucide="calendar-days" class="w-3.5 h-3.5 {{ $abierto ? 'text-amber-500' : 'text-gray-400' }} shrink-0"></i>
                                            <span class="{{ $abierto ? 'text-amber-500' : '' }}">Termina: <span class="font-semibold {{ $abierto ? 'text-amber-600' : 'text-gray-700' }}">{{ $ft }}</span></span>
                                        </div>
                                    </div>
                                    {{-- Archivos --}}
                                    @if(count($row->archivos) > 0)
                                    <div class="flex items-center gap-1.5 text-xs text-gray-500 bg-slate-100/80 px-2 py-0.5 rounded-md w-fit shrink-0">
                                        <i data-lucide="paperclip" class="w-3.5 h-3.5 text-gray-400 shrink-0"></i>
                                        <span class="font-medium">{{ count($row->archivos) }} {{ count($row->archivos) > 1 ? 'archivos' : 'archivo' }}</span>
                                    </div>
                                    @endif
                                </div>
                                @if($detail)
                                <button data-modal="{{ json_encode($mdata) }}"
                                        @click="$dispatch('open-convocatoria-modal', JSON.parse($el.dataset.modal))"
                                        class="w-full sm:w-auto justify-center flex items-center gap-1.5 px-4 py-2.5 sm:py-2 rounded-xl sm:rounded-lg text-xs font-bold shadow-sm transition-all duration-200 shrink-0
                                               {{ $abierto ? 'bg-emerald-500 text-white hover:bg-emerald-600 shadow-emerald-200' : 'bg-dre-primary text-white hover:bg-dre-accent shadow-blue-200' }}">
                                    <i data-lucide="eye" class="w-3.5 h-3.5 shrink-0 pointer-events-none"></i>
                                    Ver detalle
                                </button>
                                @endif
                            </div>
                        </template>

                        {{-- Cuadrícula --}}
                        <template x-if="view === 'grid'">
                            <div class="w-full space-y-3">
                                <div class="flex flex-col gap-1.5 text-xs text-gray-500">
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="calendar-days" class="w-3.5 h-3.5 text-dre-accent shrink-0"></i>
                                        <span>Inicia: <span class="font-semibold text-gray-700">{{ $fi }}</span></span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="calendar-days" class="w-3.5 h-3.5 {{ $abierto ? 'text-amber-500' : 'text-gray-400' }} shrink-0"></i>
                                        <span class="{{ $abierto ? 'text-amber-500' : '' }}">Termina: <span class="font-semibold {{ $abierto ? 'text-amber-600' : 'text-gray-700' }}">{{ $ft }}</span></span>
                                    </div>
                                    @if(count($row->archivos) > 0)
                                    <div class="flex items-center gap-1.5 bg-slate-100/80 px-2 py-0.5 rounded-md w-fit mt-1">
                                        <i data-lucide="paperclip" class="w-3.5 h-3.5 text-gray-400 shrink-0"></i>
                                        <span class="font-medium text-xs">{{ count($row->archivos) }} {{ count($row->archivos) > 1 ? 'archivos' : 'archivo' }}</span>
                                    </div>
                                    @endif
                                </div>
                                @if($detail)
                                <button data-modal="{{ json_encode($mdata) }}"
                                        @click="$dispatch('open-convocatoria-modal', JSON.parse($el.dataset.modal))"
                                        class="w-full flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl sm:rounded-lg text-xs font-bold shadow-sm transition-all duration-200
                                               {{ $abierto ? 'bg-emerald-500 text-white hover:bg-emerald-600 shadow-emerald-200' : 'bg-dre-primary text-white hover:bg-dre-accent shadow-blue-200' }}">
                                    <i data-lucide="eye" class="w-3.5 h-3.5 shrink-0 pointer-events-none"></i>
                                    Ver detalle
                                </button>
                                @endif
                            </div>
                        </template>

                    </footer>
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

        </div>{{-- fin x-data --}}
    </div>

    <x-convocatoria-modal />
</section>

@endsection
