<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 
        'address_id', 
        'payment_method', 
        'subtotal_price', 
        'delivery_cost',
        'installation_cost',
        'shipping_cost',
        'total_price', 
        'status',   // 1 => in progress
                    // 2 => delivery stage
                    // 3 => installation
                    // 4 => delivered
                    // 5 => canceled from user
                    // 6 => canceled from admin
        'order_number'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function address() {
        return $this->belongsTo('App\UserAddress', 'address_id');
    }

    public function items() {
        return $this->belongsToMany('App\Product', 'order_items', 'order_id', 'product_id')->select('*');
    }

    public function oItems() {
        return $this->hasMany('App\OrderItem', 'order_id');
    }

    public function canceledItems() {
        return $this->hasMany('App\OrderItem', 'order_id')->whereIn('status', [5, 6]);
    }

    public function oItemsCompany($company_id) {
        return $this->hasMany('App\OrderItem', 'order_id')->where('company_id', $company_id);
    }

    public function oItemCompany($company_id) {
        return $this->hasMany('App\OrderItem', 'order_id')->where('company_id', $company_id)->first();
    }

    public function dynamicOItems($status) {
        return $this->hasMany('App\OrderItem', 'order_id')->where('status', $status);
    }

}
