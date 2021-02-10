<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['title_en', 'title_ar', 'delivery_cost', 'deleted'];
}
