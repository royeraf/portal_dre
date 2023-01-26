@extends('principal.plantilla')
@section('title', 'UGEL - HUACAYBAMBA')
@section('content')
<main id="main">
<section id="about" class="about" style="margin-top: 90px">
  <div class="container">
    <h2>DIRECTORIO</h2><br>
    {{-- <div class="row">
        <div class="col">
            <div class="card" style="width: 18rem;">
                <img src="{{asset('img/fotos/'.$director->foto)}}" class="card-img-top rounded" width="60" />
                <div class="card-body">
                  <h5 class="card-title">{{$director->apenom}}</h5>
                  <p class="card-text">{{$director->cargo}}</p>
                  <span class="fw-light">{{$director->email}}</span>
                </div>
              </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <img src="{{asset('img/fotos/'.$secretaria->foto)}}" class="card-img-top rounded" width="60" />
                <div class="card-body">
                  <h5 class="card-title">{{$secretaria->apenom}}</h5>
                  <p class="card-text">{{$secretaria->cargo}}</p>
                  <span class="fw-light">{{$secretaria->email}}</span>
                </div>
              </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <img src="{{asset('img/fotos/'.$jefeagi->foto)}}" class="card-img-top rounded" width="60" />
                <div class="card-body">
                  <h5 class="card-title">{{$jefeagi->apenom}}</h5>
                  <p class="card-text">{{$jefeagi->cargo}}</p>
                  <span class="fw-light">{{$jefeagi->email}}</span>
                </div>
            </div>
            <br><br>
        </div>
    </div> --}}
    <div class="row">
        <div class="col">
            <div class="card mb-3 text-dark bg-light" style="max-width: 540px;">
                <div class="row g-0">
                  <div class="col-md-4">
                    <img src="{{asset('img/fotos/'.$director->foto)}}" class="img-fluid rounded-start" alt="...">
                  </div>
                  <div class="col-md-8">
                    <div class="card-body">
                      <h5 class="card-title">{{$director->cargo}}</h5>
                      <p class="card-text">{{$director->apenom}}</p>
                      <p class="card-text"><small class="text-muted">{{$director->email}}</small></p>
                      <p class="card-text"><small class="text-muted">Cel: {{$director->celular}}</small></p>
                    </div>
                  </div>
                </div>
            </div> 
        </div>
        <div class="col">
            <div class="card mb-3 text-dark bg-light" style="max-width: 540px;">
                <div class="row g-0">
                  <div class="col-md-4">
                    <img src="{{asset('img/fotos/'.$jefeagi->foto)}}" class="img-fluid rounded-start" alt="...">
                  </div>
                  <div class="col-md-8">
                    <div class="card-body">
                      <h5 class="card-title">{{$jefeagi->cargo}}</h5>
                      <p class="card-text">{{$jefeagi->apenom}}</p>
                      <p class="card-text"><small class="text-muted">{{$jefeagi->email}}</small></p>
                      <p class="card-text"><small class="text-muted">Cel: {{$jefeagi->celular}}</small></p>
                    </div>
                  </div>
                </div>
            </div> 
        </div>
    </div>
    <div class="row">
      <div class="col">
          <div class="card mb-3 text-dark bg-light" style="max-width: 540px;">
              <div class="row g-0">
                <div class="col-md-4">
                  <img src="{{asset('img/fotos/'.$jefeagp->foto)}}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title">{{$jefeagp->cargo}}</h5>
                    <p class="card-text">{{$jefeagp->apenom}}</p>
                    <p class="card-text"><small class="text-muted">{{$jefeagp->email}}</small></p>
                    <p class="card-text"><small class="text-muted">Cel: {{$jefeagp->celular}}</small></p>
                  </div>
                </div>
              </div>
          </div> 
      </div>
      <div class="col">
          <div class="card mb-3 text-dark bg-light" style="max-width: 540px;">
              <div class="row g-0">
                <div class="col-md-4">
                  <img src="{{asset('img/fotos/'.$jefeaga->foto)}}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title">{{$jefeaga->cargo}}</h5>
                    <p class="card-text">{{$jefeaga->apenom}}</p>
                    <p class="card-text"><small class="text-muted">{{$jefeaga->email}}</small></p>
                    <p class="card-text"><small class="text-muted">Cel: {{$jefeaga->celular}}</small></p>
                  </div>
                </div>
              </div>
          </div> 
      </div>
  </div>
    <div class="row">
        <br>
        <div class="col">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border border-slate-500">ID</th>
                        <th class="border border-slate-500" width="30%">Apellidos y Nombres</th>
                        <th class="border border-slate-500">FOTO</th>
                        <th class="border border-slate-500">DNI</th>
                        <th class="border border-slate-500">Area</th>
                        <th class="border border-slate-500">Cargo</th>
                        <th class="border border-slate-500">Email</th>
                        <th class="border border-slate-500">Celular</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($registros as $item)
                <tr>
                    <td class="border border-slate-500">{{ $item->id }}</td>
                    <td class="border border-slate-500">{{ $item->apenom }}</td>
                    <td class="border border-slate-500">
                        <?php
                        $image_path = public_path('img/fotos/').$item->foto; 
                        if (file_exists($image_path)){  ?>
                        <div class="col">
                            <img src="{{asset('img/fotos/'.$item->foto)}}" class="img-fluid img-thumbnail" width="100" />
                        </div>
                        <?php } ?>
                    </td>
                    <td class="border border-slate-500">{{ $item->dni }}</td>
                    <td class="border border-slate-500">{{ $item->area }}</td>
                    <td class="border border-slate-500">{{ $item->cargo }}</td>
                    <td class="border border-slate-500">{{ $item->email }}</td>
                    <td class="border border-slate-500">{{ $item->celular }}</td>                                                          
                </tr>
                </tbody>
                @endforeach
            </table>            
        </div>
    </div>

  </div>
</section><!-- End About Section -->
</main>

@endsection