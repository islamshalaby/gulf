<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['image', 'title_en', 'title_ar', 'deleted'];

    public function products() {
        return $this->hasMany('App\Product', 'company_id')->where('deleted', 0)->where('hidden', 0);
    }
}
