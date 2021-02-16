<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryOptionValue extends Model
{
    protected $fillable = ['value_en', 'value_ar', 'option_id', 'deleted'];

    
}