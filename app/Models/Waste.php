<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    protected $fillable = [
        'number_of_colors',
        'waste_percentage',
        'waste_per_roll',
        'notes',
    ];

    protected $casts = [
        'number_of_colors' => 'integer',
        'waste_percentage' => 'decimal:2',
        'waste_per_roll' => 'decimal:2',
    ];
}
