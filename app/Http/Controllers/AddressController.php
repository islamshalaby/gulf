<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserAddress;
use App\Area;
use App\Cart;
use App\Governorate;
use App\GovernorateAreas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\APIHelpers;
use App\Visitor;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' , ['except' => ['getdeliveryprice' , 'getareas']]);
    }

    public function getaddress(Request $request){
        $validator = Validator::make($request->all(), [
            'unique_id' => 'required',
            'country' => 'required'
        ]);
        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة'  , null , $request->lang);
            return response()->json($response , 406);
        }
        $user = auth()->user();
        $visitor = Visitor::where('unique_id', $request->unique_id)->select('id')->first();
        $cart = Cart::where('visitor_id', $visitor->id)->select('method')->get();
        $governorates = Governorate::where('country_id', $request->country)->where('deleted', 0)->pluck('id')->toArray();
        $gAreas = GovernorateAreas::whereIn('governorate_id', $governorates)->where('deleted', 0)->pluck('id')->toArray();
        $address = UserAddress::whereIn('area_id', $gAreas)->where('user_id' , $user->id)->where('deleted', 0)->orderBy('id' , 'desc')->get();
        

        for($i = 0; $i < count($address); $i++){
            if($request->lang == 'en'){
				$address[$i]['area_name'] = GovernorateAreas::find($address[$i]['area_id'])['name_en'];
			}else{
				$address[$i]['area_name'] = GovernorateAreas::find($address[$i]['area_id'])['name_ar'];
			}
            if($user->main_address_id == $address[$i]['id']){
                $address[$i]['is_default'] =  true;
            }else{
                $address[$i]['is_default'] =  false;

            }
        }
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $address , $request->lang);
        return response()->json($response , 200);
    }

    public function addaddress(Request $request){
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
            'address_type' => 'required', // 1 home , 2 work
            'area_id' => 'required',
            'building' => 'required',
            'country_id' => 'required',
            'governorate_id' => 'required',
            // 'floor' => 'required',
            // 'apartment_number' => 'required',
            'street' => 'required',
            'phone' => 'required',
            'piece' => 'required',            
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة'  , null , $request->lang);
            return response()->json($response , 406);
        }
        $user_id = auth()->user()->id;
        $address = new UserAddress();
        $address->user_id = $user_id;
        $address->latitude = $request->latitude;
        $address->longitude = $request->longitude;
        $address->address_type = $request->address_type;
        $address->area_id = $request->area_id;
        if($request->floor){
            $address->floor = $request->floor;
        }
        if($request->apartment_number){
            $address->apartment_number = $request->apartment_number;
        }
        $address->street = $request->street;
        $address->phone = $request->phone;
        $address->piece = $request->piece;
        $address->building = $request->building;
        if($request->title){
            $address->title = $request->title;
        }
        if($request->gaddah){
            $address->gaddah = $request->gaddah;
        }
        if($request->extra_details){
            $address->extra_details = $request->extra_details;
        }
        $address->save();

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $address , $request->lang);
        return response()->json($response , 200);
    }

    public function removeaddress(Request $request){
        $validator = Validator::make($request->all(), [
            'address_id' => 'required',           
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة'  , null , $request->lang);
            return response()->json($response , 406);
        }
        $user_id = auth()->user()->id;
        $address = UserAddress::find($request->address_id);
        if($address){
            if($address->user_id == $user_id){
                $address->update(['deleted' => 1]);

                $addresses = UserAddress::where('user_id' , $user_id)->where('deleted', 0)->get();

                $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $addresses  , $request->lang);
                return response()->json($response , 200);
            }else{
                $response = APIHelpers::createApiResponse(true , 406 , 'You do not have the authority to delete this address' , 'ليس لديك الصلاحيه لحذف هذا العنوان'  , null , $request->lang);
                return response()->json($response , 406);
            }
        }else{
            $response = APIHelpers::createApiResponse(true , 406 , 'Invalid address id' , 'رقم عنوان غير صحيح'  , null , $request->lang);
            return response()->json($response , 406);
        }

    }

    public function setmain(Request $request){
        $validator = Validator::make($request->all(), [
            'address_id' => 'required',           
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة'  , null , $request->lang);
            return response()->json($response , 406);
        }
        $user = auth()->user();
        
        $main_address = UserAddress::where('user_id' , $user->id)->where('id' ,$request->address_id)->first();

        if(!$main_address){
            $response = APIHelpers::createApiResponse(true , 406 , 'You do not have the authority for this address' , 'ليس لديك الصلاحيه لهذا العنوان'  , null , $request->lang);
            return response()->json($response , 406);            
        }
        $user->main_address_id = $request->address_id;
        $user->save();

        $address = UserAddress::where('user_id' , $user->id)->orderBy('id' , 'desc')->get();

        for($i = 0; $i < count($address); $i++){
            if($user->main_address_id == $address[$i]['id']){
                $address[$i]['is_default'] =  true;
            }else{
                $address[$i]['is_default'] =  false;

            }
        }

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $address , $request->lang);
        return response()->json($response , 200);

    }

    public function getareas(Request $request){
        $governorates = Governorate::where('country_id', 4)->pluck('id')->toArray();
        
        $areas = GovernorateAreas::where('deleted' , 0)->whereIn('governorate_id', $governorates)->select('id', 'name_' . $request->lang . ' as title')->get();
        
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $areas , $request->lang);
        return response()->json($response , 200);
    }

    public function getdeliveryprice(Request $request){
        $validator = Validator::make($request->all(), [
            'address_id' => 'required',           
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة'  , null , $request->lang);
            return response()->json($response , 406);
        }

        $address = UserAddress::find($request->address_id);
        $area_id =  $address['area_id'];
        $area = Area::select('delivery_cost')->find($area_id);
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $area , $request->lang);
        return response()->json($response , 200);
    }

    public function getdetails(Request $request){
        $addess_id = $request->id;
        $address = UserAddress::find($request->id);
        $area_id =  $address['area_id'];
        if($request->lang == 'en'){
            $area = GovernorateAreas::select('name_en as title')->find($area_id)['title'];
        }else{
            $area = GovernorateAreas::select('name_ar as title')->find($area_id)['title'];
        }
        $address['area'] = $area;
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $address , $request->lang);
        return response()->json($response , 200);
    }


}