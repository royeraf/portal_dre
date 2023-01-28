@extends('principal.plantilla')
@section('title', 'UGEL - HUACAYBAMBA')
@section('content')
<!-- START SECTION BREADCRUMB -->
<section class="page-title-light breadcrumb_section parallax_bg overlay_bg_50" data-parallax-bg-image="{{asset('img/bc.jpeg')}}">
	<div class="container">
    	<div class="row align-items-center">
        	<div class="col-sm-6">
            	<div class="page-title">
            		<h1>GALERIA</h1>
                </div>
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Gestion de Documentos</li>
                  </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION BANNER -->
<!-- START SECTION GALLERY -->
<section style="height: 800px">
	<div class="container">	
        <div class="row">
                @foreach ($registros as $item)
                    <div class="col">
                        <div class="accordion" id="accordionExample">




                            <div class="card">
                                <div class="card-header" id="heading{{$item->id}}">
                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$item->id}}" aria-expanded="true" aria-controls="collapse{{$item->id}}">
                                    {{$item->titulo}}
                                    </button>
                                 </div>
                            
                                <div id="collapse{{$item->id}}" class="collapse show" aria-labelledby="heading{{$item->id}}" data-parent="#accordionExample">
                                <div class="card-body small">
                                    <ul>
                                    @foreach ($item->archivos as $row)
                                        <li><a target="_blank" href="{{$row['url_archivo']}}">{{$row['nombre']}}</a></li>
                                    @endforeach                                        
                                    </ul>

                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


        </div>

    </div>
</section>
<!-- END SECTION GALLERY -->

@endsection