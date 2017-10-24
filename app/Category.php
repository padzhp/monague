<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';

	protected $fillable = [
        'company', 'user_id', 'billing_street', 'billing_city', 'billing_zip',
        'billing_state', 'billing_country', 'shipping_street', 'shipping_city',
        'shipping_state', 'shipping_country', 'shipping_zip', 'tax_number',
        'phone', 'fax', 'store_operation', 'store_type', 'price_range', 'heard_from'
    ];
    //
}
