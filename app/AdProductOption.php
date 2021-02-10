<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdProductOption extends Model
{
    protected $fillable = ['option_id', 'value', 'product_id', 'option_en', 'option_ar', 'val_en', 'val_ar', 'type'];
}