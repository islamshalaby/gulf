<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdProductImage extends Model
{
    protected $fillable = ['image', 'product_id'];

    public function product() {
        return $this->belongsTo('App\AdProduct', 'product_id');
    }
}
