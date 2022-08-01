<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    protected $fillable = ['image', 'title_en', 'title_ar', 'email', 'password', 'deleted', 'area_id', 'address', 'shipping_cost'];

    protected $appends = ['custom'];
    public function getCustomAttribute()
    {
        $data['setting'] = Setting::where('id',1)->select('app_name_en' , 'app_name_ar' , 'logo')->first();
        return $data;
    }

    public function products() {
        return $this->hasMany('App\Product', 'company_id')->where('deleted', 0)->where('hidden', 0);
    }

    public function deliveryByarea($area) {
        return $this->hasOne('App\DeliveryArea', 'store_id')->where('area_id', $area)->first();
    }

    public function areas() {
        return $this->hasMany('App\DeliveryArea', 'store_id');
    }
}
