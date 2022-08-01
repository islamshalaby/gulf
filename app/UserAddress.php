<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'latitude', 
        'longitude', 
        'title', 
        'address_type', 
        'area_id', 
        'gaddah', 
        'building', 
        'floor', 
        'apartment_number', 
        'street', 
        'extra_details', 
        'user_id', 
        'phone', 
        'piece',
        'deleted'
    ];

    public function area() {
        return $this->belongsTo('App\Area', 'area_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function goveronrateArea() {
        return $this->belongsTo('App\GovernorateAreas', 'area_id');
    }

    public function orders() {
        return $this->hasMany('App\Order', 'address_id');
    }
}