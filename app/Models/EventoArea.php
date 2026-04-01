<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoArea extends Model
{
    use HasFactory;

    protected $table = 'eventos_areas';

    protected $fillable = [
        'area_id',
        'titulo',
        'descripcion',
        'enlace_1',
        'descripcion_enlace_1',
        'enlace_2',
        'descripcion_enlace_2',
        'enlace_3',
        'descripcion_enlace_3',
        'enlace_4',
        'descripcion_enlace_4',
        'enlace_5',
        'descripcion_enlace_5',
        'enlace_externo',
        'activo',
        'orden'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer'
    ];

    // Relación con AreasMenu
    public function area()
    {
        return $this->belongsTo(AreasMenu::class, 'area_id');
    }

    // Scope para eventos activos
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // Scope para ordenar
    public function scopeOrdenados($query)
    {
        return $query->orderBy('orden', 'asc')->orderBy('created_at', 'desc');
    }

    // Obtener enlaces que existen
    public function getEnlacesAttribute()
    {
        $enlaces = [];
        
        for ($i = 1; $i <= 5; $i++) {
            $enlace = $this->{"enlace_$i"};
            $descripcion = $this->{"descripcion_enlace_$i"};
            
            if ($enlace) {
                $enlaces[] = [
                    'numero' => $i,
                    'url' => $enlace,
                    'descripcion' => $descripcion ?: "Enlace $i"
                ];
            }
        }
        
        return $enlaces;
    }

    // Verificar si tiene enlaces
    public function getTieneEnlacesAttribute()
    {
        for ($i = 1; $i <= 5; $i++) {
            if ($this->{"enlace_$i"}) {
                return true;
            }
        }
        return false;
    }
}