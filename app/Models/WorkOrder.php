<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrder extends Model
{
    protected $fillable = [
        'client_id',
        'order_number',
        'job_name',
        'created_by',
        'number_of_colors',
        'rows_count',
        'material',
        'quantity',
        'width',
        'length',
        'final_product_shape',
        'additions',
        'addition_price',
        'fingerprint',
        'fingerprint_price',
        'winding_direction',
        'knife_exists',
        'knife_price',
        'external_breaking',
        'external_breaking_price',
        'film_price',
        'film_count',
        'sales_percentage',
        'material_price_per_meter',
        'manufacturing_price_per_meter',
        'notes',
        'status',
        'design_shape',
        'design_films',
        'design_knives',
        'design_drills',
        'design_breaking_gear',
        'design_gab',
        'design_file',
        'design_knife_id',
        'design_rows_count',
        'has_design',
        'production_status',
        'paper_width',
        'paper_weight',
        'waste_percentage',
        'number_of_rolls',
        'core_size',
        'pieces_per_sheet',
        'sheets_per_stack',
        'pieces_per_stack',
        'has_production',
        'gap_count',
        'waste_per_roll',
        'increase',
        'linear_meter',
        'sent_to_client',
        'sent_to_designer',
        'client_response',
        'client_design_approval',
        'designer_number_of_colors',
        'designer_drills',
        'designer_breaking_gear',
        'designer_paper_width',
        'designer_gap',
        'preparation_blocker',
    ];

    protected $casts = [
        'number_of_colors' => 'integer',
        'rows_count' => 'integer',
        'quantity' => 'integer',
        'width' => 'decimal:2',
        'length' => 'decimal:2',
        'addition_price' => 'decimal:2',
        'fingerprint_price' => 'decimal:2',
        'knife_price' => 'decimal:2',
        'external_breaking_price' => 'decimal:2',
        'has_design' => 'boolean',
        'design_rows_count' => 'integer',
        'paper_width' => 'decimal:2',
        'paper_weight' => 'decimal:2',
        'waste_percentage' => 'decimal:2',
        'film_price' => 'decimal:2',
        'film_count' => 'integer',
        'sales_percentage' => 'decimal:2',
        'material_price_per_meter' => 'decimal:2',
        'manufacturing_price_per_meter' => 'decimal:2',
        'number_of_rolls' => 'integer',
        'core_size' => 'decimal:2',
        'pieces_per_sheet' => 'integer',
        'sheets_per_stack' => 'integer',
        'pieces_per_stack' => 'integer',
        'has_production' => 'boolean',
        'gap_count' => 'decimal:2',
        'waste_per_roll' => 'integer',
        'increase' => 'decimal:2',
        'linear_meter' => 'decimal:2',
        'designer_number_of_colors' => 'integer',
        'designer_paper_width' => 'decimal:2',
        'designer_gap' => 'decimal:2',
    ];

    /**
     * Get the client that owns the work order.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the knife for the design.
     */
    public function designKnife(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Knife::class, 'design_knife_id');
    }
}
