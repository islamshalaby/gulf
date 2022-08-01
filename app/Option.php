<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['title_en', 'title_ar', 'category_id', 'sort', 'parent_id'];

    public function category() {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function main_option() {
        return $this->belongsTo('App\Option', 'parent_id');
    }

    public function sub_options() {
        return $this->hasMany('App\Option', 'parent_id')->with('sub_values');
    }

    public function categories() {
        return $this->belongsToMany('App\CarType', 'options_categories', 'option_id', 'category_id')->where("car_types.deleted", 0);
    }

    public function cats() {
        return $this->hasMany('App\OptionCategory', 'option_id')->pluck("category_id")->toArray();
    }

    public function values() {
        return $this->hasMany('App\OptionValue', 'option_id');
    }

    public function products() {
        return $this->belongsToMany('App\Product', 'product_options', 'option_id', 'product_id')->where('products.deleted', 0);
    }
}
