<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    protected $fillable = ['image', 'title_en', 'title_ar', 'email', 'password', 'deleted'];

    protected $appends = ['custom'];
    public function getCustomAttribute()
    {
        $data['setting'] = Setting::where('id',1)->select('app_name_en' , 'app_name_ar' , 'logo')->first();
        return $data;
    }

    public function products() {
        return $this->hasMany('App\Product', 'company_id')->where('deleted', 0)->where('hidden', 0);
    }
}
