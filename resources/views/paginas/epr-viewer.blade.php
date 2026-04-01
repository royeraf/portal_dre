<!-- filepath: c:\Users\liliana\Desktop\Sistemas DRE\drehco\resources\views\paginas\epr-viewer.blade.php -->
@extends('principal.plantilla')
@section('title', $pdf['titulo'] . ' - EPR')
@section('content')

<!-- START SECTION BREADCRUMB -->
<section class="page-title-light breadcrumb_section parallax_bg overlay_bg_50" data-parallax-bg-image="{{asset('img/bc.jpeg')}}">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-8">
                <div class="page-title">
                    <h1>{{ $pdf['titulo'] }}</h1>
                </div>
            </div>
            <div class="col-sm-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-sm-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('epr.index')}}">EPR</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Visor</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION BREADCRUMB -->

<!-- START SECTION PDF VIEWER -->
<section class="pdf-viewer-section py-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Controles del PDF -->
                <div class="pdf-controls mb-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="controls-left">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-book-open me-2"></i>
                                {{ $pdf['titulo'] }}
                            </h5>
                        </div>
                        
                        <div class="controls-right">
                            <button class="btn btn-outline-success btn-sm me-2" onclick="toggleFullscreen()">
                                <i class="fas fa-expand"></i> Pantalla completa
                            </button>
                            <a href="{{ route('epr.serve', $pdfId) }}" target="_blank" class="btn btn-outline-info btn-sm me-2">
                                <i class="fas fa-external-link-alt"></i> Abrir PDF
                            </a>
                            <a href="{{ route('epr.download', $pdfId) }}" class="btn btn-outline-warning btn-sm me-2">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                            <a href="{{ route('epr.index') }}" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contenedor del Iframe de Heyzine -->
                <div class="iframe-container" id="iframeContainer">
                    <div class="iframe-wrapper">
                        <iframe 
                            id="heyzineIframe"
                            allowfullscreen="allowfullscreen" 
                            allow="clipboard-write" 
                            scrolling="no" 
                            class="fp-iframe" 
                            src="{{ $pdf['iframe_url'] }}" 
                            style="border: 1px solid lightgray; width: 100%; height: 600px;">
                        </iframe>
                        
                        <div class="iframe-loading" id="iframeLoading">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="mt-2">Cargando documento digital...</p>
                        </div>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="document-info mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6><i class="fas fa-info-circle me-2"></i>Características del documento</h6>
                                <ul class="list-unstyled mb-0">
                                    <li><i class="fas fa-check-circle text-success me-2"></i>Formato de libro digital interactivo</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i>Navegación por páginas</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i>Zoom y pantalla completa</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i>Optimizado para todos los dispositivos</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6><i class="fas fa-keyboard me-2"></i>Controles de navegación</h6>
                                <ul class="list-unstyled mb-0">
                                    <li><i class="fas fa-mouse me-2"></i>Click y arrastrar para navegar</li>
                                    <li><i class="fas fa-arrows-alt me-2"></i>Flechas del teclado para cambiar páginas</li>
                                    <li><i class="fas fa-search-plus me-2"></i>Rueda del mouse para zoom</li>
                                    <li><i class="fas fa-expand me-2"></i>Doble click para pantalla completa</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION PDF VIEWER -->

<style>
.pdf-viewer-section {
    background: #f8f9fa;
    min-height: 80vh;
}

.pdf-controls {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 100;
    border-left: 4px solid #007bff;
}

.iframe-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 6px 25px rgba(0,0,0,0.15);
    overflow: hidden;
    position: relative;
    border: 2px solid #e9ecef;
}

.iframe-wrapper {
    position: relative;
    min-height: 600px;
}

.fp-iframe {
    display: block;
    transition: opacity 0.3s ease;
}

.iframe-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: #6c757d;
    z-index: 10;
}

.document-info {
    margin-top: 30px;
}

.info-card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border-left: 4px solid #28a745;
    height: 100%;
}

.info-card h6 {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 15px;
    font-size: 1.1rem;
}

.info-card li {
    padding: 5px 0;
    color: #6c757d;
    font-size: 0.9rem;
}

.controls-left, .controls-right {
    display: flex;
    align-items: center;
}

/* Responsive */
@media (max-width: 768px) {
    .pdf-controls .d-flex {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .controls-left, .controls-right {
        justify-content: center;
        width: 100%;
    }
    
    .iframe-wrapper {
        min-height: 400px;
    }
    
    .fp-iframe {
        height: 400px !important;
    }
    
    .info-card {
        margin-bottom: 20px;
    }
}

/* Fullscreen styles */
.iframe-container.fullscreen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 9999;
    border-radius: 0;
    border: none;
}

.iframe-container.fullscreen .fp-iframe {
    height: 100vh !important;
}

.iframe-container.fullscreen .iframe-wrapper {
    height: 100vh;
    min-height: auto;
}

/* Animaciones */
.iframe-container {
    animation: fadeInUp 0.6s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
}
</style>

<script>
// Ocultar loading cuando el iframe carga
document.getElementById('heyzineIframe').addEventListener('load', function() {
    setTimeout(function() {
        document.getElementById('iframeLoading').style.display = 'none';
    }, 1000);
});

// Función para pantalla completa
function toggleFullscreen() {
    const container = document.getElementById('iframeContainer');
    const iframe = document.getElementById('heyzineIframe');
    
    if (!container.classList.contains('fullscreen')) {
        container.classList.add('fullscreen');
        iframe.style.height = '100vh';
        
        // Entrar en fullscreen real del navegador
        if (container.requestFullscreen) {
            container.requestFullscreen();
        } else if (container.webkitRequestFullscreen) {
            container.webkitRequestFullscreen();
        } else if (container.msRequestFullscreen) {
            container.msRequestFullscreen();
        }
    } else {
        container.classList.remove('fullscreen');
        iframe.style.height = '600px';
        
        // Salir de fullscreen
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
}

// Manejar salida de fullscreen con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const container = document.getElementById('iframeContainer');
        if (container.classList.contains('fullscreen')) {
            toggleFullscreen();
        }
    }
});

// Manejar cambios de fullscreen
document.addEventListener('fullscreenchange', function() {
    const container = document.getElementById('iframeContainer');
    const iframe = document.getElementById('heyzineIframe');
    
    if (!document.fullscreenElement) {
        container.classList.remove('fullscreen');
        iframe.style.height = '600px';
    }
});

// Compatibilidad con otros navegadores
document.addEventListener('webkitfullscreenchange', function() {
    const container = document.getElementById('iframeContainer');
    const iframe = document.getElementById('heyzineIframe');
    
    if (!document.webkitFullscreenElement) {
        container.classList.remove('fullscreen');
        iframe.style.height = '600px';
    }
});
</script>

@endsection