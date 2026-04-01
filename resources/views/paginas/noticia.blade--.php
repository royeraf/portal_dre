@extends('principal.plantilla')
@section('title', 'DRE HUANUCO')
@section('content')

<main id="main">
<section class="pt-4">

@php
    $image_path2 = public_path('img/noticias/').$noticia->img2;
    $image_path3 = public_path('img/noticias/').$noticia->img3;
@endphp
    <div class="container " style="">
    <div class="row">
        <!-- Contenido principal - izquierda -->
        <div class="col-md-8 p-4 border shadow">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('img/noticias/'.$noticia->img1) }}" class="w-fluid" alt="">
                    </div>
                    @if(file_exists(public_path('img/noticias/'.$noticia->img2)))
                    <div class="carousel-item">
                        <img src="{{ asset('img/noticias/'.$noticia->img2) }}" class="w-fluid" alt="">
                    </div>
                    @endif
                    @if(file_exists(public_path('img/noticias/'.$noticia->img3)))
                    <div class="carousel-item">
                        <img src="{{ asset('img/noticias/'.$noticia->img3) }}" class="w-fluid" alt="">
                    </div>
                    @endif
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <div class="mt-4 text-justify">
                {!! $noticia->contenido !!}
            </div>

            <div class="mt-3 text-center">
                <h6 class="widget_title mb-2">Comparte esta noticia</h6>
                <div class="d-flex gap-2 justify-content-center">
                    <a target="_blank" class="btn btn-primary btn-sm rounded-pill" 
                       href="https://www.facebook.com/sharer.php?u={{ url('noticia/' . $noticia->id) }}" 
                       title="Compartir en Facebook">
                        <i class="fab fa-facebook-f mr-2"></i> Facebook
                    </a>

                    <a target="_blank" class="btn btn-success btn-sm rounded-pill" 
                       href="https://wa.me/51935179345?text=Mira esta noticia: https://drehuanuco.gob.pe/noticia/{{$noticia->id}}" 
                       title="Compartir por WhatsApp">
                        <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar noticias - derecha -->
        <div class="col-md-4">
            <div class="d-flex align-items-center text-start animation pb-3" data-animation="fadeInUp" data-animation-delay="0.01s">
                <div class="text-white rounded-pill px-3 py-1 me-2" style="background-color: #0069d9;">Redes sociales</div>
                <hr class="flex-grow-1" style="border-color: #0069d9;">
            </div>

            <div class="fb-page"
                data-href="https://www.facebook.com/direccionregionaldeeducacion"
                data-tabs="timeline"
                data-width=""
                data-height=""
                data-small-header="false"
                data-adapt-container-width="true"
                data-hide-cover="false"
                data-show-facepile="true">
                <blockquote cite="https://www.facebook.com/direccionregionaldeeducacion" class="fb-xfbml-parse-ignore">
                    <a href="https://www.facebook.com/direccionregionaldeeducacion">Educación DreHco</a>
                </blockquote>
            </div>
        </div>
    </div> <!-- /.row -->
</div> <!-- /.container -->




</section><!-- End About Section -->

</main>

@endsection

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v16.0" nonce="9urXt4qV"></script>
