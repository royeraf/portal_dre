<!-- filepath: c:\Users\liliana\Desktop\Sistemas DRE\drehco\resources\views\paginas\direcciones\show.blade.php -->
@extends('principal.plantilla')
@section('title', $direccion->nombre . ' - DRE Huánuco')

@section('content')
@php
    // Obtener todos los eventos de todas las áreas de esta dirección
    $todosLosEventos = collect();
    foreach($direccion->areasMenu as $area) {
        if($area->eventos) {
            foreach($area->eventos as $evento) {
                $todosLosEventos->push($evento);
            }
        }
    }
    $eventosChunks = $todosLosEventos->chunk(3);
@endphp

<style>
/* Estilos empresariales sobrios */
.enterprise-container {
    background: #f5f7fa;
    min-height: 100vh;
}

.content-wrapper {
    background: #ffffff;
    min-height: calc(100vh - 80px);
    margin: 40px 20px;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.header-section {
    background: #6e82a4 ;
    padding: 40px 0;
    position: relative;
}

.header-section::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: #4a5568;
}

.header-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: center;
    color: white;
}

.header-icon {
    width: 70px;
    height: 70px;
    background: #4a5568;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 24px;
    border: 1px solid #718096;
}

.header-title {
    font-size: 28px;
    font-weight: 600;
    margin: 0 0 6px 0;
    letter-spacing: -0.25px;
}

.header-subtitle {
    font-size: 15px;
    opacity: 0.8;
    margin: 0;
}

.main-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 32px 20px;
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 32px;
}

/* Sidebar empresarial */
.enterprise-sidebar {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    height: fit-content;
    position: sticky;
    top: 32px;
}

.sidebar-header {
    background: #4a5568;
    color: white;
    padding: 20px;
    font-size: 16px;
    font-weight: 500;
    display: flex;
    align-items: center;
}

.sidebar-header i {
    margin-right: 8px;
    font-size: 16px;
}

.sidebar-nav {
    max-height: 450px;
    overflow-y: auto;
}

.nav-item {
    display: block;
    padding: 16px 20px;
    text-decoration: none;
    color: #4a5568;
    border-bottom: 1px solid #e2e8f0;
    transition: all 0.2s ease;
    position: relative;
}

.nav-item:hover {
    background: #f7fafc;
    color: #2d3748;
    text-decoration: none;
    transform: translateX(2px);
}

.nav-item.active {
    background: #edf2f7;
    color: #2d3748;
    border-left: 3px solid #4a5568;
    font-weight: 500;
}

.nav-item-title {
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
}

.nav-item-title i {
    margin-right: 6px;
    font-size: 10px;
    color: #a0aec0;
}

.nav-item-desc {
    font-size: 12px;
    color: #718096;
    line-height: 1.3;
}

/* Área de contenido */
.content-area {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

.area-header {
    background: #f7fafc;
    padding: 24px;
    border-bottom: 1px solid #e2e8f0;
}

.area-title {
    font-size: 24px;
    font-weight: 600;
    color: #2d3748;
    margin: 0 0 6px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.status-badge {
    background: #4a5568;
    color: white;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 500;
}

.area-description {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 20px;
    margin: 16px 0;
    color: #4a5568;
    line-height: 1.6;
}

.images-section {
    padding: 24px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.image-card {
    background: #f7fafc;
    border-radius: 8px;
    padding: 16px;
    border: 1px solid #e2e8f0;
}

.image-card h3 {
    font-size: 15px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
}

.image-card h3 i {
    margin-right: 6px;
    color: #4a5568;
}

.image-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.06);
    transition: transform 0.2s ease;
}

.image-card img:hover {
    transform: scale(1.01);
}

/* Carousel de eventos del área */
.area-events-carousel {
    background: #f7fafc;
    padding: 24px;
    border-top: 1px solid #e2e8f0;
}

.events-carousel-header {
    text-align: center;
    margin-bottom: 24px;
}

.events-carousel-header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #2d3748;
    margin: 0 0 4px 0;
}

.events-carousel-header p {
    font-size: 13px;
    color: #718096;
    margin: 0;
}

.events-carousel-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}

.events-carousel-track {
    display: flex;
    transition: transform 0.4s ease;
}

