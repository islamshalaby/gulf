<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name_en', 'name_ar', 'flag', 'currency', 'currency_ar', 'currency_logo', 'iso_code', 'deleted'];

    public function currency() {
        return $this->hasOne('App\Currency', 'country_id');
    }

    public function governorates() {
        return $this->hasMany('App\Governorate', 'country_id')->where('deleted', 0);
    }
}