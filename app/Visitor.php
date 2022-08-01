<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['unique_id', 'fcm_token', 'type', 'user_id', 'country_id'];
}