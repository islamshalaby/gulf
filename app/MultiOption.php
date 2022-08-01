<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MultiOption extends Model
{
    protected $fillable = ['title_en', 'title_ar', 'category_id'];
    protected $hidden = ['pivot'];

    public function category() {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function subCategories() {
        return $this->belongsToMany('App\SubCategory', 'multi_options_sub_categories', 'multi_option_id', 'sub_category_id');
    }

    public function categories() {
        return $this->belongsToMany('App\Category', 'multi_options_categories', 'multi_option_id', 'category_id');
    }

    public function values() {
        return $this->hasMany('App\MultiOptionValue', 'multi_option_id');
    }

    public function productMultiOptions() {
        return $this->hasMany('App\ProductMultiOption', 'multi_option_id');
    }
}
