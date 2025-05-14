<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderList extends Model
{
    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'order_list';

    // Allow mass assignment on these fields
    protected $fillable = [
        'order_id',
        'order_ref_id', // Newly added reference field
        'user_id',
        'status',
        'amount',
        'tax_amount',
        'delivery_charges',
    ];

    // In OrderList.php model
public function order()
{
    return $this->belongsTo(Order::class, 'order_ref_id');
}

}
