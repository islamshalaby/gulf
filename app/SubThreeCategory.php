<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubThreeCategory extends Model
{
    //
    protected $fillable = ['title_en', 'title_ar', 'image', 'deleted', 'sub_category_id'];


    public function category() {
        return $this->belongsTo('App\SubTwoCategory', 'sub_category_id');
    }
}