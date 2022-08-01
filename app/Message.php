<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['message', 'type', 'is_read','user_id','conversation_id','ad_product_id'];
}
