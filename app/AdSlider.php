<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdSlider extends Model
{
    protected $fillable = ['image', 'country_id', 'content', 'type', 'link_type'];

    public function country() {
        return $this->belongsTo('App\Country', 'country_id');
    }
}