<!-- filepath: resources/views/intranet/siagie/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Reporte SIAGIE desde API
        </h2>
    </x-slot>

    <div class="container-fluid mt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.siagie.reports.index') }}">
                        <i class="fa fa-home"></i> Panel SIAGIE
                    </a>
                </li>
                <li class="breadcrumb-item active">Crear Reporte</li>
            </ol>
        </nav>

        <!-- Instrucciones -->
        <div class="alert alert-info mb-4">
            <h5 class="alert-heading">
                <i class="fa fa-info-circle"></i> ¿Cómo crear un reporte?
            </h5>
            <ol class="mb-0 pl-3">
                <li>Selecciona un reporte de la lista de la izquierda</li>
                <li>Se cargarán automáticamente sus gráficos disponibles</li>
                <li>Elige <strong>1 gráfico global</strong> (principal del reporte)</li>
                <li>Opcionalmente, selecciona <strong>gráficos específicos</strong> adicionales</li>
                <li>Personaliza títulos y descripciones de cada gráfico</li>
                <li>Guarda el reporte para poder publicarlo después</li>
            </ol>
        </div>

        <form method="POST" action="{{ route('admin.siagie.reports.store') }}" id="createReportForm">
            @csrf
            <input type="hidden" name="external_slug" id="external_slug">

            <div class="row">
                <!-- COLUMNA 1: LISTA DE REPORTES API -->
                <div class="col-md-3">
                    <div class="card sticky-top" style="top: 20px;">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fa fa-cloud-download"></i> Reportes API Externa
                            </h6>
                            <small>Haz clic para cargar</small>
                        </div>
                        <div class="card-body p-2" style="max-height: 75vh; overflow-y: auto;">
                            @if(isset($externalReports) && $externalReports instanceof \Illuminate\Support\Collection && $externalReports->count() > 0)
                                <div class="list-group">
                                    @foreach($externalReports as $er)
                                        @if(is_array($er) || is_object($er))
                                            @php
                                                $report = is_object($er) ? (array)$er : $er;
                                            @endphp
                                            <button type="button"
                                                    class="list-group-item list-group-item-action external-report"
                                                    data-slug="{{ $report['slug'] ?? '' }}"
                                                    data-title="{{ $report['title'] ?? 'Sin título' }}"
                                                    data-description="{{ $report['description'] ?? '' }}">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <strong class="mb-1 small">{{ $report['title'] ?? 'Sin título' }}</strong>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <small class="text-muted">
                                                        <i class="fa fa-calendar"></i>
                                                        @if(isset($report['published_at']))
                                                            {{ \Carbon\Carbon::parse($report['published_at'])->format('d/m/Y') }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </small>
                                                    <span class="badge bg-info">{{ $report['charts_count'] ?? 0 }} gráficos</span>
                                                </div>
                                            </button>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fa fa-exclamation-triangle fa-3x text-muted mb-2"></i>
                                    <p class="text-muted small mb-2">No hay reportes disponibles</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- COLUMNA 2: FORMULARIO Y GRÁFICOS -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">
                                <i class="fa fa-file-alt"></i> Información del Reporte Local
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="title">Título del Reporte <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Descripción</label>
                                <textarea name="description" id="description" rows="3" class="form-control"></textarea>
                            </div>
                            <div id="report-info-alert" class="alert alert-warning d-none">
                                <i class="fa fa-check-circle"></i>
                                <span id="selected-report-name"></span>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0"><i class="fa fa-chart-bar"></i> Seleccionar Gráficos</h6>
                        </div>
                        <div class="card-body" id="chartsContainer">
                            <div class="text-center py-5 text-muted">
                                <i class="fa fa-hand-pointer fa-4x mb-3"></i>
                                <p class="h5">Selecciona un reporte externo</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-between">
                        <a href="{{ route('admin.siagie.reports.index') }}" class="btn btn-secondary">
                            <i class="fa fa-times"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                            <i class="fa fa-save"></i> Guardar Reporte
                        </button>
                    </div>
                </div>

                <!-- COLUMNA 3: RESUMEN SELECCIÓN -->
                <div class="col-md-3">
                    <div class="card mb-3 sticky-top" style="top: 20px;">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fa fa-globe"></i> Gráfico Global</h6>
                        </div>
                        <div class="card-body" id="globalSelection">
                            <div class="text-center text-muted py-3">
                                <i class="fa fa-circle-notch"></i><br><small>No seleccionado</small>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fa fa-chart-line"></i> Gráficos Específicos</h6>
                        </div>
                        <div class="card-body" style="max-height: 50vh; overflow-y: auto;" id="specificSelection">
                            <div class="text-center text-muted py-3">
                                <i class="fa fa-list"></i><br><small>Ninguno seleccionado</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .external-report.active {
            background-color: #0d6efd !important;
            color: white !important;
        }
        .external-report.active small,
        .external-report.active strong {
            color: white !important;
        }
        .chart-option-box {
            transition: all 0.2s ease;
            border: 2px solid #dee2e6;
            border-radius: 8px;
        }
        .bg-purple { background-color: #6f42c1 !important; color: white; }
    </style>
    @endpush
@push('scripts')
<script>
(function waitForJQuery() {
    if (typeof jQuery === 'undefined') {
        console.log('⏳ Esperando jQuery...');
        setTimeout(waitForJQuery, 100);
        return;
    }
    
    console.log('✅ jQuery detectado, iniciando script');
    initSiagieCreate();
})();

function initSiagieCreate() {
    let currentReport = null;
    let globalChart = null;
    let specificCharts = [];

    $(document).on('click', '.external-report', function(e) {
        e.preventDefault();
        console.log('👆 Click en reporte');
        
        const slug = $(this).data('slug');
        const title = $(this).data('title');
        
        $('.external-report').removeClass('active');
        $(this).addClass('active');
        
        $('#report-info-alert').removeClass('d-none');
        $('#selected-report-name').text('Reporte: ' + title);
        
        loadReportDetails(slug, title);
    });

    function loadReportDetails(slug, title) {
        console.log('🔄 Cargando:', slug);
        
        const container = $('#chartsContainer');
        container.html('<div class="text-center py-4"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');

        const url = `${window.location.origin}/intranet/siagie/api/reports/${slug}/details`;
        console.log('🔍 URL:', url);

        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('✅ Datos:', data);
                
                if (data.success && data.report) {
                    currentReport = data.report;
                    $('#external_slug').val(currentReport.slug);
                    $('#title').val(currentReport.title || title);
                    $('#description').val(currentReport.description || '');
                    
                    if (currentReport.charts && currentReport.charts.length > 0) {
                        renderCharts(currentReport.charts);
                    } else {
                        container.html('<div class="alert alert-warning">Sin gráficos</div>');
                    }
                    
                    resetSelections();
                }
            },
            error: function(xhr) {
                console.error('❌ Error:', xhr.status, xhr.responseText);
                container.html(`<div class="alert alert-danger">Error ${xhr.status}</div>`);
            }
        });
    }

    function renderCharts(charts) {
        const container = $('#chartsContainer');
        container.empty();

        charts.forEach(chart => {
            // ⭐ Escapar comillas dobles para el HTML
            const chartJson = JSON.stringify(chart).replace(/"/g, '&quot;');
            
            container.append(`
                <div class="chart-option-box p-3 mb-3">
                    <h6>${chart.title}</h6>
                    <div class="mb-2">
                        <span class="badge bg-secondary">ID: ${chart.id}</span>
                        <span class="badge bg-purple">${chart.chart_type || 'N/A'}</span>
                    </div>
                    <div class="bg-light p-2 rounded">
                        <div class="form-check mb-2">
                            <input class="form-check-input global-radio" type="radio" 
                                   name="global_selector" 
                                   id="global_${chart.id}"
                                   data-chart-id="${chart.id}"
                                   data-chart='${chartJson}'>
                            <label class="form-check-label" for="global_${chart.id}">
                                <strong class="text-success">
                                    <i class="fa fa-globe"></i> Marcar como GLOBAL
                                </strong>
                                <br><small class="text-muted">Principal del reporte</small>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input specific-checkbox" type="checkbox" 
                                   id="specific_${chart.id}" 
                                   data-chart-id="${chart.id}"
                                   data-chart='${chartJson}'>
                            <label class="form-check-label" for="specific_${chart.id}">
                                <strong class="text-info">
                                    <i class="fa fa-chart-line"></i> Agregar como ESPECÍFICO
                                </strong>
                                <br><small class="text-muted">Análisis adicional</small>
                            </label>
                        </div>
                    </div>
                </div>
            `);
        });

        // ⭐ CORREGIDO: jQuery ya parsea automáticamente los data-attributes
        $('.global-radio').on('change', function() {
            if (this.checked) {
                const chart = $(this).data('chart'); // ✅ Sin JSON.parse
                const chartId = $(this).data('chart-id');
                
                console.log('🌍 Seleccionado como GLOBAL:', chart);
                
                $(`#specific_${chartId}`).prop('checked', false).prop('disabled', true);
                specificCharts = specificCharts.filter(c => c.id !== chartId);
                
                selectGlobalChart(chart);
            }
        });

        $('.specific-checkbox').on('change', function() {
            const chart = $(this).data('chart'); // ✅ Sin JSON.parse
            const chartId = $(this).data('chart-id');
            
            if (this.checked) {
                console.log('📊 Agregado como ESPECÍFICO:', chart);
                
                if (globalChart && globalChart.id === chartId) {
                    alert('Este gráfico ya está seleccionado como GLOBAL. No puede ser ESPECÍFICO al mismo tiempo.');
                    $(this).prop('checked', false);
                    return;
                }
                
                addSpecificChart(chart);
            } else {
                console.log('❌ Removido como ESPECÍFICO:', chart);
                removeSpecificChart(chartId);
            }
        });
    }

    function selectGlobalChart(chart) {
        globalChart = chart;
        console.log('✅ Gráfico global guardado:', globalChart);
        
        const titleEscaped = (chart.title || '').replace(/"/g, '&quot;');
        
        $('#globalSelection').html(`
            <div class="text-center mb-3">
                <i class="fa fa-check-circle text-success fa-2x"></i>
                <p class="small mt-1 mb-0 fw-bold">${chart.title}</p>
                <small class="text-muted">ID: ${chart.id}</small>
            </div>
            <div class="mb-2">
                <label class="form-label small fw-bold">Título Personalizado</label>
                <input type="text" name="global_chart[title]" value="${titleEscaped}" class="form-control form-control-sm" required>
                <input type="hidden" name="global_chart[id]" value="${chart.id}">
            </div>
            <div>
                <label class="form-label small fw-bold">Descripción</label>
                <textarea name="global_chart[description]" class="form-control form-control-sm" rows="2" placeholder="Opcional"></textarea>
            </div>
        `);
        
        updateSubmitButton();
    }

    function addSpecificChart(chart) {
        if (!specificCharts.find(c => c.id === chart.id)) {
            specificCharts.push(chart);
            console.log('✅ Total gráficos específicos:', specificCharts.length);
            updateSpecificSelection();
            updateSubmitButton();
        }
    }

    function removeSpecificChart(chartId) {
        specificCharts = specificCharts.filter(c => c.id !== chartId);
        console.log('✅ Total gráficos específicos:', specificCharts.length);
        updateSpecificSelection();
        updateSubmitButton();
    }

    function updateSpecificSelection() {
        const container = $('#specificSelection');
        
        if (specificCharts.length === 0) {
            container.html('<div class="text-center py-3 text-muted"><i class="fa fa-list"></i><br><small>Ninguno seleccionado</small></div>');
            return;
        }

        container.empty();
        specificCharts.forEach((chart, i) => {
            const titleEscaped = (chart.title || '').replace(/"/g, '&quot;');
            
            container.append(`
                <div class="border border-info rounded p-2 mb-2 bg-light">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-info">Gráfico #${i+1}</span>
                        <small class="text-muted">ID: ${chart.id}</small>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold mb-1">Título</label>
                        <input type="text" 
                               name="specific_charts[${i}][title]" 
                               value="${titleEscaped}" 
                               class="form-control form-control-sm" 
                               required>
                        <input type="hidden" name="specific_charts[${i}][id]" value="${chart.id}">
                    </div>
                    <div>
                        <label class="form-label small fw-bold mb-1">Descripción</label>
                        <textarea name="specific_charts[${i}][description]" 
                                  class="form-control form-control-sm" 
                                  rows="2" 
                                  placeholder="Opcional"></textarea>
                    </div>
                </div>
            `);
        });
    }

    function resetSelections() {
        globalChart = null;
        specificCharts = [];
        
        $('.specific-checkbox').prop('disabled', false);
        
        $('#globalSelection').html('<div class="text-center text-muted py-3"><i class="fa fa-circle-notch"></i><br><small>No seleccionado</small></div>');
        $('#specificSelection').html('<div class="text-center text-muted py-3"><i class="fa fa-list"></i><br><small>Ninguno seleccionado</small></div>');
        
        updateSubmitButton();
    }

    function updateSubmitButton() {
        const btn = $('#submitBtn');
        const hasExternal = $('#external_slug').val() !== '';
        const hasGlobal = globalChart !== null;
        const hasTitle = $('#title').val().trim() !== '';
        
        const isValid = hasExternal && hasGlobal && hasTitle;
        
        btn.prop('disabled', !isValid);
        
        console.log('🔘 Estado del botón:', {
            hasExternal,
            hasGlobal,
            hasTitle,
            isValid
        });
        
        if (isValid) {
            btn.removeClass('btn-secondary').addClass('btn-primary');
        } else {
            btn.removeClass('btn-primary').addClass('btn-secondary');
        }
    }

    $('#title').on('input', function() {
        console.log('📝 Título cambiado:', $(this).val());
        updateSubmitButton();
    });
    
    console.log('✅ Script inicializado correctamente');
}
</script>
@endpush
</x-app-layout>