.events-carousel-slide {
    min-width: 100%;
    display: flex;
    justify-content: center;
    gap: 16px;
    padding: 0 16px;
}

.event-card {
    background: white;
    border-radius: 8px;
    padding: 20px;
    width: 280px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid #e2e8f0;
    transition: transform 0.2s ease;
}

.event-card:hover {
    transform: translateY(-2px);
}

.event-icon {
    width: 40px;
    height: 40px;
    background: #4a5568;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
}

.event-icon i {
    color: white;
    font-size: 16px;
}

.event-card h4 {
    font-size: 15px;
    font-weight: 600;
    color: #2d3748;
    margin: 0 0 6px 0;
    line-height: 1.3;
}

.event-card p {
    color: #718096;
    font-size: 12px;
    line-height: 1.4;
    margin: 0 0 12px 0;
}

.event-area-tag {
    background: #edf2f7;
    color: #4a5568;
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 10px;
    font-weight: 500;
    margin-bottom: 12px;
    display: inline-block;
}

.event-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
}

.event-btn {
    background: #4a5568;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
    font-size: 10px;
    display: inline-flex;
    align-items: center;
    transition: all 0.2s ease;
}

.event-btn:hover {
    background: #2d3748;
    text-decoration: none;
    color: white;
}

.event-btn i {
    margin-right: 4px;
}

/* Indicadores del carousel de eventos */
.events-carousel-indicators {
    display: flex;
    justify-content: center;
    margin-top: 16px;
    gap: 6px;
}

.events-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #cbd5e1;
    cursor: pointer;
    transition: all 0.2s ease;
}

.events-indicator.active {
    background: #4a5568;
    transform: scale(1.2);
}

