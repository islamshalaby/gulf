<?php

namespace App\Http\Controllers;

use App\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\APIHelpers;
use App\User;
use App\Favorite;
use App\Ad;
use App\AdProduct;
use App\AdProductImage;
use App\Setting;
use App\Category;
use App\Country;
use App\Governorate;
use App\GovernorateAreas;
use App\AdProductOption;
use App\Currency;
use App\SubFourCategory;
use App\SubThreeCategory;
use App\SubCategory;
use App\SubTwoCategory;
use App\Comment;
use App\CategoryOption;
use App\CategoryOptionValue;
use App\Option;
use App\OptionValue;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;

class AdProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' , ['except' => ['getdetails', 'getComments' , 'getproducts', 'getCountries', 'getGovernorates', 'getAreas', 'adSearch', 'adFilter', 'getMaxMinPrice' ]]);
    }

    // get countries
    public function getCountries(Request $request) {
        if ($request->lang == 'en') {
            $data = Country::where('deleted', 0)->select('id', 'name_en as name', 'flag')->get();
        }else {
            $data = Country::where('deleted', 0)->select('id', 'name_ar as name', 'flag')->get();
        }

        $response = APIHelpers::createApiResponse(false , 200 ,'' ,   '' , $data , $request->lang );
        return response()->json($response , 200);
    }

    // get governorates
    public function getGovernorates(Request $request, Country $country) {
        if ($request->lang == 'en') {
            $data = Governorate::where('deleted', 0)->where('country_id', $country->id)->select('id', 'name_en as name')->get();
        }else {
            $data = Governorate::where('deleted', 0)->where('country_id', $country->id)->select('id', 'name_ar as name')->get();
        }

        $response = APIHelpers::createApiResponse(false , 200 ,'' ,   '' , $data , $request->lang );
        return response()->json($response , 200);
    }

    // get areas
    public function getAreas(Request $request, Governorate $governorate) {
        if ($request->lang == 'en') {
            $data = GovernorateAreas::where('deleted', 0)->where('governorate_id', $governorate->id)->select('id', 'name_en as name')->get();
        }else {
            $data = GovernorateAreas::where('deleted', 0)->where('governorate_id', $governorate->id)->select('id', 'name_ar as name')->get();
        }

        $response = APIHelpers::createApiResponse(false , 200 ,'' ,   '' , $data , $request->lang );
        return response()->json($response , 200);
    }

    public function create(Request $request){
        $user = auth()->user();

        if($user->active == 0){
            $response = APIHelpers::createApiResponse(true , 406 ,  'تم حظر حسابك' ,  'تم حظر حسابك' , null , $request->lang );
            return response()->json($response , 406);
        }

        $validator = Validator::make($request->all() , [
            'country_id' => 'required',
            'governorate_id' => 'required',
            'governorate_area_id' => 'required',
            'category_id' => 'required',
            // 'sub_category_id' => "required",
            // "sub_category_two_id" => "required",
            "title" => "required",
            "description" => "required",
            "price" => "required",
            "images" => "required",
            // "year" => "required",
            // "values" => "required",
            "type" => "required"    // 1 => normal ad (- 1 ad)
                                    // 2 => pin ad (- 3 ad)
                                    // 3 => feature ad (- 10 ad)
        ]);

        if($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 ,  'بعض الحقول مفقودة'  ,  'بعض الحقول مفقودة' , null , $request->lang );
            return response()->json($response , 406);
        }

        $ad_period = Setting::find(1)['ad_period'];

        $post = $request->except(['images', 'options', 'values']);
        $setting = Setting::where('id', 1)->select('feature_ad_period', 'pin_ad_period')->first();
        if ($request->type == 1) {
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
        }else if ($request->type == 2) {
            if($user->free_ads_count == 0 && $user->paid_ads_count == 0){
                $response = APIHelpers::createApiResponse(true , 406 ,  'ليس لديك رصيد إعلانات لإضافه إعلان جديد يرجي شراء باقه إعلانات' ,  'ليس لديك رصيد إعلانات لإضافه إعلان جديد يرجي شراء باقه إعلانات' , null , $request->lang );
                return response()->json($response , 406);
            }
            if($user->free_ads_count > 0){
                $count = $user->free_ads_count;
                $user->free_ads_count = $count - 3;
            }else{
                $count = $user->paid_ads_count;
                $user->paid_ads_count = $count - 3;
            }
            $post['pin'] = 1;
            $post['expire_pin_date'] = Date('Y-m-d H:i:s', strtotime('+'.$setting->pin_ad_period.' days'));
        }else {
            if(($user->free_ads_count <= 10 && $user->paid_ads_count <= 0) || ($user->free_ads_count <= 0 && $user->paid_ads_count <= 10)){
                $response = APIHelpers::createApiResponse(true , 406 ,  'ليس لديك رصيد إعلانات لإضافه إعلان جديد يرجي شراء باقه إعلانات' ,  'ليس لديك رصيد إعلانات لإضافه إعلان جديد يرجي شراء باقه إعلانات' , null , $request->lang );
                return response()->json($response , 406);
            }
            if($user->free_ads_count >= 10){
                $count = $user->free_ads_count;
                $user->free_ads_count = $count - 10;
            }else{
                $count = $user->paid_ads_count;
                $user->paid_ads_count = $count - 10;
            }
            
            $post['selected'] = 1;
            $post['expiry_feature'] = Date('Y-m-d H:i:s', strtotime('+'.$setting->feature_ad_period.' days'));
        }


        $user->save();

        $post['user_id'] = $user->id;
        $post['publication_date'] = date("Y-m-d H:i:s");
        $post['expiry_date'] = Date('Y-m-d H:i:s', strtotime('+'.$ad_period.' days'));

        $product = AdProduct::create($post);

        for ($i = 0; $i < count($request->images); $i ++) {
            $image = $request->images[$i];
            Cloudder::upload("data:image/jpeg;base64,".$image, null);
            $imagereturned = Cloudder::getResult();
            $image_id = $imagereturned['public_id'];
            $image_format = $imagereturned['format'];
            $image_new_name = $image_id.'.'.$image_format;
            $product_image = new AdProductImage();
            $product_image->image = $image_new_name;
            $product_image->product_id = $product->id;
            $product_image->save();

            $product->image = $image_new_name;
        }

        if (isset($request->options) && count($request->options) > 0) {
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
                    $val_en = $request->values[$k];
                    $val_ar = $request->values[$k];
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



        $response = APIHelpers::createApiResponse(false , 200 ,'' ,   '' , $product , $request->lang );
        return response()->json($response , 200);
    }

    public function uploadimages(Request $request){
        $validator = Validator::make($request->all() , [
            'product_id' => 'required',
            'image' => 'required'
        ]);

        if($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 ,  'بعض الحقول مفقودة' ,  'بعض الحقول مفقودة' , null , $request->lang );
            return response()->json($response , 406);
        }

        $image = $request->image;
        Cloudder::upload("data:image/jpeg;base64,".$image, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];
        $image_new_name = $image_id.'.'.$image_format;
        $product_image = new AdProductImage();
        $product_image->image = $image_new_name;
        $product_image->product_id = $request->product_id;
        $product_image->save();
        $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' , $product_image , $request->lang);
        return response()->json($response , 200);


    }

    public function getdetails(Request $request){
        $user_id = "";
        if (auth()->user()) {
            $user_id = auth()->user()->id;
        }

        $country = Country::where('id', $request->country)->select('id', 'currency')->first();
        $fromCurr = trim(strtolower($country['currency']));
        $toCurr = trim(strtolower($request->curr));
        if ($fromCurr == $toCurr) {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', $fromCurr)->where('to', $toCurr)->first();
        }
        $product = AdProduct::select('id' , 'title' , 'description' , 'price'  , 'views' , 'publication_date as date' , 'user_id' , 'category_id', 'year')->find($request->id);
        // dd($product);
		$product->views = $product->views + 1;
        $product->save();

        $product['category_name'] = Category::find($product['category_id'])['title_ar'];

        $user = auth()->user();
        if($user){
            $favorite = Favorite::where('user_id' , $user->id)->where('product_id' , $product->id)->where('product_type' , 2)->first();
            if($favorite){
                $product['favorite'] = true;
            }else{
                $product['favorite'] = false;
            }
        }else{
            $product['favorite'] = false;
        }

        $date = date_create($product['date']);

        $product['date'] = date_format($date , 'd M Y');
        $product['conversation_id'] = 0;
        if($user_id != null){
            //Get conversation id
            $product_conv = AdProduct::find($request->id);
            $exist_part_one = Participant::where('ad_product_id',$request->id)
                                        ->where('user_id',$user_id)
                                        ->where('other_user_id',$product_conv->user_id)
                                        ->first();
            if($exist_part_one == null){
                $exist_part_one = Participant::where('ad_product_id',$request->id)
                                            ->where('user_id',$product_conv->user_id)
                                            ->where('other_user_id',$user_id)
                                            ->first();
            }
            if($exist_part_one != null ){
                $product['conversation_id'] = $exist_part_one->conversation_id;
            }else{
                $product['conversation_id'] = 0;
            }
        }


        $product['likes'] = Favorite::where('product_id' , $product['id'])->where('product_type' , 2)->count();
        $proPrice = $product['price'] * $currency['value'];
        $product['price'] = number_format((float)$proPrice, 3, '.', '');
        $specs = AdProductOption::where('product_id', $request->id)->get()->toArray();
        // dd($specs);
        $allSpecs = [];
        if (count($specs) > 0) {
            for ($n = 0; $n < count($specs); $n ++) {
                if ($request->lang == 'en') {
                    if ($specs[$n]['type'] == 1) {
                        $spec = (object)[
                            "option" => $specs[$n]['option_en'],
                            "value" => $specs[$n]['val_en']
                        ];
                    }else {
                        $spec = (object)[
                            "option" => $specs[$n]['option_en'],
                            "value" => $specs[$n]['value']
                        ];
                    }

                }else {
                    if ($specs[$n]['type'] == 1) {
                        $spec = (object)[
                            "option" => $specs[$n]['option_ar'],
                            "value" => $specs[$n]['val_ar']
                        ];
                    }else {
                        $spec = (object)[
                            "option" => $specs[$n]['option_ar'],
                            "value" => $specs[$n]['value']
                        ];
                    }
                }
                array_push($allSpecs, $spec);
            }
        }

        $product['specs'] = $allSpecs;
        $user_product = User::find($product['user_id']);
        $product['user_name'] = $user_product['name'];
        $product['user_phone'] = $user_product['phone'];
        $product['user_id'] = $user_product['id'];
        // dd($product);

        $images = AdProductImage::where('product_id' , $product['id'])->pluck('image')->toArray();
        // dd($images);
        $product['images'] = $images;

        $related = AdProduct::where('deleted', 0)->where('category_id' , $product['category_id'])->where('id' , '!=' , $product['id'])->where('status' , 1)->select('id' , 'title' , 'price' )->limit(3)->get();

        for($i = 0 ; $i < count($related); $i++){
            if($user){
                $favorite = Favorite::where('user_id' , $user->id)->where('product_id' , $related[$i]['id'])->where('product_type' , 2)->first();
                if($favorite){
                    $related[$i]['favorite'] = true;
                }else{
                    $related[$i]['favorite'] = false;
                }
            }else{
                $related[$i]['favorite'] = false;
            }
            $relatedPro = $related[$i]['price'] * $currency['value'];
            $related[$i]['price'] = number_format((float)$relatedPro, 3, '.', '');
            // $related[$i]['favorite'] = false;
            $relatedImage = AdProductImage::where('product_id' , $related[$i]['id'])->first();
            if ($relatedImage) {
                $related[$i]['image'] = $relatedImage['image'];
            }else {
                $related[$i]['image'] = "";
            }
        }
        $product['ad'] = Ad::where('product_type' , 2)->orWhere('type', 2)->inRandomOrder()->first();
        

        $product['related'] = $related;

        $comments = Comment::where('product_id', $product['id'])->orderBy('id', 'desc')->take(2)->get()->makeHidden('user');
        if (count($comments) > 0) {
            for ($k = 0; $k < count($comments); $k ++) {
                $comments[$k]['username'] = $comments[$k]->user->name;
                $comments[$k]['user_image'] = $comments[$k]->user->image;
            }
        }

        $product['comments'] = $comments;

        $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' , $product , $request->lang );
        return response()->json($response , 200);
    }



    public function getproducts(Request $request){
        $validator = Validator::make($request->all() , [
            'category_id' => 'required',
            'country' => 'required'
        ]);

        if($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 ,  'بعض الحقول مفقودة' ,  'بعض الحقول مفقودة' , null , $request->lang );
            return response()->json($response , 406);
        }

        $country = Country::where('id', $request->country)->select('id', 'currency')->first();
        $fromCurr = trim(strtolower($country['currency']));
        $toCurr = trim(strtolower($request->curr));
        
        if ($fromCurr == $toCurr) {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', $fromCurr)->where('to', $toCurr)->first();
        }
        
        $products = AdProduct::where('deleted', 0)->where('status', 1)->where('country_id', $request->country);
        if ($request->category_id && $request->category_id != 0) {
            $products = $products->where('category_id', $request->category_id);
        }
        if ($request->sub_category_level1_id && $request->sub_category_level1_id != 0) {
            $products = $products->where('sub_category_id', $request->sub_category_level1_id);
        }
        if ($request->sub_category_level2_id && $request->sub_category_level2_id != 0) {
            $products = $products->where('sub_category_two_id', $request->sub_category_level2_id);
        }
        if ($request->sub_category_level3_id && $request->sub_category_level3_id != 0) {
            $products = $products->where('sub_category_three_id', $request->sub_category_level3_id);
        }
        if ($request->sub_category_level4_id && $request->sub_category_level4_id != 0) {
            $products = $products->where('sub_category_four_id', $request->sub_category_level4_id);
        }
        $products = $products->select('id' , 'title' , 'price'  , 'publication_date as date', 'selected as feature', 'year', 'pin')->orderBy('pin' , 'DESC')->simplePaginate(12);



        for($i = 0; $i < count($products); $i++){
            $date = date_create($products[$i]['date']);
            $products[$i]['date'] = date_format($date , 'd M Y');
            $proPrice = $products[$i]['price'] * $currency['value'];
            $products[$i]['price'] = number_format((float)$proPrice, 3, '.', '');
            $products[$i]['image'] = AdProductImage::where('product_id' , $products[$i]['id'])->first();
            if ($products[$i]['image']) {
                $products[$i]['image'] = $products[$i]['image']['image'];
            }
            $user = auth()->user();
            if($user){
                $favorite = Favorite::where('user_id' , $user->id)->where('product_id' , $products[$i]['id'])->where('product_type', 2)->first();
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
        $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' , $data , $request->lang );
        return response()->json($response , 200);

    }

    // get comments
    public function getComments(Request $request, AdProduct $product) {
        $data = [];
        $comments = Comment::where('product_id', $product->id)->get()->makeHidden(['user', 'updated_at', 'product_id']);

        // dd($data['comments'][0]->user->image);
        if (count($comments) > 0) {
            for ($i = 0; $i < count($comments); $i ++) {
                $comments[$i]['username'] = $comments[$i]->user->name;
                $comments[$i]['user_image'] = $comments[$i]->user->image;
            }
        }
        $data = [
            'comments' => $comments,
            'count' => count($comments)
        ];

        $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' , $data , $request->lang );
        return response()->json($response , 200);
    }


    public function adSearch(Request $request){
        $search = $request->query('search');
        // dd($search);
        $country = Country::where('id', $request->country)->select('id', 'currency')->first();
        $fromCurr = trim(strtolower($country['currency']));
        $toCurr = trim(strtolower($request->curr));
        if ($fromCurr == $toCurr) {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', $fromCurr)->where('to', $toCurr)->first();
        }
        if(! $search){
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null, $request->lang);
            return response()->json($response , 406);
        }


        $products = AdProduct::select('id' , 'title' , 'price'  , 'publication_date as date', 'selected as feature', 'year', 'pin')->where('status' , 1)->where('country_id', $request->country)->where('deleted', 0)->Where('title', 'like', '%' . $search . '%')->orderBy('pin' , 'DESC')->simplePaginate(12);
        // dd($products);

        for($i = 0; $i < count($products); $i++){
            $date = date_create($products[$i]['date']);
            $products[$i]['date'] = date_format($date , 'd M Y');
            $proPrice = $products[$i]['price'] * $currency['value'];
            $products[$i]['price'] = number_format((float)$proPrice, 3, '.', '');
            $products[$i]['image'] = AdProductImage::where('product_id' , $products[$i]['id'])->first()['image'];
            $user = auth()->user();
            if($user){
                $favorite = Favorite::where('user_id' , $user->id)->where('product_id' , $products[$i]['id'])->where('product_type', 2)->first();
                if($favorite){
                    $products[$i]['favorite'] = true;
                }else{
                    $products[$i]['favorite'] = false;
                }
            }else{
                $products[$i]['favorite'] = false;
            }
        }


        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $products , $request->lang) ;
        return response()->json($response , 200);
    }

    public function adFilter(Request $request) {
        $country = Country::where('id', $request->country)->select('id', 'currency')->first();
        $fromCurr = trim(strtolower($country['currency']));
        $toCurr = trim(strtolower($request->curr));
        if ($fromCurr == $toCurr) {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', $fromCurr)->where('to', $toCurr)->first();
        }

        $products = AdProduct::where('deleted', 0)->where('status' , 1)->where('country_id', $request->country);

        if (isset($request->category_id)) {
            if ((isset($request->values) && count($request->values) > 0) && (isset($request->options) && count($request->options) > 0)) {
                for ($m = 0; $m < count($request->values); $m++) {
                    $products = $products->whereHas('options', function ($q) use ($request, $m) {
                        $q->where(function($qu) use ($request, $m) {
                            $qu->where('val_en', $request->values[$m])->orWhere('val_ar', $request->values[$m])->orWhere('value', $request->values[$m]);
                        })->where(function($qu) use ($request, $m) {
                            $qu->where('option_en', $request->options[$m])->orWhere('option_ar', $request->options[$m]);
                        });
                    });
                }
            }
            $products = $products->where('category_id', $request->category_id);
        }

        if (isset($request->sub_category_level1_id) && $request->sub_category_level1_id != 0) {
            $products = $products->where('sub_category_id', $request->sub_category_level1_id);
        }

        if (isset($request->sub_category_level2_id) && $request->sub_category_level2_id != 0) {
            $products = $products->where('sub_category_two_id', $request->sub_category_level2_id);
        }

        if (isset($request->sub_category_level3_id) && $request->sub_category_level3_id != 0) {
            $products = $products->where('sub_category_three_id', $request->sub_category_level3_id);
        }

        if (isset($request->sub_category_level4_id) && $request->sub_category_level4_id != 0) {
            $products = $products->where('sub_category_four_id', $request->sub_category_level4_id);
        }

        if (isset($request->price_from) && isset($request->price_to)) {
            $request->price_from = $request->price_from / $currency['value'];
            $request->price_to = $request->price_to / $currency['value'];
            if ($request->price_from == 0 && $request->price_to == 0) {

            }else {
                $products = $products->whereBetween('price', [$request->price_from, $request->price_to]);
            }
        }

        $products = $products->select('id' , 'title' , 'price'  , 'publication_date as date', 'selected as feature', 'year', 'pin')->orderBy('pin' , 'DESC')->simplePaginate(12);

        for($i = 0; $i < count($products); $i++){
            $date = date_create($products[$i]['date']);
            $products[$i]['date'] = date_format($date , 'd M Y');
            $proPrice = $products[$i]['price'] * $currency['value'];
            $products[$i]['price'] = number_format((float)$proPrice, 3, '.', '');
            $products[$i]['image'] = AdProductImage::where('product_id' , $products[$i]['id'])->first()['image'];
            if ($products[$i]['image']) {
				//dd($products[$i]['image']);
				$products[$i]['image'] = $products[$i]['image'];
			}else {
				$products[$i]['image'] = "";
			}
            $user = auth()->user();
            if($user){
                $favorite = Favorite::where('user_id' , $user->id)->where('product_id' , $products[$i]['id'])->where('product_type', 2)->first();
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

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang) ;
        return response()->json($response , 200);
    }


    public function getMaxMinPrice(Request $request) {
        $country = Country::where('id', $request->country)->select('id', 'currency')->first();
        $fromCurr = trim(strtolower($country['currency']));
        $toCurr = trim(strtolower($request->curr));
        if ($fromCurr == $toCurr) {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', $fromCurr)->where('to', $toCurr)->first();
        }

        $minPrice = AdProduct::where('deleted', 0)->where('status' , 1)->where('country_id', $request->country)->min('price');
        $convertedMinPrice = $minPrice * $currency['value'];
        $data['min_price'] = (int)$convertedMinPrice;
        $maxPrice = AdProduct::where('deleted', 0)->where('status' , 1)->where('country_id', $request->country)->max('price');
        $convertedMaxPrice = $maxPrice * $currency['value'];
        $data['max_price'] = (int)$convertedMaxPrice;
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang) ;
        return response()->json($response , 200);
    }



}
