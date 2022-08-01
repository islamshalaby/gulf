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
    'type', // 1 => new
            // 2 => used
    'views',
    'offer',
    'status',
    'publication_date',
    'expiry_date',
    'expiry_feature',
    'expire_pin_date',
    'feature_home',
    'sub_category_id',
    'sub_category_two_id',
    'sub_category_three_id',
    'sub_category_four_id',
    'selected',
    'country_id',
    'governorate_id',
    'governorate_area_id',
    'year',
    'deleted'
    ];

    public function options() {
        return $this->hasMany('App\AdProductOption', 'product_id');
    }

    public function images() {
        return $this->hasMany('App\AdProductImage', 'product_id');
    }

    public function mainImage() {
        return $this->hasOne('App\AdProductImage', 'product_id')->oldest();
    }

    public function category() {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function subCategory() {
        return $this->belongsTo('App\SubCategory', 'sub_category_id');
    }

    public function subTwoCategory() {
        return $this->belongsTo('App\SubTwoCategory', 'sub_category_two_id');
    }

    public function subThreeCategory() {
        return $this->belongsTo('App\SubThreeCategory', 'sub_category_three_id');
    }

    public function subFourCategory() {
        return $this->belongsTo('App\SubFourCategory', 'sub_category_four_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function bestOffer() {
        return $this->hasOne('App\BestOffer', 'product_id');
    }

    public function comments() {
        return $this->hasMany('App\Comment', 'product_id');
    }
}
