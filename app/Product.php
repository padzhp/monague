<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
    	'name','description','category_id', 'image',
    	'ordering', 'status', 
    	'ca_enabled', 'ca_price', 'ca_published', 'ca_sku',
    	'ca_six_plus', 'ca_six_pack', 'ca_dozen_pack',
    	'us_enabled', 'us_price', 'us_published', 'us_sku',
    	'us_six_plus', 'us_six_pack', 'us_dozen_pack'
    ];

    protected $connection = "mysql";
}
