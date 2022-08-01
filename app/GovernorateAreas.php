<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GovernorateAreas extends Model
{
    protected $fillable = ['name_en', 'name_ar', 'governorate_id', 'deleted', 'city_code'];

    public function governorate() {
        return $this->belongsTo('App\Governorate', 'governorate_id');
    }

    public function deliveryCompany($company_id) {
        $data = $this->hasOne('App\DeliveryArea', 'area_id')->where('store_id', $company_id)->first();
        if (!$data) {
            $obj = new \StdClass;
            $obj->delivery_cost = "";
            return $obj;
        }
        return $this->hasOne('App\DeliveryArea', 'area_id')->where('store_id', $company_id)->first();
    }

    public function deliveryCost() {
        return $this->hasOne('App\DeliveryArea', 'governorate_area_id');
    }
}