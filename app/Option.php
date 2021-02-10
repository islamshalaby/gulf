<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['title_en', 'title_ar', 'category_id'];

    public function category() {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function categories() {
        return $this->belongsToMany('App\CarType', 'options_categories', 'option_id', 'category_id');
    }

    public function values() {
        return $this->hasMany('App\OptionValue', 'option_id');
    }
}
