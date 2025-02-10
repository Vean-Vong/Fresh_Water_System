<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';

    protected $fillable = ['name', 'address', 'phone', 'date', 'model', 'seller', 'contract_type'];

    protected $casts = [
        'date' => 'datetime',
    ];
}