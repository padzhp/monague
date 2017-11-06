<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

	protected $fillable = [
        'title','content','image','author','category_id','status','ordering','published','public'
    ];
}
