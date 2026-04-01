<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiagieReport extends Model
{
    protected $table = 'siagie_reports';

    protected $fillable = [
        'external_id', 'slug', 'title', 'description', 'category',
        'published_at', 'charts_count', 'api_url', 'is_available', 'last_synced_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'last_synced_at' => 'datetime',
        'is_available' => 'boolean',
        'charts_count' => 'integer'
    ];

    public function charts()
    {
        return $this->hasMany(SiagieChart::class, 'report_slug', 'slug');
    }

    /**
     * Gráficos activos
     */
    public function activeCharts(): HasMany
    {
        return $this->charts()
                    ->where('is_active', true)
                    ->orderBy('order');
    }

    /**
     * Verificar si necesita sincronización
     */
    public function needsSync(): bool
    {
        return !$this->last_synced_at || 
               $this->last_synced_at->diffInHours(now()) > 24;
    }

    /**
     * Scope: Solo disponibles
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope: Por categoría
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: Recientes
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }
}