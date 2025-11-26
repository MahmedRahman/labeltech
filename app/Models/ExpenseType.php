<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseType extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'description',
    ];

    /**
     * Get the parent expense type.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ExpenseType::class, 'parent_id');
    }

    /**
     * Get the child expense types.
     */
    public function children(): HasMany
    {
        return $this->hasMany(ExpenseType::class, 'parent_id');
    }

    /**
     * Check if this is a parent type (has no parent).
     */
    public function isParent(): bool
    {
        return $this->parent_id === null;
    }

    /**
     * Check if this is a child type (has a parent).
     */
    public function isChild(): bool
    {
        return $this->parent_id !== null;
    }
}
