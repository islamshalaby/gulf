<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GovernorateAreas extends Model
{
    protected $fillable = ['name_en', 'name_ar', 'governorate_id', 'deleted'];

    public function governorate() {
        return $this->belongsTo('App\Governorate', 'governorate_id');
    }
}