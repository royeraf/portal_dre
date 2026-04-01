<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Reporte: {{ $report->title }}
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
                <li class="breadcrumb-item active">Editar Reporte</li>
            </ol>
        </nav>

        <form method="POST" action="{{ route('admin.siagie.reports.update', $report) }}" id="editReportForm">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- ============================================ -->
                <!-- COLUMNA 1: INFORMACIÓN DEL REPORTE -->
                <!-- ============================================ -->
                <div class="col-md-3">
                    <div class="card mb-3 sticky-top" style="top: 20px;">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">
                                <i class="fa fa-info-circle"></i> Información
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong class="d-block small">Slug:</strong>
                                <span class="text-muted small">{{ $report->slug }}</span>
                            </div>
                            <div class="mb-3">
                                <strong class="d-block small">Creado:</strong>
                                <span class="text-muted small">{{ $report->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="mb-3">
                                <strong class="d-block small">Última sync:</strong>
                                <span class="text-muted small">{{ $report->last_synced_at ? $report->last_synced_at->format('d/m/Y H:i') : 'N/A' }}</span>
                            </div>
                            <div class="mb-3">
                                <strong class="d-block small">Estado:</strong>
                                @if($report->is_available)
                                    <span class="badge bg-success">Publicado</span>
                                @else
                                    <span class="badge bg-secondary">No Publicado</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($apiReport)
                        <div class="alert alert-info small">
                            <strong>Datos desde API</strong>
                            <p class="mb-0">{{ count($apiReport['charts'] ?? []) }} gráficos disponibles</p>
                        </div>
                    @else
                        <div class="alert alert-danger small">
                            <strong>Advertencia</strong>
                            <p class="mb-0">No se pudo conectar con la API</p>
                        </div>
                    @endif
                </div>

                <!-- ============================================ -->
                <!-- COLUMNA 2: FORMULARIO Y GRÁFICOS -->
                <!-- ============================================ -->
                <div class="col-md-6">
                    <!-- Información del Reporte -->
                    <div class="card mb-3">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">
                                <i class="fa fa-file-alt"></i> Información del Reporte
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Título del Reporte <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="title" 
                                       id="title" 
                                       class="form-control" 
                                       required
                                       value="{{ old('title', $report->title) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea name="description" 
                                          id="description" 
                                          rows="3"
                                          class="form-control">{{ old('description', $report->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Gráficos Disponibles -->
                    @if($apiReport && isset($apiReport['charts']))
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0">
                                    <i class="fa fa-chart-bar"></i> Seleccionar Gráficos
                                </h6>
                            </div>
                            <div class="card-body" id="chartsContainer">
                                @foreach($apiReport['charts'] as $chart)
                                    @php
                                        $savedChart = $savedCharts->firstWhere('external_chart_id', $chart['id']);
                                        $isGlobal = $savedChart && $savedChart->is_global;
                                        $isSpecific = $savedChart && !$savedChart->is_global;
                                    @endphp
                                    <div class="border rounded p-3 mb-3 chart-option-box">
                                        <h6 class="mb-1">{{ $chart['title'] }}</h6>
                                        <div class="mb-2">
                                            <span class="badge bg-secondary">ID: {{ $chart['id'] }}</span>
                                            <span class="badge bg-purple ms-1">{{ $chart['chart_type'] }}</span>
                                        </div>
                                        
                                        <div class="bg-light p-2 rounded">
                                            <div class="form-check p-2 bg-white rounded mb-2 border border-success">
                                                <input class="form-check-input global-radio" 
                                                       type="radio" 
                                                       name="global_selector" 
                                                       id="global_{{ $chart['id'] }}"
                                                       value="{{ $chart['id'] }}" 
                                                       data-chart='@json($chart)'
                                                       {{ $isGlobal ? 'checked' : '' }}>
                                                <label class="form-check-label w-100" for="global_{{ $chart['id'] }}">
                                                    <strong class="text-success">
                                                        <i class="fa fa-globe"></i> Marcar como Global
                                                    </strong>
                                                </label>
                                            </div>

                                            <div class="form-check p-2 bg-white rounded border border-info">
                                                <input class="form-check-input specific-checkbox" 
                                                       type="checkbox" 
                                                       id="specific_{{ $chart['id'] }}"
                                                       data-chart-id="{{ $chart['id'] }}" 
                                                       data-chart='@json($chart)'
                                                       {{ $isSpecific ? 'checked' : '' }}>
                                                <label class="form-check-label w-100" for="specific_{{ $chart['id'] }}">
                                                    <strong class="text-info">
                                                        <i class="fa fa-chart-line"></i> Agregar a Específicos
                                                    </strong>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-body">
                                <p class="text-muted text-center py-4">No se pudieron cargar los gráficos desde la API</p>
                            </div>
                        </div>
                    @endif

                    <div class="mt-3 d-flex justify-content-between">
                        <a href="{{ route('admin.siagie.reports.index') }}" 
                           class="btn btn-secondary">
                            <i class="fa fa-times"></i> Cancelar
                        </a>
                        <button type="submit" 
                                class="btn btn-primary" 
                                id="submitBtn">
                            <i class="fa fa-save"></i> Actualizar Reporte
                        </button>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- COLUMNA 3: RESUMEN SELECCIÓN -->
                <!-- ============================================ -->
                <div class="col-md-3">
                    <!-- Gráfico Global -->
                    <div class="card mb-3 sticky-top" style="top: 20px;">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">
                                <i class="fa fa-globe"></i> Gráfico Global
                            </h6>
                            <small>Principal del reporte</small>
                        </div>
                        <div class="card-body" id="globalSelection">
                            @php
                                $globalChart = $savedCharts->firstWhere('is_global', true);
                            @endphp
                            @if($globalChart)
                                <div class="bg-success bg-opacity-10 p-2 rounded text-center mb-3">
                                    <i class="fa fa-check-circle text-success fa-2x"></i>
                                    <p class="small text-success mb-0 mt-1">ID: {{ $globalChart->external_chart_id }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">
                                        Título Personalizado <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           name="global_chart[title]" 
                                           value="{{ $globalChart->chart_title }}"
                                           class="form-control form-control-sm">
                                    <input type="hidden" name="global_chart[id]" value="{{ $globalChart->external_chart_id }}">
                                </div>
                                <div>
                                    <label class="form-label small fw-bold">Descripción</label>
                                    <textarea name="global_chart[description]" 
                                              rows="3"
                                              class="form-control form-control-sm">{{ $globalChart->custom_notes }}</textarea>
                                </div>
                            @else
                                <div class="text-center text-muted py-3">
                                    <i class="fa fa-circle-notch"></i><br>
                                    <small>No seleccionado</small>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Gráficos Específicos -->
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fa fa-chart-line"></i> Gráficos Específicos
                            </h6>
                            <small>Análisis detallado</small>
                        </div>
                        <div class="card-body" style="max-height: 50vh; overflow-y: auto;" id="specificSelection">
                            @php
                                $specificCharts = $savedCharts->where('is_global', false);
                            @endphp
                            @if($specificCharts->count() > 0)
                                @foreach($specificCharts as $index => $chart)
                                    <div class="border border-info rounded p-2 mb-2 bg-light">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-info">Gráfico #{{ $index + 1 }}</span>
                                        </div>
                                        <div class="small text-info mb-2">ID: {{ $chart->external_chart_id }}</div>
                                        <input type="text" 
                                               name="specific_charts[{{ $index }}][title]" 
                                               value="{{ $chart->chart_title }}"
                                               class="form-control form-control-sm mb-2">
                                        <input type="hidden" name="specific_charts[{{ $index }}][id]" value="{{ $chart->external_chart_id }}">
                                        <textarea name="specific_charts[{{ $index }}][description]" 
                                                  rows="2"
                                                  class="form-control form-control-sm">{{ $chart->custom_notes }}</textarea>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center text-muted py-3">
                                    <i class="fa fa-list"></i><br>
                                    <small>Ninguno seleccionado</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .chart-option-box {
            transition: all 0.2s ease;
        }
        .chart-option-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .sticky-top {
            position: sticky;
            z-index: 100;
        }
        .bg-purple {
            background-color: #6f42c1 !important;
            color: white;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let globalChart = null;
        let specificCharts = [];

        // Inicializar con valores actuales
        initializeFromSaved();

        function initializeFromSaved() {
            const globalRadio = document.querySelector('.global-radio:checked');
            if (globalRadio) {
                globalChart = JSON.parse(globalRadio.dataset.chart);
            }

            document.querySelectorAll('.specific-checkbox:checked').forEach(checkbox => {
                const chart = JSON.parse(checkbox.dataset.chart);
                specificCharts.push(chart);
            });
        }

        // Event listeners para radio buttons (global)
        document.querySelectorAll('.global-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    const chartData = JSON.parse(this.dataset.chart);
                    selectGlobalChart(chartData);
                }
            });
        });

        // Event listeners para checkboxes (específicos)
        document.querySelectorAll('.specific-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const chartData = JSON.parse(this.dataset.chart);
                if (this.checked) {
                    addSpecificChart(chartData);
                } else {
                    removeSpecificChart(chartData.id);
                }
            });
        });

        function selectGlobalChart(chart) {
            globalChart = chart;
            updateGlobalSelection();
        }

        function addSpecificChart(chart) {
            if (!specificCharts.find(c => c.id === chart.id)) {
                specificCharts.push(chart);
                updateSpecificSelection();
            }
        }

        function removeSpecificChart(chartId) {
            specificCharts = specificCharts.filter(c => c.id !== chartId);
            updateSpecificSelection();
        }

        function updateGlobalSelection() {
            const container = document.getElementById('globalSelection');
            if (!globalChart) {
                container.innerHTML = '<div class="text-center text-muted py-3"><i class="fa fa-circle-notch"></i><br><small>No seleccionado</small></div>';
                return;
            }

            const currentTitle = container.querySelector('input[name="global_chart[title]"]')?.value || globalChart.title;
            const currentDesc = container.querySelector('textarea[name="global_chart[description]"]')?.value || '';

            container.innerHTML = `
                <div>
                    <div class="bg-success bg-opacity-10 p-2 rounded text-center mb-3">
                        <i class="fa fa-check-circle text-success fa-2x"></i>
                        <p class="small text-success mb-0 mt-1">ID: ${globalChart.id}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">
                            Título Personalizado <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="global_chart[title]" 
                               value="${currentTitle}"
                               class="form-control form-control-sm">
                        <input type="hidden" name="global_chart[id]" value="${globalChart.id}">
                    </div>
                    <div>
                        <label class="form-label small fw-bold">Descripción</label>
                        <textarea name="global_chart[description]" 
                                  rows="3"
                                  class="form-control form-control-sm">${currentDesc}</textarea>
                    </div>
                </div>
            `;
        }

        function updateSpecificSelection() {
            const container = document.getElementById('specificSelection');
            if (specificCharts.length === 0) {
                container.innerHTML = '<div class="text-center text-muted py-3"><i class="fa fa-list"></i><br><small>Ninguno seleccionado</small></div>';
                return;
            }

            container.innerHTML = '';
            specificCharts.forEach((chart, index) => {
                const div = document.createElement('div');
                div.className = 'border border-info rounded p-2 mb-2 bg-light';
                div.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-info">Gráfico #${index + 1}</span>
                        <button type="button" 
                                class="btn btn-sm btn-danger remove-specific" 
                                data-chart-id="${chart.id}">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="small text-info mb-2">ID: ${chart.id}</div>
                    <input type="text" 
                           name="specific_charts[${index}][title]" 
                           value="${chart.title}"
                           class="form-control form-control-sm mb-2">
                    <input type="hidden" name="specific_charts[${index}][id]" value="${chart.id}">
                    <textarea name="specific_charts[${index}][description]" 
                              rows="2"
                              class="form-control form-control-sm"></textarea>
                `;
                container.appendChild(div);
            });

            document.querySelectorAll('.remove-specific').forEach(btn => {
                btn.addEventListener('click', function() {
                    const chartId = parseInt(this.dataset.chartId);
                    removeSpecificChart(chartId);
                    const checkbox = document.querySelector(`.specific-checkbox[data-chart-id="${chartId}"]`);
                    if (checkbox) checkbox.checked = false;
                });
            });
        }
    });
    </script>
    @endpush
</x-app-layout>