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
                      <li class="breadcrumb-item"><a href="/">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Galeria</li>
                    </ol>
                  </nav>
              </div>
          </div>
      </div>
  </section>
  <!-- END SECTION BANNER -->
  <!-- ======= Portfolio Details Section ======= -->
  <section id="portfolio-details" class="portfolio-details">
    <div class="container">
      <div class="row">
        <div class="col-8">
          <section class="banner_section p-0 full_screen">
            <div id="carouselExampleControls" class="banner_content_wrap carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                  <?php $estado=false; ?>
                  @foreach($imagenes as $row)
                    <div class="carousel-item {{ $estado==false ? 'active' : '' }} background_bg overlay_bg_50" data-img-src="{{asset('img/imageneventos/'.$row->archivo_img)}}">
                    </div>
                  <?php $estado = true ?>
                  @endforeach
                </div>
                <div class="carousel-nav">
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <i class="ion-chevron-left"></i>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <i class="ion-chevron-right"></i>
                    </a>
                </div>
            </div>
        </section>
        </div>
        <div class="col">
          <h3>{{$galeria->titulo}}</h3>
          <p>{{$galeria->descripcion}}</p>
        </div>
      </div>
    </div>
  </section><!-- End Portfolio Details Section -->
  <!-- END SECTION FAQ -->
@endsection