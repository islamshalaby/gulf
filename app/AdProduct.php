<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdProduct extends Model
{
    protected $fillable = ['title',
    'description',
    'price',
    'category_id',
    'user_id',
    'type',
    'views',
    'offer',
    'status',
    'publication_date',
    'expiry_date',
    'sub_category_id',
    'sub_category_two_id',
    'selected',
    'country_id',
    'governorate_id',
    'governorate_area_id'
    ];

    public function options() {
        return $this->hasMany('App\AdProductOption', 'product_id');
    }

    public function images() {
        return $this->belongsTo('App\AdProductImage', 'product_id');
    }

    public function mainImage() {
        return $this->hasOne('App\AdProductImage', 'product_id')->oldest();
    }
}
