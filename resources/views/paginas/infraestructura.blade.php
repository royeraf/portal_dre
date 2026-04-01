@extends('principal.plantilla')
@section('title', 'DRE - HUANUCO')
@section('content')
<main id="main">
<section id="about" class="about pt-2">
  <div class="container">
  <div class="row justify-content-center">
        	<div class="col-xl-6 col-lg-8">
            	<div class="text-center animation" data-animation="fadeInUp" data-animation-delay="0.01s">
                    <div class="heading_s1 text-center">
                    <span class="sub_heading">DRE HUÁNUCO</span> 
                    <h2>Dirección de Gestión Institucional</h2>
                        <h4>Área de Infraestructura</h4>
                    </div>
                    </div>
            </div>
        </div>
  <div class="row m-0">
        <div class="col">
          <div class="banner_section m-0 p-4 full_screen">
            <div id="carouselExampleControls" class="banner_content_wrap carousel slide m-4" data-ride="carousel">
                <div class="carousel-inner" style="">
                  <?php $estado=false; ?>
                  @foreach($registros as $row)
                    <div class="carousel-item {{ $estado==false ? 'active' : '' }} background_bg" data-img-src="{{asset('img/infraestructura/'.$row->imagen)}}">
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
          </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="icon_box icon_box_style1 animation" data-animation="fadeInUp" data-animation-delay="0.02s">
                	<div class="box_icon mb-3">
                		<i class="fa fa-book text_default"></i>
                    </div>
                    <div class="intro_desc">
                        <h5>Normas Legales</h5>
                        <p>LEY Nº 31318, Ley que regula el saneamiento físico-legal de los bienes inmuebles del sector educación destinados a instituciones educativas públicas</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
            	<div class="icon_box icon_box_style1 animation" data-animation="fadeInUp" data-animation-delay="0.03s">
                	<div class="box_icon mb-3">
                		<i class="fa fa-globe text_default"></i>
                    </div>
                    <div class="intro_desc">
                        <h5>Pautas para la publicación</h5>
                        <p>Aqui encontraras los requisitos para la publicacion de los predios que están en proceso de saneamiento</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
            	<div class="icon_box icon_box_style1 animation"  data-animation="fadeInUp" data-animation-delay="0.05s">
                	<div class="box_icon mb-3">
                        <i class="fa fa-child text_default"></i>
                    </div>
                    <div class="intro_desc">
                        <h5>II.EE. Saneadas al 2024</h5>
                        <p>Aquí encontraras cantidad de Instituciones Educativas que fueron saneadas a la fecha</p>
                    </div>
                </div>
            </div> 




    </div>
  </div>
</section><!-- End About Section -->

<div class="row justify-content-center">
        	<div class="col-xl-6 col-lg-8">
            	<div class="text-center animation" data-animation="fadeInUp" data-animation-delay="0.01s">
                    <div class="heading_s1 text-center">
                    <div class="heading_s1 text-center">
                    <span class="sub_heading">Responsable del Área</span> 
                    <h5>Ing. Miguel A. Cruz Venancio</h5>
                        <h4>Ingeniero II</h4>
                    </div>
                    </div>
            </div>
        </div>

</main>
@endsection
