@extends('principal.plantilla')
@section('title', 'UGEL - HUACAYBAMBA')
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

<section class="banner_section p-0 full_screen">
    <div id="carouselExampleControls" class="banner_content_wrap carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <?php $estado=false; ?>
          @foreach($sliders as $row)
            <div class="carousel-item {{ $estado==false ? 'active' : '' }} background_bg overlay_bg_10" data-img-src="{{ asset('img/slider/'.$row->img_slider) }}">
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
  <!-- END SECTION BANNER -->




<div class="row">
    <div class="col-9">
        <section class="pb-0 ps-2">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="single_categories">
                            <a href="{{route('directorioweb')}}" class="bg_danger small p-3">
                                <i class="fa fa-desktop"></i>
                                Directorio Institucional
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="single_categories">
                            <a href="#" class="bg_light_green small p-3">
                                <i class="fa fa-chart-line"></i>
                                2500+ Courses
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="single_categories">
                            <a href="{{route('documentosdegestionweb')}}" class="bg_default small p-3">
                                <i class="fa fa-book"></i>
                                Gestion de Documentos
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="single_categories">
                            <a href="{{route('galerias')}}" class="bg_pink small p-3">
                                <i class="fa fa-camera"></i>
                                Galeria de Imagenes
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="single_categories">
                            <a href="#" class="bg_blue small p-3">
                                <i class="fa fa-heartbeat"></i>
                                    academics
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="single_categories">
                            <a href="#" class="bg_orange small p-3">
                                <i class="fa fa-code"></i>
                                Campus life
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <div class="single_categories">
                            <a href="#" class="bg_danger small p-3">
                                <i class="fa fa-globe"></i>
                                Scholarship
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="single_categories">
                            <a href="#" class="bg_light_green small p-3">
                                <i class="fa fa-chart-line"></i>
                                2500+ Courses
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="single_categories">
                            <a href="#" class="bg_default small p-3">
                                <i class="fa fa-book"></i>
                                Admission
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="single_categories">
                            <a href="#" class="bg_pink small p-3">
                                <i class="fa fa-camera"></i>
                                Global exposure
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="single_categories">
                            <a href="#" class="bg_blue small p-3">
                                <i class="fa fa-heartbeat"></i>
                                    academics
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="single_categories">
                            <a href="#" class="bg_orange small p-3">
                                <i class="fa fa-code"></i>
                                Campus life
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

      <!-- START SECTION NOTICIAS -->
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
          </div>
        </section>
    </div>
    <div class="col p-0 pt-1 me-2" style="margin-right: 40px">
        @foreach ($mainrightitem as $item)
        <div class="mb-2 p-0">
            <a href="{{$item->url}}" target="_blank" class="btn btn-primary p-0" title="{{$item->nombre}}">
                <img src="{{asset('img/mainright/'.$item->imagen)}}" alt="{{$item->nombre}}" class="img-fluid">
            </a>
        </div>
        @endforeach
    </div>
</div>
        <!-- END SECTION NOTICIAS -->
        <!-- START SECTION COUNTER -->
        <section class="parallax_bg overlay_bg_blue_70 p-4" data-parallax-bg-image="{{asset('plantillas/eduglobal/assets/images/video_bg.jpg')}}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-6 ">
                        <div class="box_counter counter_style1 text_white text-center animation" data-animation="fadeInUp" data-animation-delay="0.02s">
                        <div class="counter_icon">
                            <img src="{{ asset('plantillas/eduglobal/assets/images/counter_icon1.png') }}" alt="counter_icon1" />
                            </div>
                            <div class="counter_content">
                                <h3 class="counter_text"><span class="counter">1800</span>+</h3>
                                <p>Students</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-6 ">
                        <div class="box_counter counter_style1 text_white text-center animation" data-animation="fadeInUp" data-animation-delay="0.03s">
                            <div class="counter_icon">
                            <img src="{{ asset('plantillas/eduglobal/assets/images/counter_icon2.png') }}" alt="counter_icon2" />
                            </div>
                            <div class="counter_content">
                                <h3 class="counter_text"><span class="counter">70</span></h3>
                                <p>Courses</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-6 ">
                        <div class="box_counter counter_style1 text_white text-center animation" data-animation="fadeInUp" data-animation-delay="0.04s">
                            <div class="counter_icon">
                            <img src="{{ asset('plantillas/eduglobal/assets/images/counter_icon3.png') }}" alt="counter_icon3" />
                            </div>
                            <div class="counter_content">
                                <h3 class="counter_text"><span class="counter">700</span>+</h3>
                                <p>Certified teachers</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-6 ">
                        <div class="box_counter counter_style1 text_white text-center animation" data-animation="fadeInUp" data-animation-delay="0.05s">
                        <div class="counter_icon">
                            <img src="{{ asset('plantillas/eduglobal/assets/images/counter_icon4.png') }}" alt="counter_icon4" />
                            </div>
                            <div class="counter_content">
                                <h3 class="counter_text"><span class="counter">1200</span>+</h3>
                                <p>Award Winning</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END SECTION COUNTER -->
        <!-- START SECTION COMUNICADOS -->
        <section class="bg_gray">
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
    <?php if(isset($popup->titulopopup)){ ?>
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
                                <a target="_blank" href="{{$popup->enlace_popup}}">
                                    <img src="{{ asset('img/popup/'.$row->imagen) }}" class="w-fluid" width="" alt="">
                                </a>
                            </div>
                          <?php $estado = true ?>
                          @endforeach
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
                </div>
              </div>
            </div>
          </div>
        <?php }  ?>
@endsection
