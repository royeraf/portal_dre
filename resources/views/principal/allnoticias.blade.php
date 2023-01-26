@extends('principal.plantilla')
@section('title', 'UGEL - HUACAYBAMBA')
@section('content')
<main id="main">
<section id="about" class="about" style="margin-top: 90px">
  <div class="container">
    <h2>NOTICIAS</h2><br>
<div class="row">
    @foreach ($noticias as $item)
    <div class="col-md-3">
        <div class="card swiper-slide">
            <img src="{{asset('img/noticias/'.$item->img1)}}" class="card-img-top" height="200px" />
            <div class="card-body">
              <h5 class="card-title">{{ Str::limit($item->titulo, 30) }}</h5>
              <p class="card-text">{{ Str::limit($item->descripcioncorta, 40) }}</p>
              <div class="card-footer">
                @php
                    $date = date_create($item->fechapubli);
                @endphp
                <span class="blockquote-footer"> Pub : {{ date_format($date, 'd-m-Y')}}</span>&nbsp;
                <a href="{{route('noticia', $item->id)}}" class="btn btn-sm btn-danger">Ver Mas</a>
              </div>
            </div>
        </div>
    </div>         
    @endforeach
</div>
  </div>
</section><!-- End About Section -->
</main>
@endsection