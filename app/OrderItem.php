<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'count', 'option_id', 'shipping', 'installation_cost', 'delivery_cost', 'final_with_delivery', 'total_installation', 'company_id',
    'shipping_cost',
     'status'   // 1 => in progress
                // 2 => delivery stage
                // 3 => installation
                // 4 => delivered
                // 5 => canceled from user
                // 6 => canceled from admin
    ];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function multiOption()
    {
        return $this->belongsTo('App\ProductMultiOption', 'option_id');
    }

    public function company() {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function shipment() {
        // dd($this->hasOne('App\Shipment', 'order_id'));
        return $this->hasOne('App\Shipment', 'order_id');
    }
}
