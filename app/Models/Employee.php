<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'national_id',
        'years_of_experience',
        'position',
        'department',
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
    ];

    protected $casts = [
        'hire_date' => 'date',
        'insurance_date' => 'date',
        'birth_date' => 'date',
        'resignation_date' => 'date',
        'salary' => 'decimal:2',
    ];
}
