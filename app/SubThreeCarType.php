<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubThreeCarType extends Model
{
    protected $fillable = ['title_en', 'title_ar', 'image', 'deleted', 'sub_car_type_id'];

    public function products() {
        return $this->hasMany('App\Product', 'category_id')->where('deleted', 0)->where('hidden', 0);
    }

    public function carType() {
        return $this->belongsTo('App\SubTwoCarType', 'sub_car_type_id');
    }

    public function suCarTypes() {
        return $this->hasMany('App\SubFourCarType', 'sub_car_type_id')->where('deleted', 0);
    }

    public function subCategories() {
        return $this->hasMany('App\SubFourCarType', 'sub_car_type_id')->where('deleted', 0);
    }
}