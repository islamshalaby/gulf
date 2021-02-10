<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubFourCategory extends Model
{
    protected $fillable = ['title_en', 'title_ar', 'image', 'deleted', 'sub_category_id'];


    public function category() {
        return $this->belongsTo('App\SubThreeCategory', 'sub_category_id');
    }
}