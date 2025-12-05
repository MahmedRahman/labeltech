<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Get the department that owns the employee.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the position that owns the employee.
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'national_id',
        'years_of_experience',
        'department_id',
        'position_id',
        'account_type',
        'salary',
        'hire_date',
        'insurance_date',
        'insurance_number',
        'employee_code',
        'birth_date',
        'company_name',
        'resignation_date',
        'status',
        'address',
        'notes',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'hire_date' => 'date',
            'insurance_date' => 'date',
            'birth_date' => 'date',
            'resignation_date' => 'date',
            'salary' => 'decimal:2',
            'password' => 'hashed',
        ];
    }
}
