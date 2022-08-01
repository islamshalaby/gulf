<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'image',
        'type',
        'content',
        'place', // in ads 1 = product
                        // 2 = category
        'product_type'      // 1 => ecommerce
                            // 2 => ad
    ];
}
