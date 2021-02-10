<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    protected $fillable = ['title_en', 'title_ar', 'image', 'deleted'];

    public function products() {
        return $this->hasMany('App\Product', 'car_type_id');
    }

    public function options() {
        return $this->belongsToMany('App\Option', 'options_categories', 'category_id', 'option_id');
    }

    public function optionsWithValues() {
        return $this->options()->with('values');
    }
}
