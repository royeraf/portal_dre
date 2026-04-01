@extends('principal.plantilla')
@section('title', 'DRE - HUANUCO')
@section('content')
        <!-- START SECTION BANNER -->
        <div class="news_ticker bg-warning">
            <div class="container">
                <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                    <span style="color:black; font-weight: bold">NOTICIAS RECIENTES </span>&nbsp;:&nbsp;
                    @foreach ($noticias as $item)
                        <a href="{{route('noticia', $item->id)}}" target="_blank">{{$item->titulo}}</a> ||
                    @endforeach
                </marquee>
            </div>
        </div>
        <section class="banner_section p-0">
            <div id="carouselExampleControls" class="banner_content_wrap carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                <?php $estado=false; ?>
                @foreach($sliders as $row)
                    <div class="carousel-item {{ $estado==false ? 'active' : '' }} background_bg overlay_bg_10" data-img-src="{{ asset('img/slider/'.$row->img_slider) }}" style="min-height: 60vh;">
                        <div class="banner_slide_content">
                            <div class="container"><!-- STRART CONTAINER -->
                                <div class="row justify-content-center">
                                    <div class="col-lg-12 col-sm-12 text-center">
                                        <div class="banner_content animation text_white" data-animation="fadeIn" data-animation-delay="0.8s">
                                            <h2 class="font-weight-bold animation text-uppercase" data-animation="zoomIn" data-animation-delay="1s">{{$row->titulo}}</h2>
                                            <p class="animation" data-animation="zoomIn" data-animation-delay="1.5s">{{Str::lower($row->descripcioncorta)}}</p>
                                            @if ($row->link!=null && $row->link!='')
                                            <a class="btn btn-warning btn-sm animation rounded-0" href="{{$row->link}}" data-animation="zoomIn" data-animation-delay="1.8s">Leer Mas</a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div><!-- END CONTAINER-->
                        </div>
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
        <section class="container-fluid py-0">
            <div class="row py-1 mt-0">
                <div class="col-md-1"></div>
                <div class="col-md-8 py-1">
                    <section class="p-1 p-2">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-6">
                                <div class="single_categories">
                                    <a href="{{route('directorioweb')}}" class="bg_danger small p-1">
                                        <i class="fa fa-desktop"></i>
                                        Directorio Institucional
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-6">
                                <div class="single_categories">
                                    <a href="/resoluciones" class="bg_light_green small p-1">
                                        <i class="fa fa-chart-line"></i>
                                        Resoluciones
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-6">
                                <div class="single_categories">
                                    <a href="{{route('documentosdegestionweb')}}" class="bg_default small p-1">
                                        <i class="fa fa-book"></i>
                                        Gestion de Documentos
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-6">
                                <div class="single_categories">
                                    <a href="{{route('galerias')}}" class="bg_pink small p-1">
                                        <i class="fa fa-camera"></i>
                                        Galeria de Imagenes
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-6">
                                <div class="single_categories">
                                    <a href="#" class="bg_blue small p-1">
                                        <i class="fa fa-heartbeat"></i>
                                            academics
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-6">
                                <div class="single_categories">
                                    <a href="#" class="bg_orange small p-1">
                                        <i class="fa fa-code"></i>
                                        Campus life
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-2 col-md-2 col-6">
                                <div class="single_categories">
                                    <a href="#" class="bg_danger small p-3">
                                        <i class="fa fa-globe"></i>
                                        Scholarship
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-6">
                                <div class="single_categories">
                                    <a href="{{route('infraestructuraall')}}" class="bg_light_green small p-3">
                                        <i class="fa fa-chart-line"></i>
                                        INFRAESTRUCTURA
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-6">
                                <div class="single_categories">
                                    <a href="#" class="bg_default small p-3">
                                        <i class="fa fa-book"></i>
                                        Admission
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-6">
                                <div class="single_categories">
                                    <a href="#" class="bg_pink small p-3">
                                        <i class="fa fa-camera"></i>
                                        Global exposure
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-6">
                                <div class="single_categories">
                                    <a href="#" class="bg_blue small p-3">
                                        <i class="fa fa-heartbeat"></i>
                                            academics
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-6">
                                <div class="single_categories">
                                    <a href="#" class="bg_orange small p-3">
                                        <i class="fa fa-code"></i>
                                        Campus life
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="pt-0">
                        <div class="container">
                            <div class="row mb-0 mt-0">
                                <div class="col d-flex align-items-start flex-column">
                                    <div class="mt-auto p-0"><br>
                                        <div class="text-center animation" data-animation="fadeInUp" data-animation-delay="0.01s">
                                        <h2>NOTICIAS</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3 align-self-end pb-3">
                                    <div class="text-center animation" data-animation="fadeInUp" data-animation-delay="0.07s">
                                        <div class="medium_divider"></div>
                                        <a href="{{route('allnoticias')}}" class="btn btn-sm btn-default rounded-0">Ver Mas Noticias <i class="ion-ios-arrow-thin-right ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-12 animation" data-animation="fadeInUp" data-animation-delay="0.02s">
                                    <div class="banner-area">
                                        <div class="cm_banner cm_banner-five">
                                            <div class="banner-inner card">
                                                <div class="card-body gutter-left">
                                                    <div class="owl-carousel cm_banner-carousel-five">
                                                        @foreach ($noticias as $item)
                                                            <div class="item">
                                                                <div class="post_thumb" style="background-image: url({{ asset('img/noticias/'.$item->img1) }})">
                                                                <div class="post-holder">
                                                                    <div class="entry_cats">
                                                                        <ul class="post-categories">
                                                                            <li><a href="{{route('noticia', $item->id)}}" rel="category tag">Ver Mas</a></li>
                                                                        </ul>
                                                                    </div>
                                                                    <!-- .entry_cats -->
                                                                    <div class="post_title">
                                                                        <h2><a href="{{route('noticia', $item->id)}}">{{$item->titulo}}</a></h2>
                                                                    </div>
                                                                    <!-- .post_title -->
                                                                    <div class="cm-post-meta">
                                                                        <ul class="post_meta">
                                                                            <li class="post_author">
                                                                            <a href="{{route('noticia', $item->id)}}">Prensa</a>
                                                                            </li>
                                                                            @php
                                                                                $date = date_create($item->fechapubli);
                                                                            @endphp
                                                                            <!-- .post_author -->
                                                                            <li class="posted_date">
                                                                            <a href="{{route('noticia', $item->id)}}"><time class="entry-date published updated" datetime="2023-02-27T10:31:46-05:00">{{ date_format($date, 'd-m-Y')}}</time></a>
                                                                            </li>
                                                                            <!-- .posted_date -->
                                                                        </ul>
                                                                        <!-- .post_meta -->
                                                                    </div>
                                                                    <!-- .meta -->
                                                                </div>
                                                                <!-- .post-holder -->
                                                                </div>
                                                                <!-- // post_thumb -->
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-2 p-0 pt-1">
                    @foreach ($mainrightitem as $item)
                    <div class="mb-2 px-4">
                        <a href="{{$item->url}}" target="_blank" class="btn btn-primary p-0" title="{{$item->nombre}}">
                            <img src="{{asset('img/mainright/'.$item->imagen)}}" alt="{{$item->nombre}}" class="img-fluid">
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-1"></div>
            </div>
        </section>
        <section class="background_bg bg_blue2 bg_fixed p-2" data-parallax-bg-image="{{asset('plantillas/eduglobal/assets/images/pattern_bg4.png')}}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-6">
                        <div class="box_counter counter_style1 text_white text-center animation" data-animation="fadeInUp" data-animation-delay="0.02s">
                        <div class="counter_icon">
                            <img src="{{ asset('plantillas/eduglobal/assets/images/counter_icon1.png') }}" alt="counter_icon1" />
                            </div>
                            <div class="counter_content">
                                <h3 class="counter_text"><span class="counter">252392</span>+</h3>
                                <p><a target="_blank" href="https://docs.google.com/spreadsheets/d/1ZsMZTp6z_-k2CJB-31A7gf3UKE0XLfzf/edit?usp=share_link&ouid=115124098271698375348&rtpof=true&sd=true">Estudiantes</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-6 ">
                        <div class="box_counter counter_style1 text_white text-center animation" data-animation="fadeInUp" data-animation-delay="0.03s">
                            <div class="counter_icon">
                            <img src="{{ asset('plantillas/eduglobal/assets/images/counter_icon2.png') }}" alt="counter_icon2" />
                            </div>
                            <div class="counter_content">
                                <h3 class="counter_text"><span class="counter">4415</span></h3>
                                <p><a target="_blank" href="https://docs.google.com/spreadsheets/d/1meqfy82jyk-qrXsaWpndBni3jfBf3koZ/edit?usp=share_link&ouid=115124098271698375348&rtpof=true&sd=true">Colegios</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-6 ">
                        <div class="box_counter counter_style1 text_white text-center animation" data-animation="fadeInUp" data-animation-delay="0.04s">
                            <div class="counter_icon">
                            <img src="{{ asset('plantillas/eduglobal/assets/images/counter_icon3.png') }}" alt="counter_icon3" />
                            </div>
                            <div class="counter_content">
                                <h3 class="counter_text"><span class="counter">17042</span>+</h3>
                                <p><a target="_blank" href="https://docs.google.com/spreadsheets/d/1kM5rohSYy0zS8kqak7sWWflUPun9n6jc/edit?usp=share_link&ouid=115124098271698375348&rtpof=true&sd=true">Docentes</a> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-6 ">
                        <div class="box_counter counter_style1 text_white text-center animation" data-animation="fadeInUp" data-animation-delay="0.05s">
                        <div class="counter_icon">
                            <img src="{{ asset('plantillas/eduglobal/assets/images/counter_icon4.png') }}" alt="counter_icon4" />
                            </div>
                            <div class="counter_content">
                                <h3 class="counter_text"><span class="counter">11</span></h3>
                                <p>Ugeles</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END SECTION COUNTER -->
        <!-- START SECTION COMUNICADOS -->
        <section class="bg_gray mb-0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="heading_s1 text-center animation" data-animation="fadeInUp" data-animation-delay="0.01s">
                            <h2>COMUNICADOS</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($comunicados as $item)
                    <div class="col-lg-4 col-sm-6">
                        <div class="team_box team_style2 box_shadow1 animation" data-animation="fadeInUp" data-animation-delay="0.02s">
                            <div class="team_img">
                                <img src="{{asset('img/comunicados/'.$item->imagen)}}" alt="{{$item->titulo}}">
                            </div>
                            <div class="team_title text-center">
                                <h5><a href="{{$item->url ?? '#'}}">{{$item->titulo}}</a></h5>
                                @if ($item->url!='' && $item->url!=null)
                                <a target="_blank" href="{{$item->url}}" title="Ver Mas"><i class="fa fa-eye"></i></a>
                            @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- END SECTION COMUNICADOS -->


