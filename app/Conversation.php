<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['last_message_id'];

    public function Message()
    {
        return $this->belongsTo('App\Message', 'last_message_id');
    }
}
