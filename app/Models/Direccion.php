<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AreasMenu;
use App\Models\Pagina;

class Direccion extends Model
{
    use HasFactory;

    protected $table = 'direcciones';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'imagen_director',
        'imagen_organigrama',
        'idpagina',
        'activo'
    ];

    // Relación con AreasMenu
    public function areasMenu()
    {
        return $this->hasMany(AreasMenu::class, 'direccion_id')->where('activo', true)->orderBy('orden');
    }

    // Alias para compatibilidad
    public function areas()
    {
        return $this->areasMenu();
    }

    // Relación con Pagina del sistema de menús
    public function pagina()
    {
        return $this->belongsTo(Pagina::class, 'idpagina', 'id');
    }

    // Relación con Menu
    public function menu()
    {
        return $this->hasOneThrough(Menu::class, Pagina::class, 'id', 'idpagina', 'idpagina', 'id');
    }
}