<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OffersSection extends Model
{
    protected $fillable = ['title_en', 'title_ar', 'icon', 'sort',
     'type' // 1 => ecommerce
            // 2 => ad
    ];

    public function offers() {
        return $this->belongsToMany('App\Product', 'control_offers', 'offers_section_id','offer_id');
    }

    public function adOffers() {
        return $this->belongsToMany('App\AdProduct', 'control_offers', 'offers_section_id','offer_id');
    }
}