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
            <div class="carousel-item {{ $estado==false ? 'active' : '' }} background_bg overlay_bg_50" data-img-src="{{ asset('img/slider/'.$row->img_slider) }}">
                <div class="banner_slide_content">
                    <div class="container"><!-- STRART CONTAINER -->
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-sm-12 text-center">
                            <div class="banner_content animation text_white" data-animation="fadeIn" data-animation-delay="0.8s">
                                <h2 class="font-weight-bold animation text-uppercase" data-animation="zoomIn" data-animation-delay="1s">{{$row->titulo}}</h2>
                                <p class="animation" data-animation="zoomIn" data-animation-delay="1.5s">{{Str::lower($row->descripcioncorta)}}</p>
                                @if ($row->link!=null && $row->link!='')
                                <a class="btn btn-outline-white animation rounded-0" href="{{$row->link}}" data-animation="zoomIn" data-animation-delay="1.8s">IR</a>                 
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
    <div class="col-10">
        <section class="pb-0">
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
                            <a href="#" class="bg_default small p-3">
                                <i class="fa fa-book"></i>
                                Admission
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
        <!-- END SECTION NOTICIAS -->
    <!-- START SECTION COUNTER -->
    <section class="parallax_bg overlay_bg_blue_70" data-parallax-bg-image="{{asset('plantillas/eduglobal/assets/images/video_bg.jpg')}}">
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




    </div>
    <div class="col p-0">
        <div class="m-1 mt-3">
            <a href="http://www.regionhuanuco.gob.pe/pagina/205" target="_blank" class="btn btn-primary p-0">
                <img src="http://gestionportales.regionhuanuco.gob.pe/storage/seccion/hAQJ9P8dN1ngB135zJFxDUrMzYvNwYawA3Xq9pTY.jpeg" alt="User Avatar" class="img-fluid">
            </a>
        </div>
        <div class="m-2 bg-primary rounded p-1">
            <a href="https://reclamos.servicios.gob.pe/?institution_id=67" target="_blank">
                <img src="http://gestionportales.regionhuanuco.gob.pe/storage/seccion/Ho6QlvdokuBdyD7JJ51Fa3DKxe52azfn2fqHhvoE.png" alt="User Avatar" class="img-fluid">
            </a>            
        </div>
        <div class="m-2">
            <a href="/pagina/143" class="btn btn-primary mb-1 titulonot_2 bton_enlace">
                <i class="fas fa-address-card"></i> Medios para la presentación de presuntas denuncias de  actos de corrupción
            </a>
        </div>
        <div class="m-2">
            <a href="http://digital.regionhuanuco.gob.pe/tramite/documento/print/Escaneo0018_rotated_removed.pdf?&id=483158&tipo=1&id_documento=2893270" class="btn btn-info mb-1 titulonot_2 bton_enlace">
                <i class="fas fa-address-card"></i>  {{Str::lower('FORMULARIOS ESTANDARIZADOS A UTILIZAR EN PROCEDIMIENTOS ADMINISTRATIVOS DE LA SUB DIRECCION DE PESQUERIA')}}
            </a>
        </div>
        <div class="m-2">
            <a href="http://digital.regionhuanuco.gob.pe/tramite/documento/print/Escaneo0018_rotated_removed.pdf?&amp;id=483158&amp;tipo=1&amp;id_documento=2893270" class="btn btn-info btn-block mb-1 titulonot_2 bton_enlace">
                <i class="fas fa-address-card"></i> {{Str::lower('FORMULARIOS ESTANDARIZADOS A UTILIZAR EN PROCEDIMIENTOS ADMINISTRATIVOS DE LA SUB DIRECCION DE PESQUERIA')}}
            </a>
        </div>
        <div class="m-2">
            <a style="font-size: 12px" href="https://drive.google.com/file/d/1CUn94n1E3DBWSAClv-Q-hENFnQ3GyLZv/view?usp=sharing" class="btn btn-danger mb-1 titulonot_2 bton_enlace">
                <i class="fas fa-address-card"></i> Apendice N°2 - Formatos(Organo de Control Interno)
            </a>
        </div>
        <div class="m-2">
            <a href="https://procesocompras2022.qaliwarma.gob.pe/" target="_blank" class="dropdown-item bg-danger mb-1">
                <div class="media"><img src="http://gestionportales.regionhuanuco.gob.pe/storage/seccion/CKfBIzI4B1EZBQGJmEMJCM86I5CifftFvZ7MGtz8.png" alt="User Avatar" class="img-fluid"></div>
             </a>
        </div>
        <div class="m-2">
            <a href="https://drive.google.com/drive/folders/1Bi1MXt9Br9Et2O4xUONkF-lASDtwnn83?usp=sharing" class="btn btn-primary btn-block mb-1 titulonot_2 bton_enlace"><i class="fas fa-address-card"></i> LISTA DE PAGO DEUDA SOCIAL</a>
        </div>
        <div class="m-2">
            <a href="/cursos" class="btn btn-info btn-block mb-1 titulonot_2 bton_enlace">
                <i class="fas fa-address-card"></i> CURSOS y BECAS DISPONIBLES - ORCI
            </a>
        </div>
        <div class="m-2">
            <a href="pagina/73" class="btn btn-dark mb-1 titulonot_2 bton_enlace">
                <i class="fas fa-address-card"></i> TRAMITES CON LA CLAVE SOL
            </a>
        </div>
        <div class="m-2">
            <a href="https://drive.google.com/file/d/19OYajsbeWdBNEUXcaEf4q-QUnstXWP0E/view?usp=sharing" target="_blank" class="dropdown-item bg-danger mb-1">
                <img src="http://gestionportales.regionhuanuco.gob.pe/storage/seccion/6VwYkW5nCNmhxtjRWEJol4BOEhZSgIRrKfL4m5VK.png" alt="User Avatar" class="img-fluid">
             </a>
        </div>
        <div class="m-2">
            <a href="http://digital.regionhuanuco.gob.pe/tramite/documento/print/MEMO%20157%202021%20GGR.pdf?&amp;id=218147&amp;tipo=1&amp;id_documento=2344413" class="btn btn-primary btn-block mb-1 titulonot_2 bton_enlace">
                <i class="fas fa-address-card"></i> Transparencia y Lucha contra la Corrupcion en el contexto de emergencia COVID-19
            </a>
        </div>
        <div class="m-2">
            <a href="/pagina/175" class="btn btn-info btn-block mb-1 titulonot_2 bton_enlace">
                <i class="fas fa-address-card"></i> NEUTRALIDAD POR PERIODO ELECTORAL 2022
            </a>
        </div>
        <div class="m-2 bg-primary rounded p-1">
            <a href="https://drive.google.com/file/d/1h10KyuNOs1O46wxjf9I-a3T1oPTzTABv/view?usp=sharing" target="_blank" class="dropdown-item bg-gray mb-1">
                <img src="http://gestionportales.regionhuanuco.gob.pe/storage/seccion/XNju5LHTnVDHRtHWpocSQBgeZaUbsRsy5DOqG6SZ.png" alt="User Avatar" class="img-fluid">
             </a>
        </div>
        <div class="m-2">
            <a href="http://forestal.regionhuanuco.gob.pe" target="_blank" class="dropdown-item bg-dark mb-1">
                <img src="http://gestionportales.regionhuanuco.gob.pe/storage/seccion/giFowojnyLiYzAjQVQZVItZcWkoLuuK2lBkA9m0t.png" alt="User Avatar" class="img-fluid">
             </a>
        </div>
        <div class="m-2">
            <a href="https://www.gob.pe/regionhuanuco" target="_blank" class="dropdown-item bg-danger mb-1">
                <img src="http://gestionportales.regionhuanuco.gob.pe/storage/seccion/tWqLlUALtkOFgGhoXUVYE0OimlosI6X2NOogjArX.svg" alt="User Avatar" class="img-fluid">
             </a>
        </div>
        <div class="m-2">
            <a href="https://www.facebook.com/Promoci%C3%B3n-de-la-Inversi%C3%B3n-Privada-Regi%C3%B3n-Hu%C3%A1nuco-236719264323838/" target="_blank" class="dropdown-item bg-primary mb-1">
                <img src="http://gestionportales.regionhuanuco.gob.pe/storage/seccion/Vivx48F5CpZ4gersPSo8ANpr2S3lgVQvvxrmFNBR.png" alt="User Avatar" class="img-fluid">
             </a>
        </div>
        <div class="m-2">
            <a href="https://appdji.contraloria.gob.pe/djic/" target="_blank" class="dropdown-item bg-danger mb-1">
                <img src="http://gestionportales.regionhuanuco.gob.pe/storage/seccion/uCdLGlsxoZw8ZbB75HQc8UOBqMeJyRaT3FQdK8J0.png" alt="User Avatar" class="img-fluid">
             </a>
        </div>
    </div>
</div>
        

    
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
    


@endsection