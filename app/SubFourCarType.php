<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubFourCarType extends Model
{
    protected $fillable = ['title_en', 'title_ar', 'image', 'deleted', 'sub_car_type_id'];

    public function products() {
        return $this->hasMany('App\Product', 'sub_category_id')->where('deleted', 0)->where('hidden', 0);
    }

    public function carType() {
        return $this->belongsTo('App\SubThreeCarType', 'sub_car_type_id');
    }

}