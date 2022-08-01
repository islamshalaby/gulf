<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryArea extends Model
{
    protected $fillable = ['area_id', 'delivery_cost', 'store_id'];

    public function area() {
        return $this->belongsTo('App\GovernorateAreas', 'area_id');
    }

    public function store() {
        return $this->belongsTo('App\Company', 'store_id');
    }
}