<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryOption extends Model
{
    protected $fillable = ['title_en', 'title_ar', 'deleted', 'category_id', 'is_required', 'category_type'];

    public function values() {
        return $this->hasMany('App\CategoryOptionValue', 'option_id');
    }
}