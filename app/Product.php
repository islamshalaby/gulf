<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $fillable = [
        'barcode',
        'stored_number',
        'title_en',
        'title_ar',
        'offer', 
        'description_ar', 
        'description_en', 
        'final_price', 
        'price_before_offer',
        'offer_percentage',
        'category_id',
        'brand_id',
        'sub_category_id',
        'car_type_id',
        'sub_one_car_type_id',
        'sub_two_car_type_id',
        'company_id',
        'year',
        'type',
        'deleted',
        'total_quatity',
        'remaining_quantity',
        'hidden',
        'delivery',
        'selected',
        'delivery_install',
        'global_shipping',
        'delivery_price',
        'installation_cost',
        'global_shipping_price',
        'multi_options',
        'weight',
        'height',
        'length',
        'width',
        'origin_country'
    ];

    public function images() {
        return $this->hasMany('App\ProductImage', 'product_id');
    }

    public function category() {
        return $this->belongsTo('App\CarType', 'car_type_id');
    }

    public function brand() {
        return $this->belongsTo('App\Brand', 'brand_id');
    }

    public function subCategory() {
        return $this->belongsTo('App\SubCategory', 'sub_category_id');
    }

    public function values() {
        return $this->belongsToMany('App\OptionValue', 'product_options', 'product_id', 'value_id');
    }

    public function options() {
        return $this->hasMany('App\ProductOption', 'product_id');
    }

    public function orderItems() {
        return $this->hasMany('App\OrderItem', 'product_id');
    }

    public function orders() {
        return $this->belongsToMany('App\Order', 'order_items', 'product_id','order_id')->withPivot('count');
    }

    public function mOptions() {
        return $this->belongsToMany('App\MultiOption', 'product_multi_options', 'product_id', 'multi_option_id');
    }

    public function mOptionsValuesEn() {
        return $this->belongsToMany('App\MultiOptionValue', 'product_multi_options', 'product_id', 'multi_option_value_id')->select('value_en as value', 'multi_option_values.id as option_value_id');
    }

    public function mOptionsValuesAr() {
        return $this->belongsToMany('App\MultiOptionValue', 'product_multi_options', 'product_id', 'multi_option_value_id')->select('value_ar as value', 'multi_option_values.id as option_value_id');
    }

    public function multiOptions() {
        return $this->hasMany('App\ProductMultiOption', 'product_id');
    }

    public function multiOptionss() {
        return $this->hasMany('App\ProductMultiOption', 'product_id');
    }

    public function mOptionsWhere($id) {
        return $this->multiOptions()->with('multiOption', 'multiOptionValue')->where('product_multi_options.id', $id)->first();
    }

    public function productProperties() {
        return $this->hasMany('App\ProductOption', 'product_id');
    }

    public function subOneCar() {
        return $this->belongsTo('App\SubOneCarType', 'sub_one_car_type_id');
    }

    public function subTwoCar() {
        return $this->belongsTo('App\SubTwoCarType', 'sub_two_car_type_id');
    }

    public function section() {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function company() {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function compatible() {
        return $this->hasMany('App\ProductCompatible', 'product_id');
    }
}
