<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserAddress;
use App\Area;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\APIHelpers;


class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' , ['except' => ['getdeliveryprice' , 'getareas']]);
    }

    public function getaddress(Request $request){
        $user = auth()->user();
        $address = UserAddress::where('user_id' , $user->id)->orderBy('id' , 'desc')->get();

        for($i = 0; $i < count($address); $i++){
            if($request->lang == 'en'){
				$address[$i]['area_name'] = Area::find($address[$i]['area_id'])['title_en'];
			}else{
				$address[$i]['area_name'] = Area::find($address[$i]['area_id'])['title_ar'];
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
            'floor' => 'required',
            'apartment_number' => 'required',
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
        $address->floor = $request->floor;
        $address->apartment_number = $request->apartment_number;
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
                $address->delete();

                $addresses = UserAddress::where('user_id' , $user_id)->get();

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
        if($request->lang == 'en'){
            $areas = Area::where('deleted' , 0)->select('id', 'title_en as title')->get();
        }else{
            $areas = Area::where('deleted' , 0)->select('id' , 'title_ar as title')->get();
        }
        
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
            $area = Area::select('title_en as title')->find($area_id)['title'];
        }else{
            $area = Area::select('title_ar as title')->find($area_id)['title'];
        }
        $address['area'] = $area;
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $address , $request->lang);
        return response()->json($response , 200);
    }


}