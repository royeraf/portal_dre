@extends('principal.plantilla')

@section('content')
<!-- Header con gradiente y color personalizado -->
<div class="report-header py-5" style="background: linear-gradient(135deg, #4f8cff 0%, #43e97b 100%);">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('siagie.index') }}" class="text-white text-decoration-none">
                        <i class="fas fa-arrow-left me-2"></i>Reportes SIAGIE
                    </a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $report->title }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold text-white mb-3">{{ $report->title }}</h1>
                @if($report->description)
                    <p class="lead text-white-50 mb-0">{{ $report->description }}</p>
                @endif
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="text-white mt-3 mt-lg-0">
                    <div class="mb-2">
                        <i class="far fa-calendar-alt me-2"></i>
                        <span class="fw-bold">
                            {{ $report->published_at ? $report->published_at->format('d/m/Y') : $report->created_at->format('d/m/Y') }}
                        </span>
                    </div>
                    <span class="badge bg-white text-success px-3 py-2">
                        <i class="fas fa-chart-bar me-1"></i>
                        {{ $report->charts->count() }} {{ Str::plural('gráfico', $report->charts->count()) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-n5 mb-5">
    @php
        $globalChart = $report->charts->where('is_global', true)->first();
        $specificCharts = $report->charts->where('is_global', false)->sortBy('order');
    @endphp

    <!-- GRÁFICO GLOBAL -->
    @if($globalChart)
        <div class="mb-5">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="card-header text-white py-4" 
                     style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            @if($globalChart->chart_config['chart_type'] === 'table')
                                <i class="fas fa-table fa-3x"></i>
                            @else
                                <i class="fas fa-globe fa-3x"></i>
                            @endif
                        </div>
                        <div class="col">
                            <h3 class="mb-1 fw-bold">{{ $globalChart->chart_title }}</h3>
                            @if($globalChart->custom_notes)
                                <p class="mb-0 opacity-90">{{ $globalChart->custom_notes }}</p>
                            @endif
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-white text-success px-3 py-2">
                                {{ strtoupper($globalChart->chart_config['chart_type'] ?? 'N/A') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 bg-light">
                    <!-- Contenedor único para tabla o gráfico -->
                    <div id="global-chart-{{ $globalChart->id }}"></div>
                </div>
            </div>
        </div>
    @endif

    <!-- GRÁFICOS ESPECÍFICOS -->
    @if($specificCharts->count() > 0)
        <div class="mb-4">
            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                <div class="bg-gradient-primary rounded-circle p-3 me-3" style="background: linear-gradient(135deg, #4f8cff 0%, #43e97b 100%);">
                    <i class="fas fa-chart-line text-white fa-lg"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold">Reportes Específicos</h2>
                    <p class="text-muted mb-0">Análisis detallado por categorías</p>
                </div>
            </div>

            <div class="row g-4">
                @foreach($specificCharts as $index => $chart)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm hover-lift">
                            <div class="card-header bg-gradient-secondary border-0 py-3" style="background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%); color: #fff;">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="badge bg-white text-secondary rounded-circle p-3" style="font-size: 1.1rem;">
                                            {{ $index + 1 }}
                                        </span>
                                    </div>
                                    <div class="col">
                                        <h5 class="mb-1 fw-bold">{{ $chart->chart_title }}</h5>
                                        @if($chart->custom_notes)
                                            <p class="mb-0 text-white-50 small">
                                                <i class="fas fa-info-circle me-1"></i>
                                                {{ $chart->custom_notes }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-auto">
                                        <span class="badge bg-white text-secondary px-3 py-2">
                                            {{ strtoupper($chart->chart_config['chart_type'] ?? 'N/A') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-4 bg-light">
                                <!-- Contenedor único para tabla o gráfico -->
                                <div id="chart-{{ $chart->id }}"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Botón Volver -->
    <div class="text-center mt-5 pt-4">
        <a href="{{ route('siagie.index') }}" class="btn btn-lg btn-gradient-primary px-5 py-3 shadow-sm" style="background: linear-gradient(135deg, #4f8cff 0%, #43e97b 100%); color: #fff;">
            <i class="fas fa-arrow-left me-2"></i>Volver a Reportes
        </a>
    </div>
</div>

@push('styles')
<style>
    .hover-lift {
        transition: all 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.15) !important;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.5);
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4f8cff 0%, #43e97b 100%);
    }
    .bg-gradient-secondary {
        background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);
    }
    /* Estilos para tablas */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th {
        background-color: #e3f2fd;
        color: #1a237e;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 12px;
        border: 1px solid #bdbdbd;
    }
    .data-table td {
        padding: 10px 12px;
        border: 1px solid #bdbdbd;
        background-color: #fff;
    }
    .data-table tbody tr:hover {
        background-color: #e8f5e9;
    }
    .data-table tfoot {
        background-color: #c8e6c9;
        font-weight: 600;
    }
    .badge.bg-white.text-success,
    .badge.bg-white.text-secondary {
        border: 1px solid #bdbdbd;
    }
    .card-body.bg-light {
        background-color: #f8f9fa !important;
    }
    .btn-gradient-primary {
        background: linear-gradient(135deg, #4f8cff 0%, #43e97b 100%);
        color: #fff;
        border: none;
    }
    .btn-gradient-primary:hover {
        background: linear-gradient(135deg, #43e97b 0%, #4f8cff 100%);
        color: #fff;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const reportData = @json($report);

    if (!reportData.charts || reportData.charts.length === 0) return;

    reportData.charts.forEach((chart) => {
        const containerId = chart.is_global ? `global-chart-${chart.id}` : `chart-${chart.id}`;
        const container = document.getElementById(containerId);

        if (!container) return;

        if (chart.chart_config.chart_type === 'table') {
            renderTable(containerId, chart.chart_data, chart.chart_config);
        } else {
            renderChart(containerId, chart.chart_data, chart.chart_config);
        }
    });
});

function renderTable(containerId, chartData, config) {
    const container = document.getElementById(containerId);
    if (!container) return;

    let tableHTML = `
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped data-table">
                <thead>
                    <tr>
                        <th class="text-start">${config.x_label || 'Categoría'}</th>
    `;

    chartData.series.forEach(series => {
        tableHTML += `<th class="text-end">${series.name}</th>`;
    });

    tableHTML += `
                    </tr>
                </thead>
                <tbody>
    `;

    chartData.categories.forEach((category, index) => {
        tableHTML += `<tr><td class="fw-semibold text-start">${category}</td>`;
        chartData.series.forEach(series => {
            const value = series.data[index] || 0;
            tableHTML += `<td class="text-end">${Math.round(value).toLocaleString('es-PE')}</td>`;
        });
        tableHTML += `</tr>`;
    });

    tableHTML += `</tbody>`;

    if (chartData.series.length > 1) {
        tableHTML += `<tfoot><tr><td class="fw-bold text-start">TOTAL</td>`;
        chartData.series.forEach(series => {
            const total = series.data.reduce((sum, val) => sum + val, 0);
            tableHTML += `<td class="fw-bold text-end">${Math.round(total).toLocaleString('es-PE')}</td>`;
        });
        tableHTML += `</tr></tfoot>`;
    }

    tableHTML += `</table></div>`;
    container.innerHTML = tableHTML;
}

function renderChart(containerId, chartData, config) {
    const container = document.getElementById(containerId);
    if (!container) return;

    container.innerHTML = `<canvas id="${containerId}_canvas" height="100"></canvas>`;
    const canvas = document.getElementById(`${containerId}_canvas`);
    const ctx = canvas.getContext('2d');
    const chartType = config.chart_type || 'column';

    let chartJsType = 'bar';
    let indexAxis = 'x';

    switch(chartType) {
        case 'column': chartJsType = 'bar'; indexAxis = 'x'; break;
        case 'bar': chartJsType = 'bar'; indexAxis = 'y'; break;
        case 'line': chartJsType = 'line'; break;
        case 'pie': case 'donut': chartJsType = 'pie'; break;
    }

    const colorPalette = [
        '#4f8cff', '#43e97b', '#f093fb', '#f5576c', '#fee140', '#30cfd0', '#764ba2', '#fa709a'
    ];

    const datasets = chartData.series.map((series, i) => {
        const color = series.color || colorPalette[i % colorPalette.length];
        return {
            label: series.name,
            data: series.data,
            backgroundColor: chartJsType === 'bar' ? hexToRgba(color, 0.8) : color,
            borderColor: color,
            borderWidth: chartJsType === 'line' ? 3 : 1
        };
    });

    const chartConfig = {
        type: chartJsType,
        data: {
            labels: chartData.categories || [],
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            indexAxis: indexAxis,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: { padding: 15, font: { size: 12 } }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            label += new Intl.NumberFormat('es-PE').format(
                                context.parsed.y || context.parsed.x || context.parsed
                            );
                            return label;
                        }
                    }
                }
            }
        }
    };

    if (chartJsType !== 'pie') {
        chartConfig.options.scales = {
            y: {
                beginAtZero: true,
                title: {
                    display: !!config.y_label,
                    text: config.y_label || config.y_axis || '',
                    font: { size: 14, weight: 'bold' }
                },
                ticks: {
                    callback: value => new Intl.NumberFormat('es-PE').format(value)
                }
            },
            x: {
                title: {
                    display: !!config.x_label,
                    text: config.x_label || config.x_axis || '',
                    font: { size: 14, weight: 'bold' }
                },
                ticks: {
                    maxRotation: 45,
                    minRotation: 0
                }
            }
        };
    }

    try {
        new Chart(ctx, chartConfig);
    } catch (error) {
        container.innerHTML = `<div class="alert alert-danger"><strong>Error:</strong> ${error.message}</div>`;
    }
}

function hexToRgba(hex, alpha) {
    if (!hex) return `rgba(79, 140, 255, ${alpha})`;
    const r = parseInt(hex.slice(1, 3), 16);
    const g = parseInt(hex.slice(3, 5), 16);
    const b = parseInt(hex.slice(5, 7), 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}
</script>
@endpush
@endsection