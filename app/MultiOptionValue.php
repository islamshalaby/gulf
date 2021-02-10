<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MultiOptionValue extends Model
{
    protected $fillable = ['multi_option_id', 'value_en', 'value_ar'];
    protected $hidden = ['pivot'];

    public function products() {
        return $this->hasMany('App\ProductMultiOption', 'multi_option_value_id');
    }

    public function productMultiOptions() {
        return $this->hasMany('App\ProductMultiOption', 'multi_option_value_id');
    }
}
