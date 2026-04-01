<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    use HasFactory;

    protected $table = 'pagina'; // Asegurar que apunta a la tabla correcta

    protected $fillable = [
        'nom_pagina',
        'cont_pagina'
    ];

    // No usar timestamps automáticos si la tabla no los tiene en el formato esperado
    public $timestamps = false;

    // Relación con direcciones
    public function direccion()
    {
        return $this->hasOne(Direccion::class, 'idpagina');
    }

    // Relación con menús
    public function menu()
    {
        return $this->hasOne(Menu::class, 'idpagina');
    }
}