<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['content', 'user_id', 'product_id'];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}