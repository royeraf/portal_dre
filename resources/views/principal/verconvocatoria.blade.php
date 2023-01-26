@extends('principal.plantilla')
@section('title', 'UGEL - HUACAYBAMBA')
@section('content')
<main id="main">
<section id="about" class="about" style="margin-top: 90px">
  <div class="container">
    <h2>CONVOCATORIA</h2><br>
    <h3>{{$convocatoria->tipo.': '.$convocatoria->titulo}}</h3>
    <div class="row">
        <div class="col-6">
            <p>{{$convocatoria->descripcion}}</p>  
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
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->nom_archivo}}</td>
                <td><a target="_blank" href="{{$item->url_archivo}}"></a></td>
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