/* Responsive */
@media (max-width: 1024px) {
    .main-content {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    
    .events-carousel-slide {
        flex-direction: column;
        align-items: center;
    }
    
    .event-card {
        width: 260px;
    }
}

/* Scrollbar personalizado */
.sidebar-nav::-webkit-scrollbar {
    width: 4px;
}

.sidebar-nav::-webkit-scrollbar-track {
    background: #f1f5f9;
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 2px;
}

.sidebar-nav::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

<div class="enterprise-container">
    <div class="content-wrapper">
        <!-- Header empresarial -->
        <div class="header-section">
            <div class="header-content">
                <div class="header-icon">
                    <i class="fas fa-building" style="color: white; font-size: 28px;"></i>
                </div>
                <div>
                    <h1 class="header-title">{{ $direccion->nombre }}</h1>
                    <p class="header-subtitle">Dirección Regional de Educación Huánuco</p>
                </div>
            </div>
        </div>

        <div class="main-content">
            <!-- Sidebar empresarial -->
            <aside class="enterprise-sidebar">
                <div class="sidebar-header">
                    <i class="fas fa-list"></i>
                    Áreas Organizacionales
                </div>
                <nav class="sidebar-nav">
                    @if($direccion->areasMenu && $direccion->areasMenu->count() > 0)
                        @foreach($direccion->areasMenu as $area)
                            <a href="/menus/paginaweb/{{ $direccion->idpagina }}?area={{ $area->slug }}" 
                               class="nav-item {{ $area_actual && $area_actual->id === $area->id ? 'active' : '' }}">
                                <div class="nav-item-title">
                                    <i class="fas fa-chevron-right"></i>
                                    {{ $area->nombre }}
                                </div>
                                @if($area->descripcion)
                                    <div class="nav-item-desc">
                                        {{ Str::limit($area->descripcion, 60) }}
                                    </div>
                                @endif
                            </a>
                        @endforeach
                    @else
                        <div style="padding: 32px 20px; text-align: center; color: #718096;">
                            <i class="fas fa-info-circle" style="font-size: 20px; margin-bottom: 6px;"></i>
                                <p style="margin: 0; font-size: 13px;">No hay áreas configuradas</p>
                            </div>
                    @endif
                </nav>
            </aside>

            <!-- Contenido principal -->
            <main class="content-area">
                @if($area_actual)
                    <div class="area-header">
                        <h2 class="area-title">
                            {{ $area_actual->nombre }}
                            <span class="status-badge">
                                {{ $area_actual->activo ? 'Operativo' : 'Inactivo' }}
                            </span>
                        </h2>
                        
                        @if($area_actual->descripcion)
                            <div class="area-description">
                                {!! nl2br(e($area_actual->descripcion)) !!}
                            </div>
                        @endif
                    </div>

                    @if($area_actual->imagen_funcionario || $area_actual->imagen_organigrama)
                        <div class="images-section">
                            @if($area_actual->imagen_funcionario)
                                <div class="image-card">
                                    <h3>
                                        <i class="fas fa-user-tie"></i>
                                        Responsable del Área
                                    </h3>
                                    <img src="{{ url($area_actual->imagen_funcionario) }}" 
                                         alt="Funcionario a cargo"
                                         onerror="this.src='{{ url('img/default/no-image.png') }}'">
                                </div>
                            @endif

                            @if($area_actual->imagen_organigrama)
                                <div class="image-card">
                                    <h3>
                                        <i class="fas fa-sitemap"></i>
                                        Estructura Organizacional
                                    </h3>
                                    <img src="{{ url($area_actual->imagen_organigrama) }}" 
                                         alt="Organigrama" 
                                         style="cursor: pointer;"
                                         onclick="openModal(this.src)"
                                         onerror="this.src='{{ url('img/default/no-image.png') }}'">
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Mostrar enlaces de descarga si existen -->
                    @if($area_actual->link_descarga_1 || $area_actual->link_descarga_2)
                        <div style="padding: 24px; border-top: 1px solid #e2e8f0; background: #f7fafc;">
                            <h3 style="font-size: 16px; font-weight: 600; color: #2d3748; margin-bottom: 16px; display: flex; align-items: center;">
                                <i class="fas fa-download" style="margin-right: 8px; color: #4a5568;"></i>
                                Documentos del Área
                            </h3>
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 12px;">
                                @if($area_actual->link_descarga_1)
                                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 6px; padding: 16px; display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            <h4 style="color: #2d3748; font-weight: 500; margin: 0 0 4px 0; font-size: 14px;">
                                                {{ $area_actual->texto_descarga_1 ?: 'Documento 1' }}
                                            </h4>
                                            <p style="color: #718096; font-size: 12px; margin: 0;">Documento oficial</p>
                                        </div>
                                        <a href="{{ $area_actual->link_descarga_1 }}" 
                                           target="_blank"
                                           style="background: #4a5568; color: white; padding: 6px 12px; border-radius: 4px; font-weight: 500; text-decoration: none; display: flex; align-items: center; font-size: 12px;">
                                            <i class="fas fa-download" style="margin-right: 4px;"></i>
                                            Descargar
                                        </a>
                                    </div>
                                @endif

                                @if($area_actual->link_descarga_2)
                                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 6px; padding: 16px; display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            <h4 style="color: #2d3748; font-weight: 500; margin: 0 0 4px 0; font-size: 14px;">
                                                {{ $area_actual->texto_descarga_2 ?: 'Documento 2' }}
                                            </h4>
                                            <p style="color: #718096; font-size: 12px; margin: 0;">Documento oficial</p>
                                        </div>
                                        <a href="{{ $area_actual->link_descarga_2 }}" 
                                           target="_blank"
                                           style="background: #4a5568; color: white; padding: 6px 12px; border-radius: 4px; font-weight: 500; text-decoration: none; display: flex; align-items: center; font-size: 12px;">
                                            <i class="fas fa-download" style="margin-right: 4px;"></i>
                                            Descargar
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Carousel de eventos del área actual -->
                    @php
                        // Obtener eventos del área actual
                        $eventosArea = $area_actual->eventos ?? collect();
                        $eventosChunks = $eventosArea->chunk(3);
                    @endphp
                    
                    @if($eventosArea->count() > 0)
                        <div class="area-events-carousel">
                            <div class="events-carousel-header">
                                <h3>Eventos y Actividades</h3>
                                <p>Últimas actividades del {{ $area_actual->nombre }}</p>
                            </div>
                            
                            <div class="events-carousel-wrapper">
                                <div class="events-carousel-track" id="eventsCarouselTrack">
                                    @foreach($eventosChunks as $chunkIndex => $chunk)
                                    <div class="events-carousel-slide">
                                        @foreach($chunk as $evento)
                                        <div class="event-card">
                                            <div class="event-icon">
                                                <i class="fas fa-calendar-check"></i>
                                            </div>
                                            <div class="event-area-tag">{{ $area_actual->nombre }}</div>
                                            <h4>{{ $evento->titulo }}</h4>
                                            <p>{{ Str::limit($evento->descripcion, 80) }}</p>
                                            
                                            <div class="event-actions">
                                                @foreach($evento->enlaces as $enlace)
                                                    <a href="{{ $enlace['url'] }}" target="_blank" class="event-btn" title="{{ $enlace['descripcion'] }}">
                                                        <i class="fas fa-link"></i>
                                                        {{ Str::limit($enlace['descripcion'], 15) }}
                                                    </a>
                                                @endforeach
                                                
                                                @if($evento->enlace_externo)
                                                    <a href="{{ $evento->enlace_externo }}" target="_blank" class="event-btn">
                                                        <i class="fas fa-external-link-alt"></i>
                                                        Ver más
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            @if($eventosChunks->count() > 1)
                            <div class="events-carousel-indicators">
                                @foreach($eventosChunks as $index => $chunk)
                                    <div class="events-indicator {{ $index === 0 ? 'active' : '' }}" onclick="goToEventsSlide({{ $index }})"></div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    @endif

                @else
                    <!-- CONTENIDO PRINCIPAL DE LA DIRECCIÓN -->
                    <div style="padding: 32px;">
                        <!-- Descripción de la dirección -->
                        @if($direccion->descripcion)
                        <div style="background: #f7fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
                            <h3 style="font-size: 18px; font-weight: 600; color: #2d3748; margin-bottom: 12px; display: flex; align-items: center;">
                                <i class="fas fa-info-circle" style="margin-right: 8px; color: #4a5568;"></i>
                                Acerca de esta Dirección
                            </h3>
                            <p style="color: #4a5568; line-height: 1.6; margin: 0; font-size: 14px;">
                                {{ $direccion->descripcion }}
                            </p>
                        </div>
                        @endif

                        <!-- Contenido de la página -->
                        @if($direccion->pagina && $direccion->pagina->cont_pagina)
                        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
                            <div style="color: #4a5568; line-height: 1.6; font-size: 14px;">
                                {!! $direccion->pagina->cont_pagina !!}
                            </div>
                        </div>
                        @endif

                        <!-- Áreas disponibles -->
                        @if($direccion->areasMenu && $direccion->areasMenu->count() > 0)
                        <div style="margin-bottom: 32px;">
                            <h3 style="font-size: 20px; font-weight: 600; color: #2d3748; margin-bottom: 16px; display: flex; align-items: center;">
                                <i class="fas fa-sitemap" style="margin-right: 8px; color: #4a5568;"></i>
                                Áreas Organizacionales
                            </h3>
                            <p style="color: #718096; margin-bottom: 20px; font-size: 14px;">
                                Explore las diferentes áreas de nuestra dirección haciendo clic en cualquiera de las siguientes opciones:
                            </p>
                            
                            <!-- Grid de áreas -->
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                                @foreach($direccion->areasMenu as $area)
                                <a href="/menus/paginaweb/{{ $direccion->idpagina }}?area={{ $area->slug }}" 
                                   style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; text-decoration: none; transition: all 0.2s ease; display: block; box-shadow: 0 2px 4px rgba(0,0,0,0.03);"
                                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'; this.style.borderColor='#cbd5e0'"
                                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.03)'; this.style.borderColor='#e2e8f0'">
                                    
                                    <div style="display: flex; align-items: flex-start; margin-bottom: 12px;">
                                        <div style="width: 40px; height: 40px; background: #4a5568; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                                            <i class="fas fa-building" style="color: white; font-size: 16px;"></i>
                                        </div>
                                        <div style="flex: 1;">
                                            <h4 style="font-size: 16px; font-weight: 600; color: #2d3748; margin: 0 0 4px 0; line-height: 1.2;">
                                                {{ $area->nombre }}
                                            </h4>
                                            <span style="background: #edf2f7; color: #4a5568; padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: 500;">
                                                {{ $area->activo ? 'Operativo' : 'Inactivo' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    @if($area->descripcion)
                                    <p style="color: #718096; font-size: 13px; line-height: 1.4; margin: 0 0 12px 0;">
                                        {{ Str::limit($area->descripcion, 100) }}
                                    </p>
                                    @endif
                                    
                                    <!-- Indicadores de contenido -->
                                    <div style="display: flex; gap: 6px; margin-top: 12px; padding-top: 12px; border-top: 1px solid #f1f5f9;">
                                        @if($area->imagen_funcionario)
                                            <span style="background: #dbeafe; color: #1e40af; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 500;">
                                                <i class="fas fa-user" style="margin-right: 2px;"></i>
                                                Funcionario
                                            </span>
                                        @endif
                                        @if($area->imagen_organigrama)
                                            <span style="background: #dcfce7; color: #166534; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 500;">
                                                <i class="fas fa-sitemap" style="margin-right: 2px;"></i>
                                                Organigrama
                                            </span>
                                        @endif
                                        @if($area->eventos && $area->eventos->count() > 0)
                                            <span style="background: #fef3c7; color: #92400e; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 500;">
                                                <i class="fas fa-calendar" style="margin-right: 2px;"></i>
                                                {{ $area->eventos->count() }} Eventos
                                            </span>
                                        @endif
                                        @if($area->link_descarga_1 || $area->link_descarga_2)
                                            <span style="background: #e5e7eb; color: #374151; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 500;">
                                                <i class="fas fa-download" style="margin-right: 2px;"></i>
                                                Documentos
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div style="margin-top: 12px; padding-top: 8px; text-align: right;">
                                        <span style="color: #4a5568; font-size: 12px; font-weight: 500;">
                                            Explorar área →
                                        </span>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div style="text-align: center; padding: 40px 20px; background: #f7fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                            <i class="fas fa-exclamation-circle" style="font-size: 32px; color: #f59e0b; margin-bottom: 12px;"></i>
                            <h4 style="font-size: 16px; font-weight: 600; color: #2d3748; margin-bottom: 6px;">
                                No hay áreas configuradas
                            </h4>
                            <p style="color: #718096; font-size: 13px; margin: 0;">
                                Esta dirección aún no tiene áreas organizacionales definidas.
                            </p>
                        </div>
                        @endif

                        <!-- Carousel de todos los eventos de la dirección -->
                        @php
                            // Obtener todos los eventos de todas las áreas de esta dirección
                            $todosLosEventos = collect();
                            foreach($direccion->areasMenu as $area) {
                                if($area->eventos) {
                                    foreach($area->eventos as $evento) {
                                        $todosLosEventos->push($evento);
                                    }
                                }
                            }
                            $eventosChunks = $todosLosEventos->chunk(3);
                        @endphp
                        
                        @if($todosLosEventos->count() > 0)
                        <div style="background: #f7fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; margin-top: 24px;">
                            <div style="text-align: center; margin-bottom: 24px;">
                                <h3 style="font-size: 18px; font-weight: 600; color: #2d3748; margin: 0 0 4px 0;">
                                    Últimas Actividades
                                </h3>
                                <p style="color: #718096; font-size: 13px; margin: 0;">
                                    Eventos recientes de {{ $direccion->nombre }}
                                </p>
                            </div>
                            
                            <div class="events-carousel-wrapper">
                                <div class="events-carousel-track" id="allEventsCarouselTrack">
                                    @foreach($eventosChunks as $chunkIndex => $chunk)
                                    <div class="events-carousel-slide">
                                        @foreach($chunk as $evento)
                                        <div class="event-card">
                                            <div class="event-icon">
                                                <i class="fas fa-calendar-check"></i>
                                            </div>
                                            <div class="event-area-tag">{{ $evento->area->nombre }}</div>
                                            <h4>{{ $evento->titulo }}</h4>
                                            <p>{{ Str::limit($evento->descripcion, 80) }}</p>
                                            
                                            <div class="event-actions">
                                                @foreach($evento->enlaces as $enlace)
                                                    <a href="{{ $enlace['url'] }}" target="_blank" class="event-btn" title="{{ $enlace['descripcion'] }}">
                                                        <i class="fas fa-link"></i>
                                                        {{ Str::limit($enlace['descripcion'], 15) }}
                                                    </a>
                                                @endforeach
                                                
                                                @if($evento->enlace_externo)
                                                    <a href="{{ $evento->enlace_externo }}" target="_blank" class="event-btn">
                                                        <i class="fas fa-external-link-alt"></i>
                                                        Ver más
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            @if($eventosChunks->count() > 1)
                            <div class="events-carousel-indicators">
                                @foreach($eventosChunks as $index => $chunk)
                                    <div class="events-indicator {{ $index === 0 ? 'active' : '' }}" onclick="goToAllEventsSlide({{ $index }})"></div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>

<!-- Modal para imagen organigrama -->
<div id="imageModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); display: none; z-index: 1000; align-items: center; justify-content: center; padding: 20px;" onclick="closeModal()">
    <div style="position: relative; max-width: 90%; max-height: 90%;" onclick="event.stopPropagation()">
        <button onclick="closeModal()" style="position: absolute; top: -16px; right: -16px; background: white; border: none; border-radius: 50%; width: 32px; height: 32px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; font-size: 14px;">
            <i class="fas fa-times" style="color: #2d3748;"></i>
        </button>
        <img id="modalImage" src="" alt="Organigrama" style="max-width: 100%; max-height: 100%; border-radius: 8px; box-shadow: 0 8px 24px rgba(0,0,0,0.2);">
    </div>
</div>
<script>
// Carousel de eventos functionality
let currentEventsSlide = 0;
let currentAllEventsSlide = 0;

// Para el área específica (solo cuando hay área seleccionada)
@if(isset($area_actual) && $area_actual && $area_actual->eventos->count() > 0)
    @php
        $eventosAreaChunks = $area_actual->eventos->chunk(3);
    @endphp
    const totalEventsSlides = {{ $eventosAreaChunks->count() }};
@else
    const totalEventsSlides = 0;
@endif

// Para todos los eventos de la dirección
@if($todosLosEventos->count() > 0)
    const totalAllEventsSlides = {{ $eventosChunks->count() }};
@else  
    const totalAllEventsSlides = 0;
@endif

const eventsTrack = document.getElementById('eventsCarouselTrack');
const allEventsTrack = document.getElementById('allEventsCarouselTrack');

function updateEventsCarousel() {
    if (eventsTrack && totalEventsSlides > 0) {
        eventsTrack.style.transform = `translateX(-${currentEventsSlide * 100}%)`;
        
        // Actualizar indicadores del carousel del área
        const areaEventsIndicators = document.querySelectorAll('.events-carousel-indicators .events-indicator');
        areaEventsIndicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentEventsSlide);
        });
    }
}

