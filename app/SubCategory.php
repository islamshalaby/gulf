<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = ['title_en', 'title_ar', 'image', 'deleted', 'brand_id', 'category_id'];

    public function brand() {
        return $this->belongsTo('App\Brand', 'brand_id');
    }

    public function category() {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function products() {
        return $this->hasMany('App\Product', 'sub_category_id')->where('deleted', 0)->where('hidden', 0);
    }

    public function adProducts() {
        return $this->hasMany('App\AdProduct', 'sub_category_id')->where('deleted', 0)->where('status', 1)->where('country_id', session('api_country'));
    }

    
    public function adPrs() {
        return $this->hasMany('App\AdProduct', 'sub_category_id')->where('deleted', 0);
    }

    public function subCategories() {
        return $this->hasMany('App\SubTwoCategory', 'sub_category_id')->where('deleted', 0);
    }
}
