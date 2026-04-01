<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SiagieApiService
{
    private string $baseUrl;
    private int $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.siagie.url'), '/');
        $this->timeout = (int) config('services.siagie.timeout', 30);
    }

    private function client()
    {
        return Http::timeout($this->timeout)
            ->acceptJson()
            ->withHeaders([
                'User-Agent' => 'Sistema-DRE-Huanuco/1.0',
                'Accept' => 'application/json'
            ]);
    }

    public function healthCheck(): bool
    {
        try {
            $response = $this->client()
                ->timeout(5)
                ->get("{$this->baseUrl}/api/public/reports");

            $data = $response->json();
            return $response->ok() && !empty($data) && ($data['success'] ?? false);
        } catch (\Exception $e) {
            Log::error('SIAGIE API health check failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener lista de reportes - respuesta esperada: { success: true, reports: [...] }
     */
    public function getAvailableReports(): array
    {
        try {
            $response = $this->client()->get("{$this->baseUrl}/api/public/reports");

            if ($response->ok()) {
                $data = $response->json();
                return [
                    'success' => ($data['success'] ?? false),
                    'reports' => $data['reports'] ?? [],
                ];
            }

            return [
                'success' => false,
                'message' => 'HTTP ' . $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('Error en getAvailableReports SIAGIE: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error de conexión: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtener reporte por slug - respuesta esperada: { success: true, report: { ... } }
     */
    public function getReportBySlug(string $slug): ?array
    {
        $cacheKey = "siagie_report_{$slug}";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = $this->client()->get("{$this->baseUrl}/api/public/reports/{$slug}");

            if ($response->ok()) {
                $data = $response->json();
                if (!empty($data) && ($data['success'] ?? false) && isset($data['report'])) {
                    $report = $data['report'];
                    Cache::put($cacheKey, $report, 3600 * 6); // 6 horas
                    return $report;
                }
            }

            Log::warning("Reporte SIAGIE no encontrado o respuesta inválida para slug: {$slug}");
            return null;
        } catch (\Exception $e) {
            Log::error("Error obteniendo reporte SIAGIE {$slug}: " . $e->getMessage());
            return null;
        }
    }

    public function clearReportCache(string $slug): void
    {
        Cache::forget("siagie_report_{$slug}");
    }
}