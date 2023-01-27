@extends('principal.plantilla')
@section('title', 'UGEL - HUACAYBAMBA')
@section('content')
<main id="main">
<section id="about" class="about">
  <div class="container">
    <h2>NOTICIAS</h2><br>
<div class="row">
    @foreach ($noticias as $item)
    <div class="col-md-4">
      <div class="testimonial_box">
        <div class="content_box box_shadow1 animation" data-animation="fadeInUp" data-animation-delay="0.02s">
            <div class="content_img">
                <a href="{{route('noticia', $item->id)}}"><img src="{{asset('img/noticias/'.$item->img1)}}" alt="{{$item->titulo}}" height="190px"/></a>
            </div>
            <div class="content_desc">
                <h4 class="content_title"><a href="{{route('noticia', $item->id)}}" title="{{$item->titulo}}">{{ Str::limit($item->titulo, 30) }}</a></h4>
                  <p>{{ Str::limit($item->descripcioncorta, 40) }}</p>
                @php
                    $date = date_create($item->fechapubli);
                @endphp
            </div>
            <div class="content_footer">
                <div class="teacher">
                    <a href="{{route('noticia', $item->id)}}"><span>Ver Mas</span></a>
                </div>
                <div class="price">
                  <span class="alert alert-success"> Pub : {{ date_format($date, 'd-m-Y')}}</span>
                </div>
            </div>
        </div>
    </div>
    </div>         
    @endforeach
</div>
{{$noticias->links()}}
  </div>
</section><!-- End About Section -->
</main>
@endsection