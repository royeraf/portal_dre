@extends('principal.plantilla')
@section('title', 'UGEL - HUACAYBAMBA')
@section('content')
<main id="main" style="margin-top: 90px">
    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
        <div class="container">
          <h2>GALERIA de FOTOS</h2>
          <div class="row">
            <div class="col-lg-12 d-flex justify-content-center">
              {{-- <ul id="portfolio-flters">
                <li data-filter="*" class="filter-active">All</li>
                <li data-filter=".filter-app">App</li>
                <li data-filter=".filter-card">Card</li>
                <li data-filter=".filter-web">Web</li>
              </ul> --}}
            </div>
          </div>
          <div class="row portfolio-container">
            @foreach ($registrosgaleria as $item)
                <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                  <div class="portfolio-wrap">
                    <img src="{{asset('img/imageneventos/'.$item->img)}}" class="img-fluid" alt="">
                    <div class="portfolio-info">
                      <h4>{{$item->titulo}}</h4>
                      <p>{{$item->descripcion}}</p>
                      <div class="portfolio-links">
                        <a href="{{asset('img/imageneventos/'.$item->img)}}" data-gallery="portfolioGallery" class="portfolio-lightbox" title="{{$item->titulo}}"><i class="bx bx-plus"></i></a>
                        <a href="{{route('portafoliodet', $item)}}" class="portfolio-details-lightbox" data-glightbox="type: external" title="{{$item->descripcion}}"><i class="bx bx-link"></i></a>
                      </div>
                    </div>
                  </div>
                </div>    
            @endforeach
          </div>
        </div>
      </section><!-- End Portfolio Section -->
</main>

@endsection