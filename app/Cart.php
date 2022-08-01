<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['visitor_id', 'product_id', 'option_id', 'count', 'method', 'delivery_cost', 'installation_cost'];
}