<section class="bg_gray mt-1 mb-0 pb-0">

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3>GALERIA DE VIDEOS</h3>
                <div class="owl-carousel cm_banner-carousel-five" style="height: 320px">
                @foreach ($VideoEmbevidos as $item)
                <div class="item">
                    <div class="post_thumb">
                        <div class="post-holder">
                            <!-- .entry_cats -->
                            <div class="post_title">
                            </div>
                            <!-- .post_title -->
                            <div class="cm-post-meta p-0">
                                <ul class="post_meta p-0">
                                    <?php echo $item->contenido ?>
                                </ul>
                                <!-- .post_meta -->
                            </div>
                            <!-- .meta -->
                        </div>
                        <!-- .post-holder -->
                    </div>
                </div>
                @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="fb-page" data-href="https://www.facebook.com/direccionregionaldeeducacion" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/direccionregionaldeeducacion" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/direccionregionaldeeducacion">Educación DreHco</a></blockquote></div>
            </div>
        </div>
    </div>
</section>


    <!-- START SECTION CLIENT LOGO -->
    <section class="light_gray_bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12 animation" data-animation="fadeInUp" data-animation-delay="0.01s">
                <div class="cl_logo_slider carousel_slider owl-carousel owl-theme" data-margin="15" data-loop="true" data-autoplay="true" data-dots="false" data-responsive='{"0":{"items": "2"}, "380":{"items": "3"}, "600":{"items": "4"}, "1000":{"items": "5"}, "1199":{"items": "6"}}'>
                    <div class="item">
                      <a href="#"><img src="{{ asset('plantillas/eduglobal/assets/images/cl_logo1.png') }}" alt="cl_logo1"/></a>
                      </div>
                      <div class="item">
                      <a href="#"><img src="{{ asset('plantillas/eduglobal/assets/images/cl_logo2.png') }}" alt="cl_logo2"/></a>
                      </div>
                      <div class="item">
                      <a href="#"><img src="{{ asset('plantillas/eduglobal/assets/images/cl_logo3.png') }}" alt="cl_logo3"/></a>
                      </div>
                      <div class="item">
                      <a href="#"><img src="{{ asset('plantillas/eduglobal/assets/images/cl_logo4.png') }}" alt="cl_logo4"/></a>
                      </div>
                      <div class="item">
                      <a href="#"><img src="{{ asset('plantillas/eduglobal/assets/images/cl_logo5.png') }}" alt="cl_logo5"/></a>
                      </div>
                      <div class="item">
                      <a href="#"><img src="{{ asset('plantillas/eduglobal/assets/images/cl_logo2.png') }}" alt="cl_logo2"/></a>
                      </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <!-- END SECTION CLIENT LOGO -->
    <?php if(isset($popup)){ ?>
        <div class="modal fade show" id="modalpopup" tabindex="-1" aria-labelledby="modalpopupTitle" style="display: block; padding-right: 17px;" aria-modal="true" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content p-0">
                <div class="modal-header p-0">
                    <button type="button" class="btn btn-warning btn-sm p-1" data-dismiss="modal">X</button>
                </div>
                <div class="modal-body p-0" title="{{$popup->titulo}}">
                    <div id="carouselExampleControls2" class="banner_content_wrap carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                          <?php $estado=false; ?>
                          @foreach($imagenes as $row)
                            <div class="carousel-item {{ $estado==false ? 'active' : '' }} p-0" data-img-src="">
                                <a target="_blank" href="{{$row->enlace}}">
                                    <img src="{{ asset('img/popup/'.$row->imagen) }}" class="w-fluid" width="" alt="">
                                </a>
                            </div>
                          <?php $estado = true ?>
                          @endforeach
                        </div>
                        <div class="carousel-nav">
                            <a class="carousel-control-prev" style="background: blue" href="#carouselExampleControls2" role="button" data-slide="prev">
                                <i class="ion-chevron-left"></i>
                            </a>
                            <a class="carousel-control-next" style="background: blue" href="#carouselExampleControls2" role="button" data-slide="next">
                                <i class="ion-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        <?php }  ?>
@endsection
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v16.0" nonce="9urXt4qV"></script>
