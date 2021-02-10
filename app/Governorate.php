<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    protected $fillable = ['name_en', 'name_ar', 'country_id', 'deleted'];
}