<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Knife extends Model
{
    protected $fillable = [
        'knife_code',
        'knife_name',
        'knife_type',
        'size',
        'rows_count',
        'eyes_count',
        'flap_size',
        'grain_direction',
        'knife_thickness',
        'crease_lines',
        'punch_holes',
        'drill_size',
        'material_type',
        'purchase_date',
        'knife_status',
        'usage_count',
        'storage_location',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'knife_thickness' => 'decimal:2',
        'rows_count' => 'integer',
        'eyes_count' => 'integer',
        'crease_lines' => 'integer',
        'punch_holes' => 'integer',
        'usage_count' => 'integer',
    ];
}
