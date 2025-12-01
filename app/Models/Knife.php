<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Knife extends Model
{
    protected $fillable = [
        'type',
        'gear',
        'dragile_drive',
        'rows_count',
        'eyes_count',
        'flap_size',
        'length',
        'width',
        'knife_code',
        'notes',
    ];

    protected $casts = [
        'rows_count' => 'integer',
        'eyes_count' => 'integer',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
    ];
}
