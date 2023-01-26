@extends('principal.plantilla')
@section('title', 'UGEL - HUACAYBAMBA')
@section('content')
<main id="main">
<section id="about" class="about" style="margin-top: 90px">
  <div class="container">
    <h2>COMUNICADOS</h2><br>
    <div class="row">
        @foreach ($comunicados as $item)
        <div class="col">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="{{asset('img/comunicados/'.$item->imagen)}}" alt="Card image cap">
                <div class="card-body">
                <h5 class="card-title">{{$item->titulo}}</h5>
                @if ($item->url!='' && $item->url!=null)
                <a target="_blank" href="{{$item->url}}" title="Ver Mas"><i class="fa-solid fa-eye"></i></a>
                @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
  </div>
</section><!-- End About Section -->
</main>
@endsection