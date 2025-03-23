<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'model',
        'price',
        'discount',
        'date',
        'duration',
        'warranty',
        'seller',
        'contract_type',
    ];



    /**
     * Accessor for formatted price (if stored as a string)
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Accessor for formatted discount (e.g., "10%")
     */
    public function getFormattedDiscountAttribute()
    {
        return $this->discount . '%';
    }

    /**
     * Accessor for duration (e.g., "1 year" or "6 months")
     */
    public function getFormattedDurationAttribute()
    {
        return $this->duration;
    }
}
