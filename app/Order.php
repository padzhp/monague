<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $connection = "mysql";
    protected $table = "orders";
    
    protected $fillable = [
        'id', 'order_id', 'billing_address', 'billing_city', 'billing_zip',
        'billing_state', 'billing_country', 'shipping_address', 'shipping_city',
        'shipping_state', 'shipping_country', 'shipping_zip', 'tax_number',
        'phone', 'email', 'customer', 'company', 'status', 'total', 'payment_type',
        'user_id', 'customer_note', 'currency', 'token','created_at','updated_at'
    ];


    public function orderitems()
    {
        return $this->hasMany('App\OrderItem','order_id','order_id');
    }


	    
}
