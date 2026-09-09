@extends('principal.plantilla')
@section('title', 'UGEL - HUACAYBAMBA')
@section('content')
@php
    $descripcionHtml = html_entity_decode((string) $convocatoria->descripcion, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $descripcionSinScripts = preg_replace('#<(script|style)\b[^>]*>.*?</\1>#is', ' ', $descripcionHtml) ?? '';
    $descripcion = trim(preg_replace('/\s+/u', ' ', strip_tags($descripcionSinScripts)) ?? '');
@endphp
<main id="main">
<section id="about" class="about">
  <div class="container">
    <h2>CONVOCATORIA</h2><br>
    <h3>{{$convocatoria->tipo.': '.$convocatoria->titulo}}</h3>
    <div class="row">
        <div class="col-6">
            <p>{{ $descripcion }}</p>
        </div>
        <div class="col">
            <h3><small>Fecha de Inicio : </small>{{$convocatoria->fecha_inicio}}</h3>
        </div>
        <div class="col">
            <h3><small>Fecha de Termino : </small>{{$convocatoria->fecha_termino}}</h3>
        </div>
        
    </div>
     <div class="row">
        <div class="col">
            <h3><small>ESTADO : </small>{{$convocatoria->estado}}</h3>
        </div>
     </div><br>
     <h4>ARCHIVOS</h4>
     <table class="table table-bordered table-sm">
        <tr>
            <th>ITEM</th>
            <th>TITULO</th>
            <th>ARCHIVO</th>
            <th>ETAPA</th>
        </tr>
        @foreach ($archivos as $item)
            @php
                $rutaArchivo = trim((string) $item->url_archivo);
                $esUrlWeb = preg_match('#^https?://#i', $rutaArchivo) === 1;
                $tieneOtroEsquema = preg_match('#^[a-z][a-z0-9+.-]*:#i', $rutaArchivo) === 1;
                $urlArchivo = $esUrlWeb
                    ? $rutaArchivo
                    : ($rutaArchivo !== '' && ! $tieneOtroEsquema ? url('/'.ltrim($rutaArchivo, '/')) : null);
            @endphp
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->nom_archivo}}</td>
                <td>
                    @if ($urlArchivo)
                        <a target="_blank" rel="noopener noreferrer" href="{{ $urlArchivo }}">Ver / descargar</a>
                    @else
                        <span>Archivo no disponible</span>
                    @endif
                </td>
                <td>{{$item->etapa}}</td>
            </tr>
        @endforeach
     </table>
     <br>
     {{$archivos->links()}}
  </div>
</section><!-- End About Section -->
</main>
@endsection
