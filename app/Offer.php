<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['image', 'size', 'type', 'target_id', 'sort'];

    public function product() {
        return $this->belongsTo('App\Product', 'target_id');
    }

    public function category() {
        return $this->belongsTo('App\Category', 'target_id');
    }
}
