<!-- filepath: c:\Users\liliana\Desktop\Sistemas DRE\drehco\resources\views\paginas\epr.blade.php -->
@extends('principal.plantilla')
@section('title', 'PER - HUANUCO')
@section('content')

<!-- START SECTION BREADCRUMB -->
<section class="page-title-light breadcrumb_section parallax_bg overlay_bg_50" data-parallax-bg-image="{{asset('img/bc.jpeg')}}">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h1>PER - DOCUMENTOS</h1>
                </div>
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-sm-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">PER</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION BREADCRUMB -->

<!-- START SECTION EPR -->
<section class="our-webcoderskull padding-lg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h2 class="mb-3">Documentos PER</h2>
                    <p class="lead text-muted">Seleccione un documento para visualizar en formato de libro digital</p>
                </div>
                
                <div class="row">
                    @foreach ($pdfs as $pdf)
                    <div class="col-md-6 mb-4">
                        <div class="epr-card">
                            <div class="epr-card-body">
                                <div class="epr-icon">
                                    <i class="{{ $pdf['icono'] }}"></i>
                                </div>
                                <h4 class="epr-title">{{ $pdf['titulo'] }}</h4>
                                <p class="epr-description">{{ $pdf['descripcion'] }}</p>
                                <a href="{{ route('epr.pdf', $pdf['id']) }}" class="epr-btn">
                                    <i class="fas fa-book-open me-2"></i>
                                    Ver Documento
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION EPR -->

<style>
.epr-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 30px;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.epr-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    border-color: #007bff;
}

.epr-card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.epr-icon {
    font-size: 3.5rem;
    color: #dc3545;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.epr-card:hover .epr-icon {
    color: #007bff;
    transform: scale(1.1);
}

.epr-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 15px;
    line-height: 1.3;
}

.epr-description {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 25px;
    flex-grow: 1;
}

.epr-btn {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    padding: 12px 25px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
}

.epr-btn:hover {
    background: linear-gradient(135deg, #0056b3 0%, #004494 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
    color: white;
    text-decoration: none;
}

.epr-btn i {
    margin-right: 8px;
}

@media (max-width: 768px) {
    .epr-card {
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .epr-icon {
        font-size: 2.5rem;
    }
    
    .epr-title {
        font-size: 1.3rem;
    }
}
</style>

@endsection