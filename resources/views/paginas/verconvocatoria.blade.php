@extends('principal.plantilla')

@section('title', $convocatoria->titulo.' — DRE Huánuco')

@php
    $descripcionHtml = html_entity_decode((string) $convocatoria->descripcion, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $descripcionSinScripts = preg_replace('#<(script|style)\b[^>]*>.*?</\1>#is', ' ', $descripcionHtml) ?? '';
    $descripcion = trim(preg_replace('/\s+/u', ' ', strip_tags($descripcionSinScripts)) ?? '');

    $tipoStyles = [
        'CAS' => ['pill' => 'bg-blue-100 text-blue-700', 'header' => 'bg-blue-50 border-blue-100'],
        'CAP' => ['pill' => 'bg-indigo-100 text-indigo-700', 'header' => 'bg-indigo-50 border-indigo-100'],
        'DOCENTE' => ['pill' => 'bg-emerald-100 text-emerald-700', 'header' => 'bg-emerald-50 border-emerald-100'],
        'DIRECTIVO' => ['pill' => 'bg-dre-50 text-dre-primary', 'header' => 'bg-dre-50 border-dre-primary/20'],
        'LOCACION DE SERVICIO' => ['pill' => 'bg-teal-100 text-teal-700', 'header' => 'bg-teal-50 border-teal-100'],
        'LOCACION DE SERVICIOS' => ['pill' => 'bg-teal-100 text-teal-700', 'header' => 'bg-teal-50 border-teal-100'],
        'REASIGNACION' => ['pill' => 'bg-orange-100 text-orange-700', 'header' => 'bg-orange-50 border-orange-100'],
        '276' => ['pill' => 'bg-purple-100 text-purple-700', 'header' => 'bg-purple-50 border-purple-100'],
    ];
    $tipoStyle = $tipoStyles[$convocatoria->tipo] ?? ['pill' => 'bg-slate-100 text-slate-700', 'header' => 'bg-slate-50 border-slate-200'];
    $fechaInicio = $convocatoria->fecha_inicio ? \Carbon\Carbon::parse($convocatoria->fecha_inicio)->format('d/m/Y') : 'No indicada';
    $fechaTermino = $convocatoria->fecha_termino ? \Carbon\Carbon::parse($convocatoria->fecha_termino)->format('d/m/Y') : 'No indicada';
    $finalizada = $convocatoria->fecha_termino && \Carbon\Carbon::parse($convocatoria->fecha_termino)->endOfDay()->isPast();
    $estado = $finalizada ? 'FINALIZADA' : (strtoupper(trim((string) $convocatoria->estado)) ?: 'PUBLICACIÓN');
    $esNueva = $convocatoria->created_at && \Carbon\Carbon::parse($convocatoria->created_at)->startOfDay()->diffInDays(now()->startOfDay()) <= 5;
@endphp

@section('og_title', $convocatoria->titulo.' — DRE Huánuco')
@section('og_description', \Illuminate\Support\Str::limit($descripcion, 180))

@section('content')
<div class="relative h-36 sm:h-52 bg-cover bg-center overflow-hidden" style="background-image: url('{{ asset('img/bc.jpeg') }}')">
    <div class="absolute inset-0 bg-dre-dark/80"></div>
    <div class="relative h-full max-w-screen-xl mx-auto px-4 md:px-8 flex flex-col justify-center">
        <h1 class="font-display text-white text-3xl sm:text-4xl font-extrabold uppercase tracking-widest drop-shadow-lg">Convocatoria</h1>
        <nav aria-label="Migas de pan" class="flex items-center gap-1.5 text-xs text-white/60 mt-2">
            <a href="{{ url('/') }}" class="hover:text-yellow-400 transition-colors">Inicio</a>
            <i data-lucide="chevron-right" class="w-3 h-3" aria-hidden="true"></i>
            <a href="{{ route('convocatoriaweb') }}" class="hover:text-yellow-400 transition-colors">Convocatorias</a>
            <i data-lucide="chevron-right" class="w-3 h-3" aria-hidden="true"></i>
            <span class="text-white/90">Detalle</span>
        </nav>
    </div>
</div>

<section class="bg-slate-50 py-8 sm:py-12 min-h-[32rem]">
    <div class="max-w-4xl mx-auto px-4 md:px-8">
        <article class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-[0_18px_50px_-24px_rgba(1,48,114,0.30)]">
            <header class="px-5 py-4 sm:px-7 sm:py-5 border-b {{ $tipoStyle['header'] }}">
                <p class="font-display text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-700">Convocatoria</p>
                <div class="mt-3 flex flex-wrap items-center gap-2">
                    <span class="inline-flex rounded-md px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-widest {{ $tipoStyle['pill'] }}">{{ $convocatoria->tipo ?: 'GENERAL' }}</span>
                    <span class="inline-flex items-center gap-1.5 rounded-md border px-2.5 py-1 text-[10px] font-bold {{ $finalizada ? 'border-red-100 bg-red-50 text-red-700' : 'border-slate-200 bg-white/70 text-slate-600' }}">
                        <span class="h-1.5 w-1.5 rounded-full {{ $finalizada ? 'bg-red-500' : 'bg-slate-400' }}" aria-hidden="true"></span>
                        {{ $estado }}
                    </span>
                    @if ($esNueva && ! $finalizada)
                        <span class="inline-flex items-center gap-1.5 rounded-md border border-emerald-100 bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700">
                            <i data-lucide="sparkles" class="h-3 w-3" aria-hidden="true"></i>NUEVO
                        </span>
                    @endif
                </div>
            </header>

            <div class="flex flex-wrap items-center gap-x-6 gap-y-2 border-b border-slate-100 bg-slate-50/80 px-5 py-3 text-xs text-slate-500 sm:px-7">
                <div class="flex items-center gap-2">
                    <i data-lucide="calendar-days" class="h-4 w-4 shrink-0 text-dre-accent" aria-hidden="true"></i>
                    <span>Inicia: <strong class="ml-1 font-semibold tabular-nums text-slate-700">{{ $fechaInicio }}</strong></span>
                </div>
                <div class="flex items-center gap-2">
                    <i data-lucide="calendar-days" class="h-4 w-4 shrink-0 {{ $finalizada ? 'text-slate-400' : 'text-amber-500' }}" aria-hidden="true"></i>
                    <span>Termina: <strong class="ml-1 font-semibold tabular-nums {{ $finalizada ? 'text-slate-700' : 'text-amber-700' }}">{{ $fechaTermino }}</strong></span>
                </div>
            </div>

            <div class="space-y-7 px-5 py-6 sm:px-7 sm:py-8">
                <div class="border-b border-slate-100 pb-6">
                    <h2 class="font-display text-xl sm:text-2xl font-bold leading-snug text-slate-900">{{ $convocatoria->titulo }}</h2>
                </div>

                @if ($descripcion !== '')
                    <section aria-labelledby="descripcion-convocatoria">
                        <h3 id="descripcion-convocatoria" class="mb-3 flex items-center gap-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <i data-lucide="file-text" class="h-4 w-4" aria-hidden="true"></i>Descripción
                        </h3>
                        <p class="max-w-[72ch] text-sm sm:text-base leading-7 text-slate-700">{{ $descripcion }}</p>
                    </section>
                @endif

                <section aria-labelledby="documentos-convocatoria">
                    <h3 id="documentos-convocatoria" class="mb-3 flex items-center gap-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                        <i data-lucide="paperclip" class="h-4 w-4" aria-hidden="true"></i>
                        Documentos adjuntos <span aria-label="{{ $archivos->total() }} documentos">({{ $archivos->total() }})</span>
                    </h3>

                    @if ($archivos->count())
                        <ul class="space-y-2.5">
                            @foreach ($archivos as $item)
                                @php
                                    $rutaArchivo = trim((string) $item->url_archivo);
                                    $esUrlWeb = preg_match('#^https?://#i', $rutaArchivo) === 1;
                                    $tieneOtroEsquema = preg_match('#^[a-z][a-z0-9+.-]*:#i', $rutaArchivo) === 1;
                                    $urlArchivo = $esUrlWeb ? $rutaArchivo : ($rutaArchivo !== '' && ! $tieneOtroEsquema ? url('/'.ltrim($rutaArchivo, '/')) : null);
                                    $fechaArchivo = $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') : null;
                                    $archivoNuevo = $item->created_at && \Carbon\Carbon::parse($item->created_at)->startOfDay()->diffInDays(now()->startOfDay()) <= 2;
                                @endphp
                                <li>
                                    @if ($urlArchivo)
                                        <a href="{{ $urlArchivo }}" target="_blank" rel="noopener noreferrer" class="group flex min-h-[4.25rem] items-start gap-3 rounded-xl border border-slate-200/80 bg-slate-50 p-3 transition-[border-color,background-color,box-shadow,transform] duration-150 ease-out hover:-translate-y-0.5 hover:border-dre-accent/30 hover:bg-dre-50 hover:shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dre-accent">
                                            <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-red-100 bg-red-50 text-red-500 transition-colors group-hover:bg-red-100">
                                                <i data-lucide="file-text" class="h-4 w-4" aria-hidden="true"></i>
                                            </span>
                                            <span class="min-w-0 flex-1">
                                                <span class="flex flex-wrap items-center gap-2">
                                                    <span class="break-words text-sm font-semibold leading-5 text-slate-700 transition-colors group-hover:text-dre-accent">{{ $item->nom_archivo }}</span>
                                                    @if ($archivoNuevo)
                                                        <span class="rounded-md border border-emerald-100 bg-emerald-50 px-1.5 py-0.5 text-[9px] font-bold text-emerald-700">NUEVO</span>
                                                    @endif
                                                </span>
                                                @if ($fechaArchivo)<span class="mt-1 block text-[11px] tabular-nums text-slate-400">{{ $fechaArchivo }}</span>@endif
                                                <span class="sr-only">Ver / descargar: {{ $item->nom_archivo }}</span>
                                            </span>
                                            <i data-lucide="external-link" class="mt-2 h-4 w-4 shrink-0 text-slate-300 transition-colors group-hover:text-dre-accent" aria-hidden="true"></i>
                                        </a>
                                    @else
                                        <div class="flex min-h-[4.25rem] items-start gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3 text-slate-500">
                                            <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-slate-200 bg-white"><i data-lucide="file-x" class="h-4 w-4" aria-hidden="true"></i></span>
                                            <span class="min-w-0 flex-1"><span class="block break-words text-sm font-semibold">{{ $item->nom_archivo }}</span><span class="mt-1 block text-xs">Archivo no disponible</span></span>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        @if ($archivos->hasPages())<div class="mt-5">{{ $archivos->links('pagination::tailwind') }}</div>@endif
                    @else
                        <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-6 text-center">
                            <i data-lucide="inbox" class="mx-auto h-6 w-6 text-slate-400" aria-hidden="true"></i>
                            <p class="mt-2 text-sm font-medium text-slate-600">Aún no se publicaron documentos adjuntos.</p>
                        </div>
                    @endif
                </section>
            </div>

            <footer class="flex justify-end border-t border-slate-100 bg-slate-50 px-5 py-4 sm:px-7">
                <a href="{{ route('convocatoriaweb') }}" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-dre-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-[background-color,transform] duration-150 hover:bg-dre-accent active:scale-[0.98] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-dre-accent">
                    <i data-lucide="arrow-left" class="h-4 w-4" aria-hidden="true"></i>Volver a convocatorias
                </a>
            </footer>
        </article>
    </div>
</section>
@endsection
