<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Service;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Setting;

class SettingController extends AdminController{
    
    // get setting
    public function GetSetting(){
        $data['setting'] = Setting::find(1);
        $data['services'] = Service::get();
        return view('admin.setting' , ['data' => $data]);
    }

    // post setting
    public function PostSetting(Request $request){
        $setting = Setting::find(1);
        if($request->file('logo')){
            $logo = $setting->logo;
            $publicId = substr($logo , 0 , strrpos($logo , "."));
            Cloudder::delete($publicId);
            $logo_name = $request->file('logo')->getRealPath();
            Cloudder::upload($logo_name , null);
            $logoreturned = Cloudder::getResult();
            $logo_id = $logoreturned['public_id'];
            $logo_format = $logoreturned['format'];
            $logo_new_name = $logo_id.'.'.$logo_format;
            $setting->logo = $logo_new_name;    
        }
        if($request->file('companies_logo')){
            $companies_logo = $setting->companies_logo;
            if ($companies_logo) {
                $publicId = substr($companies_logo , 0 , strrpos($companies_logo , "."));
                Cloudder::delete($publicId);
            }
            $logo_name = $request->file('companies_logo')->getRealPath();
            Cloudder::upload($logo_name , null);
            $logoreturned = Cloudder::getResult();
            $logo_id = $logoreturned['public_id'];
            $logo_format = $logoreturned['format'];
            $logo_new_name = $logo_id.'.'.$logo_format;
            $setting->companies_logo = $logo_new_name;    
        }
        if($request->file('individual_logo')){
            $individual_logo = $setting->individual_logo;
            if ($individual_logo) {
                $publicId = substr($individual_logo , 0 , strrpos($individual_logo , "."));
                Cloudder::delete($publicId);
            }
            $logo_name = $request->file('individual_logo')->getRealPath();
            Cloudder::upload($logo_name , null);
            $logoreturned = Cloudder::getResult();
            $logo_id = $logoreturned['public_id'];
            $logo_format = $logoreturned['format'];
            $logo_new_name = $logo_id.'.'.$logo_format;
            $setting->individual_logo = $logo_new_name;    
        }
        if($request->file('vehicle_banner')){
            $vehicle_banner = $setting->vehicle_banner;
            if ($vehicle_banner) {
                $publicId = substr($vehicle_banner , 0 , strrpos($vehicle_banner , "."));
                Cloudder::delete($publicId);
            }
            $logo_name = $request->file('vehicle_banner')->getRealPath();
            Cloudder::upload($logo_name , null);
            $logoreturned = Cloudder::getResult();
            $logo_id = $logoreturned['public_id'];
            $logo_format = $logoreturned['format'];
            $logo_new_name = $logo_id.'.'.$logo_format;
            $setting->vehicle_banner = $logo_new_name;    
        }
        if($request->file('store_image')){
            $store_banner = $setting->store_image;
            if ($store_banner) {
                $publicId = substr($store_banner , 0 , strrpos($store_banner , "."));
                Cloudder::delete($publicId);
            }
            $logo_name = $request->file('store_image')->getRealPath();
            Cloudder::upload($logo_name , null);
            $logoreturned = Cloudder::getResult();
            $logo_id = $logoreturned['public_id'];
            $logo_format = $logoreturned['format'];
            $logo_new_name = $logo_id.'.'.$logo_format;
            $setting->store_image = $logo_new_name;    
        }
        $setting->app_name_en = $request->app_name_en;
        $setting->app_name_ar = $request->app_name_ar;
        $setting->email = $request->email;
        $setting->phone = $request->phone;
        $setting->app_phone = $request->app_phone;
        $hide_payment = 0; 
        if ($request->hide_payment) {
            $hide_payment = 1;
        }
        $setting->hide_payment = $hide_payment;
        $setting->address_en = $request->address_en;
        $setting->address_ar = $request->address_ar;
        $setting->app_name_ar = $request->app_name_ar;
        $setting->facebook = $request->facebook;
        $setting->youtube = $request->youtube;
        $setting->twitter = $request->twitter;
        $setting->instegram = $request->instegram;
        $setting->snap_chat = $request->snap_chat;
        $setting->ad_period = $request->ad_period;
        $setting->feature_ad_period = $request->feature_ad_period;
        $setting->pin_ad_period = $request->pin_ad_period;
        $setting->map_url = $request->map_url;
        $setting->latitude = $request->latitude;
        $setting->longitude = $request->longitude;
        $setting->free_ads_count = $request->free_ads_count;
        $setting->save();
        if ($request->vehicle_title_en || $request->vehicle_title_ar || $request->vehicle_description_en || $request->vehicle_description_ar) {
            $service = Service::where('type', 'ads')->first();
            $service->title_en = $request->vehicle_title_en;
            $service->title_ar = $request->vehicle_title_ar;
            $service->description_en = $request->vehicle_description_en;
            $service->description_ar = $request->vehicle_description_ar;
            $service->save();
        }
        if ($request->store_title_en || $request->store_title_ar || $request->store_description_en || $request->store_description_ar) {
            $service2 = Service::where('type', 'store')->first();
            $service2->title_en = $request->store_title_en;
            $service2->title_ar = $request->store_title_ar;
            $service2->description_en = $request->store_description_en;
            $service2->description_ar = $request->store_description_ar;
            $service2->save();
        }
        return redirect()->back()->with('success', __('messages.updated_s'));
    }
}