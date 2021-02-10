<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['title_en', 'title_ar', 'image', 'category_id', 'deleted'];

    public function category() {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function subCategories() {
        return $this->hasMany('App\SubCategory', 'brand_id');
    }

    public function products() {
        return $this->hasMany('App\Product', 'brand_id');
    }
}
