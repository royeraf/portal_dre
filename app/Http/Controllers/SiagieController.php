<?php

namespace App\Http\Controllers;

use App\Models\SiagieEnlace;
use App\Models\SiagieReport;
use App\Models\SiagieChart;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SiagieController extends Controller
{
    private $apiBase = 'http://datos.drehuanuco.gob.pe/public/api/public';

    // ============================================
    // VISTA PÚBLICA
    // ============================================

    /**
     * Página principal SIAGIE - Muestra solo reportes publicados
     */
    public function index()
    {
        $data['menus'] = Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus'] = Menu::whereNotNull('categoriamenu')->get();
        $data['enlaces'] = SiagieEnlace::where('activo', 1)->orderBy('orden')->get();
        
        // Obtener solo reportes publicados (is_available = true)
        $data['reports'] = SiagieReport::where('is_available', true)
            ->whereHas('charts')
            ->with(['charts' => function($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->orderBy('published_at', 'desc')
            ->get();
        
        return view('paginas.siagie', $data);
    }

    /**
     * Ver reporte individual público
     */
    public function showReport($slug)
    {
        $data['menus'] = Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus'] = Menu::whereNotNull('categoriamenu')->get();
        
        $data['report'] = SiagieReport::where('slug', $slug)
            ->where('is_available', true)
            ->with(['charts' => function($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->firstOrFail();
        
        return view('paginas.siagie-report', $data);
    }

    // ============================================
    // PANEL ADMINISTRADOR
    // ============================================

    /**
     * Listado de reportes guardados en BD
     */
    public function reportsIndex()
    {
        $reports = SiagieReport::withCount('charts')
            ->with('charts')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('intranet.siagie.index', compact('reports'));
    }

    /**
     * Formulario para crear nuevo reporte desde API
     */
        public function create()
        {
            try {
                // URL de la API pública
                $apiUrl = 'http://datos.drehuanuco.gob.pe/public/api/public';
                
                // Obtener lista de reportes
                $response = Http::timeout(30)->get("{$apiUrl}/reports");

                $externalReports = collect([]);
                
                if ($response->successful()) {
                    $data = $response->json();
                    
                    // ⭐ La API devuelve { "success": true, "reports": [...] }
                    if (isset($data['success']) && $data['success'] && isset($data['reports'])) {
                        $externalReports = collect($data['reports']);
                    }
                    
                    \Log::info('Reportes externos obtenidos: ' . $externalReports->count());
                } else {
                    \Log::error('Error al obtener reportes externos', [
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                }

                return view('intranet.siagie.create', compact('externalReports'));

            } catch (\Exception $e) {
                \Log::error('Error en create: ' . $e->getMessage());
                return view('intranet.siagie.create', ['externalReports' => collect([])]);
            }
        }

    /**
     * Obtener detalles de un reporte desde API (AJAX)
     */
    public function getReportDetails($slug)
    {
        // DEBUG: Verificar que llega aquí
        \Log::info('🔍 getReportDetails llamado', ['slug' => $slug]);
        
        try {
            $apiUrl = 'http://datos.drehuanuco.gob.pe/public/api/public';
            $fullUrl = "{$apiUrl}/reports/{$slug}";
            
            \Log::info('📡 Llamando a API', ['url' => $fullUrl]);
            
            $response = Http::timeout(30)->get($fullUrl);
            
            \Log::info('📥 Respuesta recibida', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success'] && isset($data['report'])) {
                    \Log::info('✅ Datos procesados correctamente');
                    
                    return response()->json([
                        'success' => true,
                        'report' => $data['report']
                    ]);
                }
                
                \Log::error('❌ Estructura de respuesta inesperada', ['data' => $data]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Estructura de respuesta inesperada'
                ], 500);
            }

            \Log::error('❌ Error en la respuesta HTTP', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'No se pudo obtener el reporte'
            ], $response->status());

        } catch (\Exception $e) {
            \Log::error('💥 Excepción en getReportDetails', [
                'slug' => $slug,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error de conexión: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Guardar reporte y gráficos seleccionados
     */
    public function storeReport(Request $request)
    {
        $request->validate([
            'external_slug' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'global_chart' => 'required|array',
            'global_chart.id' => 'required|integer',
            'global_chart.title' => 'nullable|string',
            'global_chart.description' => 'nullable|string',
            'specific_charts' => 'nullable|array',
            'specific_charts.*.id' => 'required|integer',
            'specific_charts.*.title' => 'nullable|string',
            'specific_charts.*.description' => 'nullable|string',
        ]);

        $slug = $request->external_slug;

        // Obtener datos completos del reporte desde API
        try {
            $resp = Http::timeout(15)->get("{$this->apiBase}/reports/{$slug}");
            if (!$resp->ok()) {
                return back()->with('error', 'No se pudo obtener el reporte desde la API');
            }
            $json = $resp->json();
            if (empty($json) || !($json['success'] ?? false) || !isset($json['report'])) {
                return back()->with('error', 'Respuesta inválida de la API');
            }
            $apiReport = $json['report'];
        } catch (\Exception $e) {
            Log::error('SIAGIE storeReport fetch error: '.$e->getMessage());
            return back()->with('error', 'Error al conectar con la API');
        }

        // Crear o actualizar reporte en BD
        $report = SiagieReport::updateOrCreate(
            ['slug' => $apiReport['slug']],
            [
                'external_id' => $apiReport['id'] ?? null,
                'title' => $request->title,
                'description' => $request->description,
                'category' => $apiReport['category'] ?? null,
                'published_at' => $apiReport['published_at'] ?? now(),
                'charts_count' => count($apiReport['charts'] ?? []),
                'api_url' => "{$this->apiBase}/reports/{$apiReport['slug']}",
                'is_available' => false, // Por defecto no publicado
                'last_synced_at' => now()
            ]
        );

        // Eliminar gráficos anteriores y recrear
        SiagieChart::where('report_slug', $report->slug)->delete();

        // Crear mapeo de charts de la API
        $chartsMap = [];
        foreach ($apiReport['charts'] ?? [] as $c) {
            $chartsMap[$c['id']] = $c;
        }

        $saved = 0;

        // Guardar gráfico GLOBAL
        $globalId = (int)$request->global_chart['id'];
        if (isset($chartsMap[$globalId])) {
            SiagieChart::create([
                'report_slug' => $report->slug,
                'external_chart_id' => $globalId,
                'chart_title' => $request->global_chart['title'] ?? $chartsMap[$globalId]['title'],
                'chart_data' => $chartsMap[$globalId]['chart_data'] ?? null,
                'chart_config' => $chartsMap[$globalId]['chart_config'] ?? null,
                'order' => 0, // Global siempre primero
                'is_active' => true,
                'custom_notes' => $request->global_chart['description'] ?? null,
                'is_global' => true
            ]);
            $saved++;
        }

        // Guardar gráficos ESPECÍFICOS
        if (!empty($request->specific_charts)) {
            foreach ($request->specific_charts as $index => $specificChart) {
                $chartId = (int)$specificChart['id'];
                if ($chartId === $globalId) continue; // No duplicar el global
                
                if (isset($chartsMap[$chartId])) {
                    SiagieChart::create([
                        'report_slug' => $report->slug,
                        'external_chart_id' => $chartId,
                        'chart_title' => $specificChart['title'] ?? $chartsMap[$chartId]['title'],
                        'chart_data' => $chartsMap[$chartId]['chart_data'] ?? null,
                        'chart_config' => $chartsMap[$chartId]['chart_config'] ?? null,
                        'order' => $index + 1,
                        'is_active' => true,
                        'custom_notes' => $specificChart['description'] ?? null,
                        'is_global' => false
                    ]);
                    $saved++;
                }
            }
        }

        return redirect()->route('admin.siagie.reports.index')
            ->with('success', "Reporte '{$report->title}' guardado con {$saved} gráficos.");
    }

    /**
     * Editar reporte existente
     */
    public function editReport(SiagieReport $report)
    {
        // Obtener datos actualizados desde API
        $apiReport = null;
        try {
            $resp = Http::timeout(15)->get("{$this->apiBase}/reports/{$report->slug}");
            if ($resp->ok()) {
                $json = $resp->json();
                if (!empty($json) && ($json['success'] ?? false) && isset($json['report'])) {
                    $apiReport = $json['report'];
                }
            }
        } catch (\Exception $e) {
            Log::error("SIAGIE editReport fetch error: {$e->getMessage()}");
        }

        $savedCharts = $report->charts()->orderBy('order')->get();

        return view('intranet.siagie.edit_report', compact('report', 'apiReport', 'savedCharts'));
    }

    /**
     * Actualizar reporte
     */
    public function updateReport(Request $request, SiagieReport $report)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'global_chart' => 'required|array',
            'global_chart.id' => 'required|integer',
            'global_chart.title' => 'nullable|string',
            'global_chart.description' => 'nullable|string',
            'specific_charts' => 'nullable|array',
        ]);

        // Obtener datos actualizados de la API
        try {
            $resp = Http::timeout(15)->get("{$this->apiBase}/reports/{$report->slug}");
            if (!$resp->ok()) return back()->with('error', 'No se pudo obtener datos actualizados desde la API');
            $json = $resp->json();
            if (empty($json) || !($json['success'] ?? false) || !isset($json['report'])) {
                return back()->with('error', 'Respuesta inválida de la API');
            }
            $apiReport = $json['report'];
        } catch (\Exception $e) {
            Log::error('SIAGIE updateReport fetch error: '.$e->getMessage());
            return back()->with('error', 'Error al conectar con la API');
        }

        // Actualizar datos del reporte
        $report->update([
            'title' => $request->title,
            'description' => $request->description,
            'charts_count' => count($apiReport['charts'] ?? []),
            'last_synced_at' => now()
        ]);

        // Recrear gráficos
        SiagieChart::where('report_slug', $report->slug)->delete();
        
        $chartsMap = [];
        foreach ($apiReport['charts'] ?? [] as $c) $chartsMap[$c['id']] = $c;

        $saved = 0;

        // Guardar global
        $globalId = (int)$request->global_chart['id'];
        if (isset($chartsMap[$globalId])) {
            SiagieChart::create([
                'report_slug' => $report->slug,
                'external_chart_id' => $globalId,
                'chart_title' => $request->global_chart['title'] ?? $chartsMap[$globalId]['title'],
                'chart_data' => $chartsMap[$globalId]['chart_data'] ?? null,
                'chart_config' => $chartsMap[$globalId]['chart_config'] ?? null,
                'order' => 0,
                'is_active' => true,
                'custom_notes' => $request->global_chart['description'] ?? null,
                'is_global' => true
            ]);
            $saved++;
        }

        // Guardar específicos
        if (!empty($request->specific_charts)) {
            foreach ($request->specific_charts as $index => $specificChart) {
                $chartId = (int)$specificChart['id'];
                if ($chartId === $globalId) continue;
                
                if (isset($chartsMap[$chartId])) {
                    SiagieChart::create([
                        'report_slug' => $report->slug,
                        'external_chart_id' => $chartId,
                        'chart_title' => $specificChart['title'] ?? $chartsMap[$chartId]['title'],
                        'chart_data' => $chartsMap[$chartId]['chart_data'] ?? null,
                        'chart_config' => $chartsMap[$chartId]['chart_config'] ?? null,
                        'order' => $index + 1,
                        'is_active' => true,
                        'custom_notes' => $specificChart['description'] ?? null,
                        'is_global' => false
                    ]);
                    $saved++;
                }
            }
        }

        return redirect()->route('admin.siagie.reports.index')
            ->with('success', "Reporte actualizado con {$saved} gráficos.");
    }

    /**
     * Publicar/Despublicar reporte
     */
    public function togglePublish(SiagieReport $report)
    {
        $report->is_available = !$report->is_available;
        $report->save();

        $msg = $report->is_available ? 'Reporte publicado correctamente' : 'Reporte despublicado';
        return back()->with('success', $msg);
    }

    /**
     * Eliminar reporte
     */
    public function destroyReport(SiagieReport $report)
    {
        $report->charts()->delete();
        $report->delete();

        return redirect()->route('admin.siagie.reports.index')
            ->with('success', 'Reporte eliminado correctamente');
    }
}