function updateAllEventsCarousel() {
    if (allEventsTrack && totalAllEventsSlides > 0) {
        allEventsTrack.style.transform = `translateX(-${currentAllEventsSlide * 100}%)`;
        
        // Actualizar indicadores del carousel de todos los eventos
        const allEventsIndicators = document.querySelectorAll('.events-carousel-indicators .events-indicator');
        allEventsIndicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentAllEventsSlide);
        });
    }
}

function nextEventsSlide() {
    if (totalEventsSlides > 1) {
        currentEventsSlide = (currentEventsSlide + 1) % totalEventsSlides;
        updateEventsCarousel();
    }
}

function nextAllEventsSlide() {
    if (totalAllEventsSlides > 1) {
        currentAllEventsSlide = (currentAllEventsSlide + 1) % totalAllEventsSlides;
        updateAllEventsCarousel();
    }
}

function goToEventsSlide(slideIndex) {
    currentEventsSlide = slideIndex;
    updateEventsCarousel();
}

function goToAllEventsSlide(slideIndex) {
    currentAllEventsSlide = slideIndex;
    updateAllEventsCarousel();
}

// Auto-advance eventos carousel solo si hay más de un slide
if (totalEventsSlides > 1) {
    setInterval(nextEventsSlide, 5000);
}

// Auto-advance todos los eventos carousel solo si hay más de un slide  
if (totalAllEventsSlides > 1) {
    setInterval(nextAllEventsSlide, 7000);
}

// Modal functionality
function openModal(src) {
    document.getElementById('modalImage').src = src;
    const modal = document.getElementById('imageModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('imageModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Cerrar modal con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>

@endsection