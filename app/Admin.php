<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\AdminPermission;
use App\ContactUs;
use App\User;
use App\Setting;
use Illuminate\Support\Facades\Auth;


class Admin extends  Authenticatable
{
    //
    protected $appends = ['custom'];
    public function getCustomAttribute()
    {
        $user = Auth::guard('admin')->user();
        $admin_permission = AdminPermission::where('admin_id', $user->id)->pluck('permission_id');
        $admin_permission  = (array) $admin_permission;
        $admin_permission = array_values($admin_permission);
        $data['admin_permission'] = $admin_permission[0];
        $data['contact_us_count'] = ContactUs::where('seen' , 0)->count();
        $data['user_count'] = User::where('seen' , 0)->count();
        $data['setting'] = Setting::where('id' ,1)->select('app_name_en' , 'app_name_ar' , 'logo')->first();
        return $data;
    }
}
