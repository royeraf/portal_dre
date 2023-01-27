@extends('principal.plantilla')
@section('title', 'UGEL - HUACAYBAMBA')
@section('content')
<!-- START SECTION BREADCRUMB -->
<section class="page-title-light breadcrumb_section parallax_bg overlay_bg_50" data-parallax-bg-image="assets/images/about_bg.jpg">
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
                    <li class="breadcrumb-item active" aria-current="page">Galeria</li>
                  </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION BANNER -->
<!-- START SECTION GALLERY -->
<section>
	<div class="container">	
    	<div class="row">
            <div class="col-md-12 text-center">
                <ul class="list_none grid_filter">
                    <li><a href="#" class="current" data-filter="*">all</a></li>
                    <li><a href="#" data-filter=".library">Library</a></li>
                    <li><a href="#" data-filter=".campus">Campus</a></li>
                    <li><a href="#" data-filter=".events">Events</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="grid_container gutter_medium grid_col4">
                    <li class="grid-sizer"></li>
                    @foreach ($registrosgaleria as $item)
                    <!-- START PORTFOLIO ITEM -->
                    <li class="grid_item events">
                        <div class="gallery_item">
                            <a href="#" class="image_link">
                                <img src="{{asset('img/imageneventos/'.$item->img)}}" alt="image">
                            </a>
                            <div class="gallery_content">
                                <div class="link_container">
                                    <a href="{{asset('img/imageneventos/'.$item->img)}}" class="image_popup"><span class="ripple"><i class="ion-image"></i></span></a>
                                </div>
                                <div class="text_holder text_white">
                               		<h5>{{$item->titulo}}</h5>
                                  <p>{{$item->descripcion}}</p>
                                  <a href="{{route('portafoliodet', $item)}}" title="Ver Detalle"><i class="fa fa-eye"></i></a>
                                </div>
							              </div>
                        </div>
                    </li>
                    <!-- END PORTFOLIO ITEM -->
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION GALLERY -->

@endsection