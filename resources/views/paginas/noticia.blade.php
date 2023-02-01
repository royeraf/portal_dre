@extends('principal.plantilla')
@section('title', 'UGEL - HUACAYBAMBA')
@section('content')

<main id="main">
<section id="about" class="about">

@php
    $image_path2 = public_path('img/noticias/').$noticia->img2;
    $image_path3 = public_path('img/noticias/').$noticia->img3;
@endphp
    <div class="container">
        <h2>{{$noticia->titulo}}</h2>
        <?php echo $noticia->contenido ?><br>
        <div id="carouselExampleControls2" class="banner_content_wrap carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active p-0" data-img-src="">
                    <img src="{{ asset('img/noticias/'.$noticia->img1) }}" class="w-fluid" width="" alt="">
                </div>
                <?php if (file_exists($image_path2)){  ?>
                <div class="carousel-item p-0" data-img-src="">
                    <img src="{{ asset('img/noticias/'.$noticia->img2) }}" class="w-fluid" width="" alt="">
                </div>
                <?php } ?>
                <?php if (file_exists($image_path3)){  ?>
                <div class="carousel-item p-0" data-img-src="">
                    <img src="{{ asset('img/noticias/'.$noticia->img3) }}" class="w-fluid" width="" alt="">
                </div>
                <?php } ?>
            </div>
            <div class="carousel-nav">
                <a class="carousel-control-prev" href="#carouselExampleControls2" role="button" data-slide="prev">
                    <i class="ion-chevron-left"></i>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls2" role="button" data-slide="next">
                    <i class="ion-chevron-right"></i>
                </a>
            </div>
        </div>
        <div class="animation" data-animation="fadeInUp" data-animation-delay="0.02s">
            <div class="testimonial_slider testimonial_style2 carousel_slider owl-carousel owl-theme" data-margin="30" data-loop="true" data-autoplay="true" data-dots="false" data-responsive='{"0":{"items": "1"}, "380":{"items": "1"}, "576":{"items": "2"}, "1199":{"items": "3"}}'>
                @foreach ($noticias as $item)
                <div class="testimonial_box mt-4">
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
                                <a href="{{route('noticia', $item->id)}}" class="btn btn-primary btn-sm"><span>Ver Mas</span></a>
                            </div>
                            <div class="price">
                              <span class="alert alert-default"> Pub : {{ date_format($date, 'd-m-Y')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>



</section><!-- End About Section -->
</main>

@endsection
