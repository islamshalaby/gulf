<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\APIHelpers;
use App\Setting;


class SettingController extends Controller
{
    public function getappnumber(Request $request){
        $setting = Setting::select('phone')->find(1);
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $setting['phone'] , $request->lang);
        return response()->json($response , 200);
    }

    public function getwhatsapp(Request $request){
        $setting = Setting::select('app_phone')->find(1);
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $setting['app_phone'] , $request->lang);
        return response()->json($response , 200);
    }
}