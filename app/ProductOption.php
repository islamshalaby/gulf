<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $fillable = ['option_id', 'product_id', 'value_id', 'value_en', 'value_ar'];
}
