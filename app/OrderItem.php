<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;
    protected $table = "order_items";
    protected $connection = "mysql";
    
    protected $fillable = [
        'id', 'order_id', 'product_id', 'product_name',
        'subtotal', 'quantity', 'product_price'
    ];


	    
}
