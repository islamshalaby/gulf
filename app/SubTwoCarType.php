<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubTwoCarType extends Model
{
    protected $fillable = ['title_en', 'title_ar', 'deleted', 'image', 'sub_one_car_type_id'];

    public function carType() {
        return $this->belongsTo('App\SubOneCarType', 'sub_one_car_type_id');
    }

    public function products() {
        return $this->hasMany('App\Product', 'sub_two_car_type_id')->where('deleted', 0)->where('hidden', 0);
    }

    public function subCategories() {
        return $this->hasMany('App\SubThreeCarType', 'sub_car_type_id')->where('deleted', 0);
    }
}