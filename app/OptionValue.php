<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    protected $fillable = ['option_id', 'value_en', 'value_ar', 'parent_id'];

    public function option() {
        return $this->belongsTo('App\Option', 'option_id');
    }

    public function main_value() {
        return $this->belongsTo('App\OptionValue', 'parent_id');
    }

    public function sub_values() {
        return $this->hasMany('App\OptionValue', 'parent_id')->with('option');
    }

    public function proProps() {
        return $this->hasMany('App\ProductProperty', 'value_id');
    }

    public function products() {
        return $this->hasMany('App\ProductOption', 'value_id');
    }
}
