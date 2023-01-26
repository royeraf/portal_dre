@extends('principal.plantilla')
@section('title', 'UGEL - HUACAYBAMBA')
@section('content')
<main id="main">
<section id="about" class="about" style="margin-top: 90px">
  <div class="container">
    <h2>CONVOCATORIAS</h2><br>

        @foreach ($convocatorias as $row)
        {{-- @php

          $archivos=\App\Models\ArchivoConvocatoria::where('id_convocatoria', $row->id)->get();
        @endphp --}}
        <div class="card">
          <div class="card-header bg-danger text-light">
            <h4><i class="far fa-calendar-alt"></i>&nbsp;|&nbsp;{{$row->fecha_inicio}}&nbsp;|&nbsp;{{$row->tipo.' : '.$row->titulo}}</h4>
          </div>
          <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="card-title">{{$row->titulo}}</h5>
                    <p class="card-text">{{$row->descripcion}}</p>                    
                </div>
                <div class="col">
                    <ul>
                    @foreach ($row->archivos as $archivo)
                        <li><a href="{{$archivo['url_archivo']}}">{{$archivo['nom_archivo']}}</a></li>
                    @endforeach
                    </ul>                    
                </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
                <div class="col">
                    <div class="alert alert-secondary p-1 px-5" role="alert">
                        <i class="far fa-calendar-alt"></i>&nbsp;desde&nbsp;{{$row->fecha_inicio}}
                    </div>
                </div>
                <div class="col">
                    <div class="alert alert-secondary p-1 px-5" role="alert">
                        <i class="far fa-calendar-alt"></i>&nbsp;hasta&nbsp;{{$row->fecha_termino}}
                    </div>
                </div>
                <div class="col">
                    <div class="alert alert-secondary p-1 px-5" role="alert">
                        {{$row->tipo}}
                    </div>
                </div>
                <div class="col">
                    <div class="alert text-bg-{{$row->estado=='ABIERTO' ? 'success' : 'secondary'}} p-1 text-center" role="alert">
                        <i class="fas fa-clock"></i>&nbsp;{{$row->estado}}
                    </div>
                </div>                
            </div>

          </div>
        </div><br>
        @endforeach
    </table>
    {{$convocatorias->links()}}

<br>
<br>
<br>



  </div>
</section><!-- End About Section -->
</main>
@endsection