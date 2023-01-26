@extends('principal.plantilla')
@section('title', 'UGEL - HUACAYBAMBA')
@section('content')

<main id="main">
<section id="about" class="about" style="margin-top: 90px">
  <div class="container">
    <div class="row content">
      <div class="col-lg-6">
        <h2>{{$noticia->titulo}}</h2>
      </div>
      <div class="col-lg-6 pt-4 pt-lg-0">
        <?php echo $noticia->contenido ?>
        <img src="{{asset('img/noticias/'.$noticia->img1)}}" class="img-fluid img-thumbnail" />
      </div>
    </div>

  </div>
</section><!-- End About Section -->
</main>

@endsection