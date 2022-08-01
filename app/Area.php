<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['title_en', 'title_ar', 'delivery_cost', 'deleted'];

    public function deliveryCompany($company_id) {
        $data = $this->hasOne('App\DeliveryArea', 'area_id')->where('store_id', $company_id)->first();
        if (!$data) {
            $obj = new \StdClass;
            $obj->delivery_cost = "";
            return $obj;
        }
        return $this->hasOne('App\DeliveryArea', 'area_id')->where('store_id', $company_id)->first();
    }
}
