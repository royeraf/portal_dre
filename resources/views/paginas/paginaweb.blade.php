@extends('principal.plantilla')
@section('title', $paginaweb->nom_pagina . ' — DRE Huánuco')

@section('content')

{{-- ── HERO / BREADCRUMB ─────────────────────────────────────── --}}
<div class="relative h-36 sm:h-52 bg-cover bg-center overflow-hidden"
     style="background-image: url('{{ asset('img/bc.jpeg') }}')">
    <div class="absolute inset-0 bg-dre-dark/80"></div>
    <div class="relative h-full max-w-screen-xl mx-auto px-4 md:px-8 flex flex-col justify-center">
        <h1 class="font-display text-white text-3xl sm:text-4xl font-extrabold uppercase tracking-widest drop-shadow-lg">
            {{ $paginaweb->nom_pagina }}
        </h1>
        <nav class="flex items-center gap-1.5 text-xs text-white/60 mt-2">
            <a href="/" class="hover:text-yellow-400 transition-colors">Inicio</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white/90">{{ $paginaweb->nom_pagina }}</span>
        </nav>
    </div>
</div>

{{-- ── CONTENIDO ─────────────────────────────────────────────── --}}
<div class="bg-gray-50 min-h-[60vh]">
    <div class="max-w-screen-xl mx-auto px-4 md:px-8 py-10">

    @if($paginaweb->id == 39)
    {{-- ── MESA DE PARTES UGELES — vista estilizada ──────────── --}}
    @php
    $entidades = [
        ['num' => '10', 'nombre' => 'Dirección Regional de Educación', 'tipo' => 'DRE', 'url' => 'http://digital.regionhuanuco.gob.pe/registro/mesa-partes-virtual/57',  'dre' => true],
        ['num' => '11', 'nombre' => 'UGEL Huacaybamba',                'tipo' => 'UGEL', 'url' => 'http://digital.regionhuanuco.gob.pe/registro/mesa-partes-virtual/261', 'dre' => false],
        ['num' => '12', 'nombre' => 'UGEL Lauricocha',                 'tipo' => 'UGEL', 'url' => 'http://digital.regionhuanuco.gob.pe/registro/mesa-partes-virtual/260', 'dre' => false],
        ['num' => '13', 'nombre' => 'UGEL Huamalíes',                  'tipo' => 'UGEL', 'url' => 'http://digital.regionhuanuco.gob.pe/registro/mesa-partes-virtual/256', 'dre' => false],
        ['num' => '14', 'nombre' => 'UGEL Yarowilca',                  'tipo' => 'UGEL', 'url' => 'http://digital.regionhuanuco.gob.pe/registro/mesa-partes-virtual/269', 'dre' => false],
        ['num' => '15', 'nombre' => 'UGEL Marañón',                    'tipo' => 'UGEL', 'url' => 'http://digital.regionhuanuco.gob.pe/registro/mesa-partes-virtual/254', 'dre' => false],
        ['num' => '16', 'nombre' => 'UGEL Pachitea',                   'tipo' => 'UGEL', 'url' => 'http://digital.regionhuanuco.gob.pe/registro/mesa-partes-virtual/265', 'dre' => false],
        ['num' => '17', 'nombre' => 'UGEL Puerto Inca',                'tipo' => 'UGEL', 'url' => 'http://digital.regionhuanuco.gob.pe/registro/mesa-partes-virtual/210', 'dre' => false],
        ['num' => '18', 'nombre' => 'UGEL Ambo',                       'tipo' => 'UGEL', 'url' => 'http://digital.regionhuanuco.gob.pe/registro/mesa-partes-virtual/263', 'dre' => false],
        ['num' => '19', 'nombre' => 'UGEL Huánuco',                    'tipo' => 'UGEL', 'url' => 'http://digital.regionhuanuco.gob.pe/registro/mesa-partes-virtual/219', 'dre' => false],
        ['num' => '20', 'nombre' => 'UGEL Leoncio Prado',              'tipo' => 'UGEL', 'url' => 'http://digital.regionhuanuco.gob.pe/registro/mesa-partes-virtual/258', 'dre' => false],
        ['num' => '21', 'nombre' => 'UGEL Dos de Mayo',                'tipo' => 'UGEL', 'url' => 'http://digital.regionhuanuco.gob.pe/registro/mesa-partes-virtual/267', 'dre' => false],
    ];
    @endphp

        {{-- Info banner --}}
        <div class="flex items-start gap-3 bg-dre-primary/5 border border-dre-primary/15 rounded-xl px-5 py-4 mb-8">
            <i data-lucide="info" class="w-5 h-5 text-dre-accent shrink-0 mt-0.5"></i>
            <p class="text-sm text-gray-600 leading-relaxed">
                Acceda rápidamente a las plataformas de <strong class="text-dre-primary">Mesa de Partes Virtual</strong>
                de las Unidades de Gestión Educativa Local (UGEL) y la Dirección Regional de Educación (DRE) de Huánuco.
                Haga clic en <strong>"Acceder"</strong> para ser redirigido al portal oficial.
            </p>
        </div>

        {{-- DRE destacada --}}
        @php $dre = $entidades[0]; @endphp
        <a href="{{ $dre['url'] }}" target="_blank"
           class="group flex items-center justify-between gap-4 mb-6
                  bg-dre-primary hover:bg-dre-accent rounded-2xl px-6 py-5
                  shadow-lg shadow-dre-primary/20 transition-all duration-200 hover:-translate-y-0.5">
            <div class="flex items-center gap-4">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-white/15 shrink-0">
                    <i data-lucide="building-2" class="w-5 h-5 text-white"></i>
                </span>
                <div>
                    <span class="block text-yellow-400 text-[10px] font-bold uppercase tracking-widest mb-0.5">Institución Principal</span>
                    <span class="block text-white font-extrabold text-lg uppercase tracking-tight leading-none">
                        {{ $dre['nombre'] }}
                    </span>
                    <span class="block text-white/60 text-xs mt-1 uppercase tracking-wider">Huánuco</span>
                </div>
            </div>
            <span class="shrink-0 flex items-center gap-2 bg-yellow-400 group-hover:bg-white text-black font-bold text-sm px-4 py-2 rounded-xl transition-colors">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                Acceder
            </span>
        </a>

        {{-- Título sección UGELes --}}
        <div class="flex items-center gap-3 mb-4">
            <span class="h-px flex-1 bg-gray-200"></span>
            <span class="text-xs font-bold uppercase tracking-widest text-gray-400">UGELes — Región Huánuco</span>
            <span class="h-px flex-1 bg-gray-200"></span>
        </div>

        {{-- Grid UGELes --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach(array_slice($entidades, 1) as $i => $e)
            <a href="{{ $e['url'] }}" target="_blank"
               class="group flex items-center gap-3 bg-white border border-gray-100 rounded-xl px-4 py-3.5
                      hover:shadow-md hover:-translate-y-0.5 hover:border-dre-accent/30
                      transition-all duration-200 border-l-[3px] border-l-dre-accent/30 hover:border-l-dre-accent">
                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-dre-50 shrink-0
                             group-hover:bg-dre-primary group-hover:text-white transition-colors">
                    <span class="text-[11px] font-black text-dre-primary group-hover:text-white transition-colors">
                        {{ $e['num'] }}
                    </span>
                </span>
                <span class="flex-1 min-w-0">
                    <span class="block text-sm font-semibold text-gray-800 truncate group-hover:text-dre-primary transition-colors">
                        {{ $e['nombre'] }}
                    </span>
                    <span class="block text-[10px] text-gray-400 uppercase tracking-wider">Huánuco · Mesa Virtual</span>
                </span>
                <i data-lucide="arrow-right" class="w-4 h-4 text-gray-300 group-hover:text-dre-accent group-hover:translate-x-0.5 transition-all shrink-0"></i>
            </a>
            @endforeach
        </div>

        {{-- Footer informativo --}}
        <p class="text-center text-xs text-gray-400 mt-8">
            <i data-lucide="calendar" class="w-3.5 h-3.5 inline-block align-middle mr-1"></i>
            Información actualizada al 22 de Abril de 2025 · Amarilis, Huánuco, Perú
        </p>

    @else
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 md:p-8 prose prose-sm max-w-none text-gray-600">
            {!! $paginaweb->cont_pagina !!}
        </div>
    @endif

    </div>
</div>

@endsection
