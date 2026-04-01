<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiagieChart extends Model
{
    protected $table = 'siagie_charts';

    protected $fillable = [
        'report_slug', 
        'external_chart_id', 
        'chart_title',
        'chart_data', 
        'chart_config', 
        'order', 
        'is_active', 
        'is_global',
        'custom_notes'
    ];

    protected $casts = [
        'chart_data' => 'array',
        'chart_config' => 'array',
        'is_active' => 'boolean',
        'is_global' => 'boolean',
        'order' => 'integer'
    ];

    public function report()
    {
        return $this->belongsTo(SiagieReport::class, 'report_slug', 'slug');
    }
}