<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreasMenu extends Model
{
    use HasFactory;

    protected $table = 'areas_menu';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'imagen_funcionario',
        'imagen_organigrama',
        'link_descarga_1',
        'texto_descarga_1',
        'link_descarga_2',
        'texto_descarga_2',
        'direccion_id',
        'orden',
        'activo'
    ];

    public function eventos()
    {
        return $this->hasMany(EventoArea::class, 'area_id')
                    ->where('activo', true)
                    ->orderBy('orden', 'asc')
                    ->orderBy('created_at', 'desc');
    }

    // Todos los eventos (incluso inactivos) para administración
    public function todosLosEventos()
    {
        return $this->hasMany(EventoArea::class, 'area_id')
                    ->orderBy('orden', 'asc')
                    ->orderBy('created_at', 'desc');
    }

    // Agregar valores por defecto
    protected $attributes = [
        'activo' => true,
        'orden' => 0
    ];

    // Asegurar que activo sea booleano
    protected $casts = [
        'activo' => 'boolean'
    ];

    public function direccion()
    {
        return $this->belongsTo(Direccion::class);
    }
}