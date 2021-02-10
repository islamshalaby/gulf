<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    protected $fillable = ['option_id', 'value_en', 'value_ar'];

    public function option() {
        return $this->belongsTo('App\Option', 'option_id');
    }

    public function proProps() {
        return $this->hasMany('App\ProductProperty', 'value_id');
    }
}
