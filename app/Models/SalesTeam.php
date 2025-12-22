<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SalesTeam extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the employees that belong to this sales team.
     */
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'sales_team_employee')
                    ->withTimestamps();
    }

    /**
     * Get the clients that belong to this sales team.
     */
    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'client_sales_team')
                    ->withTimestamps();
    }
}
