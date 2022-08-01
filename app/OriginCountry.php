<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OriginCountry extends Model
{
    protected $fillable = ['country_code', 'country_name'];
}