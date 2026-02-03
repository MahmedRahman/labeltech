<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'company',
        'notes',
        'opening_balance',
        'is_representative',
    ];

    protected $casts = [
        'opening_balance' => 'decimal:2',
        'is_representative' => 'boolean',
    ];

    /**
     * Get the work orders for the client.
     */
    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class);
    }

    /**
     * Get the sales teams that the client belongs to.
     */
    public function salesTeams(): BelongsToMany
    {
        return $this->belongsToMany(SalesTeam::class, 'client_sales_team')
                    ->withTimestamps();
    }
}
