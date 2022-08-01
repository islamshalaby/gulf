<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Setting;

class AppPagesController extends AdminController{

    // get about app edit page
    public function GetAboutApp(){
        $data['setting'] = Setting::find(1);
        return view('admin.aboutapp' , ['data' => $data]);
    }

    // post about app edit page
    public function PostAboutApp(Request $request){
        if(!$request->aboutapp_en){
            return redirect('admin-panel/app_pages/aboutapp')->with('status' , 'About App Text in English Required');
        }
        if(!$request->aboutapp_ar){
            return redirect('admin-panel/app_pages/aboutapp')->with('status' , 'About App Text in Arabic Required');
        }        
        $setting = Setting::find(1);
        $setting->aboutapp_en = $request->aboutapp_en;
        $setting->aboutapp_ar = $request->aboutapp_ar;
        // return $setting;
        $setting->save();        
        return redirect('admin-panel/app_pages/aboutapp');
    }

    // get Terms And Conditions edit page
    public function GetTermsAndConditions(){
        $data['setting'] = Setting::find(1);
        return view('admin.termsandconditions' , ['data' => $data]);
    }

    // get Terms And Conditions edit page
    public function PostTermsAndConditions(Request $request){
        if(!$request->termsandconditions_en){
            return redirect('admin-panel/app_pages/termsandconditions')->with('status' , 'Terms And Conditions Text in English Required');
        }
        if(!$request->termsandconditions_ar){
            return redirect('admin-panel/app_pages/termsandconditions')->with('status' , 'Terms And Conditions Text in Arabic Required');
        }
        $setting = Setting::find(1);
        $setting->termsandconditions_en = $request->termsandconditions_en;
        $setting->termsandconditions_ar = $request->termsandconditions_ar;
        $setting->save();    
        return redirect('admin-panel/app_pages/termsandconditions');
    }

    // get delivery information edit page
    public function GetDeliveryInformation() {
        $data['setting'] = Setting::find(1);
        return view('admin.deliveryinformation' , ['data' => $data]);
    }

    // post delivery information edit page
    public function PostDeliveryInformation(Request $request){
        if(!$request->delivery_information_en){
            return redirect('admin-panel/app_pages/deliveryinformation')->with('status' , 'Delivery Information Text in English Required');
        }
        if(!$request->delivery_information_ar){
            return redirect('admin-panel/app_pages/deliveryinformation')->with('status' , 'Delivery Information Text in Arabic Required');
        }        
        $setting = Setting::find(1);
        $setting->delivery_information_en = $request->delivery_information_en;
        $setting->delivery_information_ar = $request->delivery_information_ar;
        // return $setting;
        $setting->save();        
        return redirect('admin-panel/app_pages/deliveryinformation');
    }

    // get return policy edit page
    public function GetReturnPolicy() {
        $data['setting'] = Setting::find(1);
        return view('admin.returnpolicy' , ['data' => $data]);
    }

    // post return policy edit page
    public function PostReturnPolicy(Request $request){
        if(!$request->return_policy_en){
            return redirect('admin-panel/app_pages/returnpolicy')->with('status' , 'Return Policy Text in English Required');
        }
        if(!$request->return_policy_ar){
            return redirect('admin-panel/app_pages/returnpolicy')->with('status' , 'Return Policy Text in Arabic Required');
        }        
        $setting = Setting::find(1);
        $setting->return_policy_en = $request->return_policy_en;
        $setting->return_policy_ar = $request->return_policy_ar;
        // return $setting;
        $setting->save();        
        return redirect('admin-panel/app_pages/returnpolicy');
    }
    

}