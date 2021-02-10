<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeElement extends Model
{
    protected $fillable = ['home_id', 'element_id'];

    public function sections() {
        return $this->belongsToMany('App\HomeSection');
    }
    
}
