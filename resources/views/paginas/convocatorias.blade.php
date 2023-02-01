@extends('principal.plantilla')
@section('title', 'UGEL - HUACAYBAMBA')
@section('content')
<!-- START SECTION BREADCRUMB -->
<section class="page-title-light breadcrumb_section parallax_bg overlay_bg_50" data-parallax-bg-image="{{asset('img/bc.jpeg')}}">
	<div class="container">
    	<div class="row align-items-center">
        	<div class="col-sm-6">
            	<div class="page-title">
            		<h1>CONVOCATORIAS</h1>
                </div>
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Convocatoria</li>
                  </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION BANNER -->
<section id="about" class="about pt-1">
  <div class="container">
        @foreach ($convocatorias as $row)
        <div class="card">
          <div class="card-header text-light py-0">
            <div class="row p-0">
                <div class="col bg-warning pe-1 m-0" align="right">
                    <h5><i class="far fa-calendar-alt"></i></h5>
                </div>
                <div class="col-11 ps-0" style="background-color: #072044">
                    <h5 class=" text-light">{{$row->fecha_inicio}}&nbsp;|&nbsp;{{$row->tipo.' : '.$row->titulo}}</h5>
                </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
                <div class="col" style="padding-left: 10px; margin-left:40px">
                    <?php echo $row->descripcion ?>
                </div>
                <div class="col">
                    <ul>
                    @foreach ($row->archivos as $archivo)
                        <li><a target="_blank" href="{{$archivo['url_archivo']}}"><i class="fa fa-file-pdf"></i> {{$archivo['nom_archivo']}}</a></li>
                    @endforeach
                    </ul>
                </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
                <div class="col">
                    <div class="alert alert-secondary p-1 px-5" role="alert">
                        <i class="far fa-calendar-alt"></i>&nbsp;desde&nbsp;{{$row->fecha_inicio}}
                    </div>
                </div>
                <div class="col">
                    <div class="alert alert-secondary p-1 px-5" role="alert">
                        <i class="far fa-calendar-alt"></i>&nbsp;hasta&nbsp;{{$row->fecha_termino}}
                    </div>
                </div>
                <div class="col">
                    <div class="alert alert-secondary p-1 px-5" role="alert">
                        {{$row->tipo}}
                    </div>
                </div>
                <div class="col">
                    <div class="alert text-bg-{{$row->estado=='ABIERTO' ? 'success' : 'secondary'}} p-1 text-center" role="alert">
                        <i class="fas fa-clock"></i>&nbsp;{{$row->estado}}
                    </div>
                </div>
            </div>

          </div>
        </div><br>
        @endforeach
    </table>
    {{$convocatorias->links()}}

<br>
<br>
<br>



  </div>
</section><!-- End About Section -->
@endsection
