<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdSlider extends Model
{
    protected $fillable = ['image', 'country_id', 'content'];
}