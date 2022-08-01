<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubOneCarType extends Model
{
    protected $fillable = ['title_en', 'title_ar', 'image', 'deleted', 'car_type_id'];

    public function products() {
        return $this->hasMany('App\Product', 'sub_one_car_type_id')->where('deleted', 0)->where('hidden', 0);
    }

    public function carType() {
        return $this->belongsTo('App\CarType', 'car_type_id');
    }

    public function subCategories() {
        return $this->hasMany('App\SubTwoCarType', 'sub_one_car_type_id')->where('deleted', 0);
    }

}
