<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resolucion extends Model
{
    use HasFactory;
    protected $connection = 'digitaldb';
    protected $table = 'inv_resoluciones';
    public function tipo(): BelongsTo
    {
        return $this->belongsTo(TipoResolucion::class, 'resoluciontipo_id');
    }
}
