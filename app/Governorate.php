<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    protected $fillable = ['name_en', 'name_ar', 'country_id', 'deleted'];

    public function country() {
        return $this->belongsTo('App\Country', 'country_id');
    }

    public function areas() {
        return $this->hasMany('App\GovernorateAreas', 'governorate_id')->where('deleted', 0);
    }
}