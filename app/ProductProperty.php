<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductProperty extends Model
{
    protected $fillable = ['product_id', 'option_id', 'value_id'];

    public function values() {
        return $this->belongsTo('App\OptionValue', 'value_id');
    }
}