<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrder extends Model
{
    protected $fillable = [
        'client_id',
        'order_number',
        'number_of_colors',
        'material',
        'quantity',
        'width',
        'length',
        'final_product_shape',
        'additions',
        'notes',
        'status',
    ];

    protected $casts = [
        'number_of_colors' => 'integer',
        'quantity' => 'integer',
        'width' => 'decimal:2',
        'length' => 'decimal:2',
    ];

    /**
     * Get the client that owns the work order.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
