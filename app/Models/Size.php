<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $table = 'sizes';

    protected $fillable = [
        'squirefit',
        'price',
        'product_id', // Added product_id to fillable
    ];

    /**
     * Relationship: Size belongs to a Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
