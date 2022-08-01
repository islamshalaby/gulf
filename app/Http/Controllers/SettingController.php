<?php
namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\APIHelpers;
use App\Service;
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

    public function paymentStatus(Request $request) {
        $settings = Setting::find(1);
        $data['hide_payment'] = false;
        if ($settings['hide_payment'] == 1) {
            $data['hide_payment'] = true;
        }

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data, $request->lang);
        return response()->json($response , 200);
    }

    public function getServices(Request $request) {
        $data = Service::select('title_' . $request->lang . ' as title', 'description_' . $request->lang . ' as description', 'type')->get();
        $settings = Setting::where('id', 1)->select('companies_logo', 'individual_logo')->first();
        $data[0]->logo = $settings->individual_logo;
        $data[1]->logo = $settings->companies_logo;

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data, $request->lang);
        return response()->json($response , 200);
    }

    public function getCountries(Request $request) {
        $data = Country::where('id', '!=', 4)->where('deleted', 0)->select('id', 'name_' . $request->lang . ' as name', 'flag', 'iso_code')->orderBy('name_' . $request->lang, 'asc')->get();

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data, $request->lang);
        return response()->json($response , 200);
    }

    public function getCountryName(Request $request) {
        $country = Country::where('id', $request->country_id)->select('id', 'name_' . $request->lang . ' as name')->first();

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $country, $request->lang);
        return response()->json($response , 200);
    }
}