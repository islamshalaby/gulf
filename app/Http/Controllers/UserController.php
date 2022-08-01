<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\APIHelpers;
use App\UserNotification;
use App\Notification;
use App\AdProduct;
use App\AdProductImage;
use App\Setting;
use App\Favorite;
use App\Category;
use App\SubCategory;
use App\SubTwoCategory;
use App\CategoryOption;
use App\CategoryOptionValue;
use App\AdProductOption;
use App\Area;
use App\Country;
use App\Currency;
use App\Comment;
use App\Governorate;
use App\SubFourCarType;
use App\SubFourCategory;
use App\SubThreeCategory;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;



class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' , ['except' => ['resetforgettenpassword' , 'checkphoneexistance' , 'getownerprofile', 'getuserads']]);
    }

    public function getprofile(Request $request){
        $user = auth()->user();
        $returned_user['user_name'] = $user['name'];
        $returned_user['phone'] = $user['phone'];
        $returned_user['email'] = $user['email'];
        $returned_user['image'] = $user['image'];
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $returned_user , $request->lang);
        return response()->json($response , 200);  
    }

    public function updateprofile(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            "email" => 'required',
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }

        $currentuser = auth()->user();
        $user_by_phone = User::where('phone' , '!=' , $currentuser->phone )->where('phone', $request->phone)->first();
        if($user_by_phone){
            $response = APIHelpers::createApiResponse(true , 409 , 'Phone Exists Before' , 'رقم الهاتف موجود من قبل' , null , $request->lang);
            return response()->json($response , 409);
        }

        $user_by_email = User::where('email' , '!=' ,$currentuser->email)->where('email' , $request->email)->first();
        if($user_by_email){
            $response = APIHelpers::createApiResponse(true , 409 , 'Email Exists Before' , 'البريد الإلكتروني موجود من قبل' , null , $request->lang);
            return response()->json($response , 409); 
        }

        User::where('id' , $currentuser->id)->update([
            'name' => $request->name , 
            'phone' => $request->phone , 
            'email' => $request->email  ]);

        $newuser = User::find($currentuser->id);
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $newuser , $request->lang);
        return response()->json($response , 200);    
    }


    public function resetpassword(Request $request){
        $validator = Validator::make($request->all() , [
            'password' => 'required',
			"old_password" => 'required'
        ]);

        if($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }

        $user = auth()->user();
		if(!Hash::check($request->old_password, $user->password)){
			$response = APIHelpers::createApiResponse(true , 406 , 'Wrong old password' , 'كلمه المرور السابقه خطأ' , null , $request->lang);
            return response()->json($response , 406);
		}
		if($request->old_password == $request->password){
			$response = APIHelpers::createApiResponse(true , 406 , 'You cannot set the same previous password' , 'لا يمكنك تعيين نفس كلمه المرور السابقه' , null , $request->lang);
            return response()->json($response , 406);
		}
        User::where('id' , $user->id)->update(['password' => Hash::make($request->password)]);
        $newuser = User::find($user->id);
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $newuser , $request->lang);
        return response()->json($response , 200);
    }

    public function resetforgettenpassword(Request $request){
        $validator = Validator::make($request->all() , [
            'password' => 'required',
            'email' => 'required'
        ]);

        if($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }

        $user = User::where('email', $request->email)->first();
        if(! $user){
            $response = APIHelpers::createApiResponse(true , 403 , 'email Not Exists Before' , 'البريد الالكترونى غير موجود' , null , $request->lang);
            return response()->json($response , 403);
        }

        User::where('email' , $user->email)->update(['password' => Hash::make($request->password)]);
        $newuser = User::where('email' , $user->email)->first();
		
		$token = auth()->login($newuser);
        $newuser->token = $this->respondWithToken($token);
		
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $newuser , $request->lang);
        return response()->json($response , 200);
    }

    

    // check if phone exists before or not
    // public function checkphoneexistance(Request $request)
    // {
    //     $validator = Validator::make($request->all() , [
    //         'phone' => 'required'
    //     ]);

    //     if($validator->fails()) {
    //         $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'حقل الهاتف اجباري' , null , $request->lang);
    //         return response()->json($response , 406);
    //     }
        
    //     $user = User::where('phone' , $request->phone)->first();
    //     if($user){
    //         $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $user , $request->lang);
    //         return response()->json($response , 200);
    //     }

    //     $response = APIHelpers::createApiResponse(true , 403 , 'Phone Not Exists Before' , 'الهاتف غير موجود من قبل' , null , $request->lang);
    //     return response()->json($response , 403);

    // }

        // check if phone exists before or not
        public function checkphoneexistance(Request $request)
        {
            $validator = Validator::make($request->all() , [
                'phone' => 'required'
            ]);
    
            if($validator->fails()) {
                $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'حقل الهاتف اجباري' , null , $request->lang);
                return response()->json($response , 406);
            }
            
            $user = User::where('phone' , $request->phone)->first();
            if($user){
                
            if($request->email){
                $user_email = User::where('email' , $request->email)->first();
            if($user_email){
                $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $user_email , $request->lang);
                $response['phone'] = true;
                $response['email'] = true;
                return response()->json($response , 200);
            }else{
                $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $user , $request->lang);
                $response['phone'] = true;
                $response['email'] = false;
                return response()->json($response , 200);
            }
                
            }
            $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $user , $request->lang);
            $response['phone'] = true;
            $response['email'] = false;
                
                return response()->json($response , 200);
            }
            if($request->email){
                $user_email = User::where('email' , $request->email)->first();
            if($user_email){
                $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $user_email , $request->lang);
                $response['phone'] = false;
                $response['email'] = true;
                return response()->json($response , 200);
            }
                
            }
    
            $response = APIHelpers::createApiResponse(true , 403 , 'Phone and Email Not Exists Before' , 'الهاتف و البريد غير موجودين من قبل' , null , $request->lang);
            $response['phone'] = false;
            $response['email'] = false;
            
            return response()->json($response , 403);
    
        }

 
    // get notifications
    public function notifications(Request $request){
        $user = auth()->user();
        if($user->active == 0){
            $response = APIHelpers::createApiResponse(true , 406 , 'Your Account Blocked By Admin' , 'تم حظر حسابك من الادمن' , null , $request->lang);
            return response()->json($response , 406);
        }

        $user_id = $user->id;
        $notifications_ids = UserNotification::where('user_id' , $user_id)->orderBy('id' , 'desc')->select('id', 'notification_id', 'seen')->get();
        $notifications = [];
        for($i = 0; $i < count($notifications_ids); $i++){
            $notifications[$i] = Notification::select('id','title' , 'body' ,'image' , 'created_at')->find($notifications_ids[$i]['notification_id']);
            $notifications_ids[$i]['seen'] = 1;
            $notifications_ids[$i]->save();
        }
        $data['notifications'] = $notifications;
        $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' ,$data['notifications'] , $request->lang);
        return response()->json($response , 200);  
    }
	
	    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 432000
        ];
    }

     // get ads count
     public function getadscount(Request $request){
        $user = auth()->user();
        $returned_user['email'] = $user->email;
        $returned_user['free_ads_count'] = $user->free_ads_count;
        $returned_user['paid_ads_count'] = $user->paid_ads_count;
        $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' , $returned_user , $request->lang );
        return response()->json($response , 200); 
    }
	


    // get current ads
    public function getcurrentads(Request $request){
        $country = Country::where('id', $request->country)->select('id', 'currency')->first();
        $fromCurr = trim(strtolower($country['currency']));
        $toCurr = trim(strtolower($request->curr));
        if ($fromCurr == $toCurr) {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', $fromCurr)->where('to', $toCurr)->first();
        }
        $user = auth()->user();
        if($user->active == 0){
            $response = APIHelpers::createApiResponse(true , 406 ,  'تم حظر حسابك من الادمن' ,  'تم حظر حسابك من الادمن' , null , $request->lang );
            return response()->json($response , 406);
        }

        $user = auth()->user();

        $products = AdProduct::where('deleted', 0)->where('country_id', $country['id'])->where('user_id' , $user->id)->where('status' , 1)->orderBy('publication_date' , 'DESC')->select('id' , 'title' , 'price' , 'publication_date as date', 'selected as feature', 'year' )->simplePaginate(12);
        for($i =0 ; $i < count($products); $i++){
            $prodImage = AdProductImage::where('product_id' , $products[$i]['id'])->select('image')->first();
            if ($prodImage) {
                $products[$i]['image'] = $prodImage['image'];
            }else {
                $products[$i]['image'] = "";
            }
            $favorite = Favorite::where('user_id' , $user->id)->where('product_id' , $products[$i]['id'])->where('product_type' , 2)->first();
            if($favorite){
                $products[$i]['favorite'] = true;
            }else{
                $products[$i]['favorite'] = false;
            }
            $date = date_create($products[$i]['date']);
            $pro = $products[$i]['price'] * $currency['value'];
            $products[$i]['price'] = number_format((float)$pro, 3, '.', '');
            $products[$i]['date'] = date_format($date , 'd M Y');
        }
        $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' , $products , $request->lang );
        return response()->json($response , 200); 
    }

    // get user ads
    public function getuserads(Request $request){
        $country = Country::where('id', $request->country)->select('id', 'currency')->first();
        $fromCurr = trim(strtolower($country['currency']));
        $toCurr = trim(strtolower($request->curr));
        if ($fromCurr == $toCurr) {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', $fromCurr)->where('to', $toCurr)->first();
        }
        $user = $request->id;
        $adUser = User::find($user);

        $products = AdProduct::where('deleted', 0)->where('country_id', $country['id'])->where('user_id' , $user)->where('status' , 1)->orderBy('id' , 'DESC')->select('id' , 'title' , 'price' , 'publication_date as date', 'selected as feature', 'year' )->simplePaginate(12);
        $data['username'] = $adUser['name'];
        $data['email'] = $adUser['email'];
        $data['image'] = $adUser['image'];
        $data['phone'] = $adUser['phone'];
        
        if (count($products) > 0) {
            for($i =0 ; $i < count($products); $i++){
                $prodImage = AdProductImage::where('product_id' , $products[$i]['id'])->select('image')->first();
                if ($prodImage) {
                    $products[$i]['image'] = $prodImage['image'];
                }else {
                    $products[$i]['image'] = "";
                }
                $favorite = Favorite::where('user_id' , $user)->where('product_id' , $products[$i]['id'])->where('product_type' , 2)->first();
                if($favorite){
                    $products[$i]['favorite'] = true;
                }else{
                    $products[$i]['favorite'] = false;
                }
                $date = date_create($products[$i]['date']);
                $pro = $products[$i]['price'] * $currency['value'];
                $products[$i]['price'] = number_format((float)$pro, 3, '.', '');
                $products[$i]['date'] = date_format($date , 'd M Y');
                
                $data['products'] = $products;
            }
        }else {
            $data['products'] = $products;
        }
        
        
        $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' , $data , $request->lang );
        return response()->json($response , 200); 
    }

    // get history date
    public function getexpiredads(Request $request){
        $user = auth()->user();
        if($user->active == 0){
            $response = APIHelpers::createApiResponse(true , 406 ,  'تم حظر حسابك من الادمن' ,  'تم حظر حسابك من الادمن' , null , $request->lang );
            return response()->json($response , 406);
        }

        $user = auth()->user();

        $products = AdProduct::where('deleted', 0)->where('user_id' , $user->id)->where('status' , 2)->orderBy('publication_date' , 'DESC')->select('id' , 'title' , 'price' , 'publication_date as date', 'selected as feature', 'year' )->simplePaginate(12);
        for($i =0 ; $i < count($products); $i++){
            $products[$i]['price'] = number_format((float)$products[$i]['price'], 3, '.', '');
            $products[$i]['image'] = AdProductImage::where('product_id' , $products[$i]['id'])->select('image')->first()['image'];
            $favorite = Favorite::where('user_id' , $user->id)->where('product_id' , $products[$i]['id'])->where('product_type' , 2)->first();
            if($favorite){
                $products[$i]['favorite'] = true;
            }else{
                $products[$i]['favorite'] = false;
            }
            $date = date_create($products[$i]['date']);
            $products[$i]['date'] = date_format($date , 'd M Y');
        }
        $response = APIHelpers::createApiResponse(false , 200 ,  '' , '', $products , $request->lang );
        return response()->json($response , 200); 
    }

    public function renewad(Request $request){
        $user = auth()->user();
        if($user->active == 0){
            $response = APIHelpers::createApiResponse(true , 406 ,  'تم حظر حسابك' ,  'تم حظر حسابك' , null , $request->lang );
            return response()->json($response , 406);
        }

        $validator = Validator::make($request->all() , [
            'product_id' => 'required',
        ]);

        if($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 ,  'بعض الحقول مفقودة' , 'بعض الحقول مفقودة' , null , $request->lang );
            return response()->json($response , 406);
        }

        $product = AdProduct::where('id' , $request->product_id)->where('user_id' , $user->id)->first();

        if($product){
            if ($product->type == 1) {
                if($user->free_ads_count == 0 && $user->paid_ads_count == 0){
                    $response = APIHelpers::createApiResponse(true , 406 ,  'ليس لديك رصيد إعلانات لإضافه إعلان جديد يرجي شراء باقه إعلانات' ,  'ليس لديك رصيد إعلانات لإضافه إعلان جديد يرجي شراء باقه إعلانات' , null , $request->lang );
                    return response()->json($response , 406); 
                }
                if($user->free_ads_count > 0){
                    $count = $user->free_ads_count;
                    $user->free_ads_count = $count - 1;
                }else{
                    $count = $user->paid_ads_count;
                    $user->paid_ads_count = $count - 1;
                }
            }else {
                if(($user->free_ads_count <= 1 && $user->paid_ads_count <= 0) || ($user->free_ads_count <= 0 && $user->paid_ads_count <= 1)){
                    $response = APIHelpers::createApiResponse(true , 406 ,  'ليس لديك رصيد إعلانات لإضافه إعلان جديد يرجي شراء باقه إعلانات' ,  'ليس لديك رصيد إعلانات لإضافه إعلان جديد يرجي شراء باقه إعلانات' , null , $request->lang );
                    return response()->json($response , 406); 
                }
                if($user->free_ads_count >= 2){
                    $count = $user->free_ads_count;
                    $user->free_ads_count = $count - 2;
                }else{
                    $count = $user->paid_ads_count;
                    $user->paid_ads_count = $count - 2;
                }
                $post['selected'] = 1;
            }
    
            $user->save();
			$ad_period = Setting::find(1)['ad_period'];
            $product->publication_date = date("Y-m-d H:i:s");
			$product->expiry_date = date('Y-m-d H:i:s', strtotime('+'.$ad_period.' days'));
            $product->price = number_format((float)$product->price, 3, '.', '');
            $product->status = 1;
            $product->save();

            $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' , $product , $request->lang );
            return response()->json($response , 200); 

        }else{

            $response = APIHelpers::createApiResponse(true , 406 ,  'ليس لديك الصلاحيه لتجديد هذا الاعلان' , 'ليس لديك الصلاحيه لتجديد هذا الاعلان' , null , $request->lang );
            return response()->json($response , 406);

        }

    }

    public function deletead(Request $request){
        $user = auth()->user();
        if($user->active == 0){
            $response = APIHelpers::createApiResponse(true , 406 ,  'تم حظر حسابك' , 'تم حظر حسابك' , null , $request->lang );
            return response()->json($response , 406);
        }

        $validator = Validator::make($request->all() , [
            'product_id' => 'required',
        ]);

        if($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 ,  'بعض الحقول مفقودة' , 'بعض الحقول مفقودة'  , null , $request->lang );
            return response()->json($response , 406);
        }

        $product = AdProduct::where('id' , $request->product_id)->where('user_id' , $user->id)->first();

        if($product){
            $product->options()->delete();
            $product->images()->delete();
            $product->delete();
            $response = APIHelpers::createApiResponse(false , 200 ,  '', '' , null , $request->lang );
            return response()->json($response , 200); 
        }else{
            $response = APIHelpers::createApiResponse(true , 406 ,  'ليس لديك الصلاحيه لحذف هذا الاعلان' , 'ليس لديك الصلاحيه لحذف هذا الاعلان' , null , $request->lang );
            return response()->json($response , 406);
        }

    }

    public function updateAd(Request $request){
        $user = auth()->user();
        if($user->active == 0){
            $response = APIHelpers::createApiResponse(true , 406 ,  'تم حظر حسابك' , 'تم حظر حسابك' , null , $request->lang );
            return response()->json($response , 406);
        }

        $validator = Validator::make($request->all() , [
            'product_id' => 'required'
        ]);

        if($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 ,  'بعض الحقول مفقودة' , 'بعض الحقول مفقودة' , null , $request->lang );
            return response()->json($response , 406);
        }

        $product = AdProduct::where('id' , $request->product_id)->where('user_id' , $user->id)->first();
        if($product){
            $postProduct = $request->except(['images', 'options', 'values']);

            $product->update($postProduct);

            if($request->images && count($request->images) > 0){
                for ($i = 0; $i < count($request->images); $i ++) {
                    $image = $request->images[$i];
                    Cloudder::upload("data:image/jpeg;base64,".$image, null);
                    $imagereturned = Cloudder::getResult();
                    $image_id = $imagereturned['public_id'];
                    $image_format = $imagereturned['format'];    
                    $image_new_name = $image_id.'.'.$image_format;
                    AdProductImage::create(['product_id' => $request->product_id, 'image' => $image_new_name]);
                }
            }

            if (isset($request->options) && count($request->options) > 0) {
                $product->options()->delete();
                for ($k = 0; $k < count($request->options); $k ++) {
                    $categoryOption = CategoryOption::where('id', $request->options[$k])->first();
                    $type = 1;
                    $val_en = "";
                    $val_ar = "";
                    if (count($categoryOption->values) > 0) {
                        $categoryOptionValue = CategoryOptionValue::where('id', $request->values[$k])->first();
                        $val_en = $categoryOptionValue['value_en'];
                        $val_ar = $categoryOptionValue['value_ar'];
                    }else {
                        $type = 2;
                    }
                    AdProductOption::create([
                        'option_id' => $request->options[$k],
                        'option_en' => $categoryOption['title_en'],
                        'option_ar' => $categoryOption['title_ar'],
                        'value' => $request->values[$k],
                        'val_en' => $val_en,
                        'val_ar' => $val_ar,
                        'type' => $type,
                        'product_id' => $product->id
                    ]);
                }
            }
            

            $response = APIHelpers::createApiResponse(false , 200 ,  '' , '', $product , $request->lang );
            return response()->json($response , 200); 
        }else{
            $response = APIHelpers::createApiResponse(true , 406 ,  'ليس لديك الصلاحيه لتعديل هذا الاعلان', 'ليس لديك الصلاحيه لتعديل هذا الاعلان'  , null , $request->lang);
            return response()->json($response , 406);
        }       

    }

    public function delteadimage(Request $request){
        $user = auth()->user();
        if($user->active == 0){
            $response = APIHelpers::createApiResponse(true , 406 ,  'تم حظر حسابك' , 'تم حظر حسابك' , null , $request->lang);
            return response()->json($response , 406);
        }

        $validator = Validator::make($request->all() , [
            'image_id' => 'required'
        ]);

        if($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 ,  'بعض الحقول مفقودة' , 'بعض الحقول مفقودة' , null , $request->lang );
            return response()->json($response , 406);
        }

        $image = AdProductImage::find($request->image_id);
        
        if ($user->id != $image->product->user_id) {
            $response = APIHelpers::createApiResponse(true , 406 ,  'ليس لديك الصلاحيه لمسح هذه الصورة' , 'ليس لديك الصلاحيه لمسح هذه الصورة' , null , $request->lang );
            return response()->json($response , 406);
        }
        if($image){
            $theimage = $image['image'];
            $publicId = substr($theimage, 0 ,strrpos($theimage, "."));    
            Cloudder::delete($publicId);
            $image->delete();
            $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' , null , $request->lang);
            return response()->json($response , 200);

        }else{
            $response = APIHelpers::createApiResponse(true , 406 ,  'Invalid Image Id' , 'Invalid Image Id' , null , $request->lang );
            return response()->json($response , 406);
        }

    }
    

    public function getaddetails(Request $request){
        $ad_id = $request->id;
        $ad = AdProduct::select('id' , 'title' , 'description' , 'price'  , 'category_id' , 'sub_category_id' , 'sub_category_two_id', 'sub_category_three_id', 'sub_category_four_id', 'country_id', 'governorate_id', 'governorate_area_id', 'user_id', 'year')->find($ad_id);
        $ad['price'] = number_format((float)$ad['price'], 3, '.', '');
        $adOptions = AdProductOption::where('product_id', $ad['id'])->pluck('value')->toArray();
        $subCategory = [];
        $subTwoCategory = [];
        $subThreeCategory = [];
        $subFourCategory = [];
        $catsArray = [$ad['category_id'], $ad['sub_category_id'], $ad['sub_category_two_id'], $ad['sub_category_three_id'], $ad['sub_category_four_id']];
        if ($request->lang == 'en') {
            $country = Country::where('id', $ad->country_id)->select('id', 'name_en as name')->first();
            $governorate = Governorate::where('id', $ad->governorate_id)->select('id', 'name_en as name')->first();
            
            $categoryOptions = CategoryOption::whereIn('category_id', $catsArray)->where('deleted', 0)->select('id as option_id', 'title_en as title')->get();
            if (count($categoryOptions) > 0) {
                for ($i =0; $i < count($categoryOptions); $i ++) {
                    $categoryOptions[$i]['type'] = 'input';
                    $optionValues = CategoryOptionValue::where('option_id', $categoryOptions[$i]['option_id'])->select('id as value_id', 'value_en as value')->get();
                    if (count($optionValues) > 0) {
                        $categoryOptions[$i]['type'] = 'select';
                        $categoryOptions[$i]['values'] = $optionValues;
                        for ($r = 0; $r < count($categoryOptions[$i]['values']); $r ++) {
                            $categoryOptions[$i]['values'][$r]['selected'] = false;
                            if (in_array($categoryOptions[$i]['values'][$r]['value_id'], $adOptions)) {
                                $categoryOptions[$i]['values'][$r]['selected'] = true;
                            }
                        }
                        
                    }else {
                        $catOptionVal = AdProductOption::where('product_id', $ad['id'])->where('option_id', $categoryOptions[$i]['option_id'])->select('value')->first();
                        if ($catOptionVal) {
                            $categoryOptions[$i]['value'] = $catOptionVal['value'];
                        }else {
                            $categoryOptions[$i]['value'] = "";
                        }
                        // AdProductOption::where('product_id', $ad['id'])->where('option_id', $categoryOptions[$i]['option_id'])->select('value')->first()['value'];
                    }
                }
            }
            $category = Category::where('deleted', 0)->where('type', 2)->select('id', 'title_en as title')->get();
            $subCategory = SubCategory::where('category_id', $ad['category_id'])->select('id', 'title_en as title')->get();
            $subTwoCategory = SubTwoCategory::where('sub_category_id', $ad['sub_category_id'])->select('id', 'title_en as title')->get();
            if(!empty($ad['sub_category_two_id'])) {
                $subThreeCategory = SubThreeCategory::where('sub_category_id', $ad['sub_category_two_id'])->select('id', 'title_en as title')->get();
            }
            if(!empty($ad['sub_category_three_id'])) {
                $subFourCategory = SubFourCategory::where('sub_category_id', $ad['sub_category_three_id'])->select('id', 'title_en as title')->get();
            }
        }else {
            $country = Country::where('id', $ad->country_id)->select('id', 'name_ar as name')->first();
            $governorate = Governorate::where('id', $ad->governorate_id)->select('id', 'name_ar as name')->first();
            $categoryOptions = CategoryOption::where('category_id', $ad['category_id'])->where('deleted', 0)->select('id as option_id', 'title_ar as title')->get();
            if (count($categoryOptions) > 0) {
                for ($i =0; $i < count($categoryOptions); $i ++) {
                    $categoryOptions[$i]['type'] = 'input';
                    $optionValues = CategoryOptionValue::where('option_id', $categoryOptions[$i]['option_id'])->select('id as value_id', 'value_en as value')->get();
                    if (count($optionValues) > 0) {
                        $categoryOptions[$i]['type'] = 'select';
                        $categoryOptions[$i]['values'] = $optionValues;
                        for ($r = 0; $r < count($categoryOptions[$i]['values']); $r ++) {
                            $categoryOptions[$i]['values'][$r]['selected'] = false;
                            if (in_array($categoryOptions[$i]['values'][$r]['value_id'], $adOptions)) {
                                $categoryOptions[$i]['values'][$r]['selected'] = true;
                            }
                        }
                        
                    }else {
                        $catOptionVal = AdProductOption::where('product_id', $ad['id'])->where('option_id', $categoryOptions[$i]['option_id'])->select('value')->first();
                        if ($catOptionVal) {
                            $categoryOptions[$i]['value'] = $catOptionVal['value'];
                        }else {
                            $categoryOptions[$i]['value'] = "";
                        }
                        // AdProductOption::where('product_id', $ad['id'])->where('option_id', $categoryOptions[$i]['option_id'])->select('value')->first()['value'];
                    }
                }
            }
            $category = Category::where('deleted', 0)->where('type', 2)->select('id', 'title_ar as title')->get();
            $subCategory = SubCategory::where('category_id', $ad['category_id'])->select('id', 'title_ar as title', 'category_id')->get()->makeHidden('category_id');
            $subTwoCategory = SubTwoCategory::where('sub_category_id', $ad['sub_category_id'])->select('id', 'title_ar as title', 'sub_category_id')->get()->makeHidden('sub_category_id');
            if(!empty($ad['sub_category_two_id'])) {
                $subThreeCategory = SubThreeCategory::where('sub_category_id', $ad['sub_category_two_id'])->select('id', 'title_ar as title')->get();
            }
            if(!empty($ad['sub_category_three_id'])) {
                $subFourCategory = SubFourCategory::where('sub_category_id', $ad['sub_category_three_id'])->select('id', 'title_ar as title')->get();
            }
        }
        
        for ($i = 0; $i < count($category); $i ++) {
            $category[$i]['selected'] = false;
            if ($category[$i]['id'] == $ad['category_id']) {
                $category[$i]['selected'] = true;
            }
        }
        for ($n = 0; $n < count($subCategory); $n ++) {
            $subCategory[$n]['selected'] = false;
            if (!empty($ad['sub_category_id']) && $subCategory[$n]['id'] == $ad['sub_category_id']) {
                $subCategory[$n]['selected'] = true;
            }
        }
        for ($k = 0; $k < count($subTwoCategory); $k ++) {
            $subTwoCategory[$k]['selected'] = false;
            if (!empty($ad['sub_category_two_id']) && $subTwoCategory[$k]['id'] == $ad['sub_category_two_id']) {
                $subTwoCategory[$k]['selected'] = true;
            }
        }
        if (isset($subThreeCategory) && count($subThreeCategory) > 0) {
            for ($m = 0; $m < count($subThreeCategory); $m ++) {
                $subThreeCategory[$m]['selected'] = false;
                if (!empty($ad['sub_category_three_id']) && $subThreeCategory[$m]['id'] == $ad['sub_category_three_id']) {
                    $subThreeCategory[$m]['selected'] = true;
                }
            }
        }
        if (isset($subFourCategory) && count($subFourCategory) > 0) {
            for ($m = 0; $m < count($subFourCategory); $m ++) {
                $subFourCategory[$m]['selected'] = false;
                if (!empty($ad['sub_category_four_id']) && $subFourCategory[$m]['id'] == $ad['sub_category_four_id']) {
                    $subFourCategory[$m]['selected'] = true;
                }
            }
        }
        $images = AdProductImage::where('product_id' , $ad_id)->select('id' , 'image')->get()->toArray();
        $ad['categories'] = $category;
        $ad['sub_categories'] = $subCategory;
        $ad['sub_two_categories'] = $subTwoCategory;
        $ad['sub_three_categories'] = $subThreeCategory;
        $ad['sub_four_categories'] = $subFourCategory;
        $ad['options'] = $categoryOptions;
        $ad['images'] = $images;
        $ad['country'] = $country;
        $ad['governorate'] = $governorate;

        $response = APIHelpers::createApiResponse(false , 200 , '' ,  '' ,$ad , $request->lang );
        return response()->json($response , 200); 
    }
    
    public function getownerprofile(Request $request){
        $user_id = $request->id;
        $data['user'] = User::select('id' , 'name' , 'phone' , 'email' , 'created_at')->find($user_id);
        $products = AdProduct::where('status' , 1)->where('user_id' , $user_id)->orderBy('publication_date' , 'DESC')->select('id' , 'title' , 'price' , 'publication_date as date')->get();
        for($i =0; $i < count($products); $i++){
            $products[$i]['image'] = AdProductImage::where('product_id' , $products[$i]['id'])->first()['image'];
            $date = date_create($products[$i]['date']);
            $products[$i]['date'] = date_format($date , 'd M Y');

            $user = auth()->user();
            if($user){
                $favorite = Favorite::where('user_id' , $user->id)->where('product_id' , $products[$i]['id'])->where('product_type' , 2)->first();
                if($favorite){
                    $products[$i]['favorite'] = true;
                }else{
                    $products[$i]['favorite'] = false;
                }
            }else{
                $products[$i]['favorite'] = false;
            }

        }
        $data['products'] = $products;
        $data['count'] = count($products);
        $date = date_create($data['user']['created_at']);
		
        $data['from'] = date_format($date , 'Y');

        $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' ,$data , $request->lang );
        return response()->json($response , 200);        
    }

    // feature ad
    public function featureAd(Request $request) {
        $user = auth()->user();
        if($user->active == 0){
            $response = APIHelpers::createApiResponse(true , 406 ,  'تم حظر حسابك' , 'تم حظر حسابك' , null , $request->lang );
            return response()->json($response , 406);
        }

        $validator = Validator::make($request->all() , [
            'product_id' => 'required'
        ]);

        if($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 ,  'بعض الحقول مفقودة' , 'بعض الحقول مفقودة' , null , $request->lang );
            return response()->json($response , 406);
        }

        $product = AdProduct::where('id', $request->product_id)->where('user_id', $user->id)->select('id', 'selected')->first();
        if (! isset($product['id'])) {
            $response = APIHelpers::createApiResponse(true , 406 ,  'هذا المستخدم ليس له الاذن او هذا المنتج غير موجود' , 'هذا المستخدم ليس له الاذن او هذا المنتج غير موجود' , null , $request->lang );
            return response()->json($response , 406);
        }
        if ($product['selected'] == 1) {
            $response = APIHelpers::createApiResponse(true , 406 ,  'هذا المنتج مميز بالفعل' , 'هذا المنتج مميز بالفعل' , null , $request->lang );
            return response()->json($response , 406);
        }
        if(($user->free_ads_count <= 1 && $user->paid_ads_count <= 0) || ($user->free_ads_count <= 0 && $user->paid_ads_count <= 1)){
            $response = APIHelpers::createApiResponse(true , 406 ,  'ليس لديك رصيد إعلانات لإضافه إعلان جديد يرجي شراء باقه إعلانات' ,  'ليس لديك رصيد إعلانات لإضافه إعلان جديد يرجي شراء باقه إعلانات' , null , $request->lang );
            return response()->json($response , 406); 
        }
        if($user->free_ads_count >= 2){
            $count = $user->free_ads_count;
            $user->free_ads_count = $count - 2;
        }else if($user->free_ads_count < 2 && $user->free_ads_count != 0 && $user->paid_ads_count >= 1){
            $count = $user->free_ads_count;
            $user->free_ads_count = $count - 1;
            $user->paid_ads_count = $user->paid_ads_count - 1;
        }else{
            $count = $user->paid_ads_count;
            $user->paid_ads_count = $count - 2;
        }
        $user->save();
        $product->update(['selected' => 1]);

        $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' ,'' , $request->lang );
        return response()->json($response , 200);
    }

    // add comment
    public function addComment(Request $request) {
        $user = auth()->user();
        $validator = Validator::make($request->all() , [
            'product_id' => 'required',
            'content' => 'required'
        ]);

        if($validator->fails() && !$user->id) {
            $response = APIHelpers::createApiResponse(true , 406 ,  'بعض الحقول مفقودة' , 'بعض الحقول مفقودة' , null , $request->lang );
            return response()->json($response , 406);
        }
        
        $post = $request->all();
        $post['user_id'] = $user->id;

        Comment::create($post);

        $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' ,'' , $request->lang );
        return response()->json($response , 200);
    }

    // upload profile image
    public function uploadProfileIamge(Request $request) {
        $validator = Validator::make($request->all(), [
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }
        $user = User::where('id', auth()->user()->id)->select('id', 'image')->first();

        $image = $request->image;
        $oldImage = $user->image;
        if (!empty($oldImage)) {
            $publicId = substr($image, 0 ,strrpos($oldImage, "."));  
            Cloudder::delete($publicId);
        }
        Cloudder::upload("data:image/jpeg;base64,".$image, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;

        $user->image = $image_new_name;

        $user->save();

        $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' ,'' , $request->lang );
        return response()->json($response , 200);
    }

    public function getUnreadNotificationsNumber(Request $request) {
        $user = auth()->user();
        $data['count'] = UserNotification::where('seen', 0)->where('user_id' , $user->id)->count('id');
        
        $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' ,$data , $request->lang );
        return response()->json($response , 200);
    }


}
