<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'gender', 'department', 'position', 'email', 'phone', 'address', 'date_of_birth', 'hire_date', 'status',];

    protected $casts = [
        'hire_date' => 'date',
        'date_of_birth' => 'date',
        'status' => 'boolean',
    ];
    // Accessor to return "Active" or "Inactive" instead of true/false
    public function getStatusAttribute($value)
    {
        return $value ? 'Active' : 'Inactive';
    }
}
