<?php
// filepath: c:\Users\liliana\Desktop\Sistemas DRE\drehco\app\Models\SiagieEnlace.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiagieEnlace extends Model
{
    use HasFactory;

    protected $table = 'siagie_enlaces';

    protected $fillable = [
        'titulo',
        'descripcion',
        'url',
        'tipo',
        'imagen',
        'icono',
        'orden',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer'
    ];

    // Scope para enlaces activos
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    // Scope para ordenar por orden
    public function scopeOrdenado($query)
    {
        return $query->orderBy('orden')->orderBy('titulo');
    }

    // Accessor para el tipo formateado
    public function getTipoFormateadoAttribute()
    {
        return ucfirst($this->tipo);
    }

    // Accessor para la URL de imagen
    public function getImagenUrlAttribute()
    {
        if ($this->imagen) {
            return asset('img/siagie/' . $this->imagen);
        }
        return null;
    }
}