<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    protected $fillable = ['type', 'title_ar', 'title_en', 'sort', 'section_type'];

    public function homeElements() {
        return $this->hasMany('App\HomeElement', 'home_id');
    }

    public function categories() {
        return $this->belongsToMany('App\CarType', 'home_elements', 'home_id','element_id');
    }

    public function ads() {
        return $this->belongsToMany('App\Ad', 'home_elements', 'home_id','element_id');
    }

    public function brands() {
        return $this->belongsToMany('App\Company', 'home_elements', 'home_id','element_id');
    }

    public function offers() {
        return $this->belongsToMany('App\Product', 'home_elements', 'home_id','element_id');
    }

}
