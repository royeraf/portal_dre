@extends('principal.plantilla')
@section('title', 'UGEL - HUACAYBAMBA')
@section('content')

<main id="main">
<section style="margin-top: 90px">
  <div class="container">

        <h3>{{$paginaweb->nom_pagina}}</h3>
        <?php echo $paginaweb->cont_pagina ?>

  </div>
</section><!-- End About Section -->
</main>

@endsection