<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['image', 'title_en', 'title_ar', 'deleted', 'type'];

    public function brands() {
        return $this->hasMany('App\Brand', 'category_id');
    }

    public function products() {
        return $this->hasMany('App\Product', 'category_id')->where('deleted', 0)->where('hidden', 0);
    }

    public function adPrs() {
        return $this->hasMany('App\AdProduct', 'category_id')->where('deleted', 0);
    }

    public function adProducts() {
        return $this->hasMany('App\AdProduct', 'category_id')->where('deleted', 0)->where('status', 1)->where('country_id', session('api_country'));
    }

    public function options() {
        return $this->belongsToMany('App\Option', 'options_categories', 'category_id', 'option_id')->where("parent_id", 0);
    }

    public function multiOptions() {
        return $this->belongsToMany('App\MultiOption', 'multi_options_categories', 'category_id', 'multi_option_id');
    }

    public function optionsWithValues() {
        return $this->options()->with('values');
    }

    public function multiOptionsWithValues() {
        return $this->multiOptions()->with('values');
    }

    public function subCategories() {
        return $this->hasMany('App\SubCategory', 'category_id')->where('deleted', 0);
    }
}
