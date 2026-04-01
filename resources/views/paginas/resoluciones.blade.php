@extends('principal.plantilla')
@section('title', 'UGEL - HUACAYBAMBA')
@section('content')
<!-- START SECTION BREADCRUMB -->
<section class="page-title-light breadcrumb_section parallax_bg overlay_bg_50" data-parallax-bg-image="{{asset('img/bc.jpeg')}}">
	<div class="container">
    	<div class="row align-items-center">
        	<div class="col-sm-6">
            	<div class="page-title">
            		<h1>RESOLUCIONES</h1>
                </div>
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">RESOLUCIONES</li>
                  </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section>
	<div class="container">
        <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Numero</th>
                <th scope="col">Tipo Resolucion</th>
                <th scope="col">Fecha</th>
                <th scope="col">Asunto</th>
                <th scope="col">Receptor</th>
                <th scope="col">Archivo</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($resoluciones as $key => $registro)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{$registro->x_numero}}</td>
                    <td>{{$registro->tipo->x_resoluciontipos}}</td>
                    <td>{{$registro->x_fecha}}</td>
                    <td>{{$registro->x_asunto}}</td>
                    <td></td>
                    <td class="h3"><a href="https://digital.drehuanuco.gob.pe/storage/ArchivosPDF/{{$registro->x_archivo}}"><i class="fas fa-file-pdf"></i></a></td>
                </tr>                
                @endforeach
            </tbody>
          </table>
    </div>
</section>



@endsection
