<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\APIHelpers;
use App\Product;
use App\ProductOption;
use App\Category;
use App\Company;
use App\SubFiveCategory;
use App\Brand;
use App\SubCategory;
use App\ProductImage;
use App\Country;
use App\Option;
use App\ProductMultiOption;
use App\DeliveryMethod;
use App\Ad;
use App\CarType;
use App\Favorite;
use App\Setting;
use App\Currency;
use App\OptionsCategory;
use App\OptionValue;
use App\ProductCompatible;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' , ['except' => ['getdetails'  , 'getcategoryproducts' , 'getecommerceproducts' , 'getecommercefilterproducts' , 'ecommercesearch' , 'getecommerceproductdetails' , 'getecommercecompanyproducts' , 'getcompanies' , 'getdeliverymethods', 'getMaxMinPrice', 'filter', 'getOptionsByCatId']]);
    }


    public function getecommerceproductdetails(Request $request){
        $toCurr = trim(strtolower($request->curr));
        if ($toCurr == "kwd") {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
        }
        $id = $request->id;
        if($request->lang == 'en'){
            $data['product'] = Product::select('id' , 'title_en as title' , 'description_en as description' , 'offer' , 'price_before_offer' , 'final_price' , 'offer_percentage' , 'car_type_id' , 'company_id', 'year')->find($id);
            $data['product']['category_name'] = CarType::select('title_en')->find($data['product']['car_type_id']);
            if ($data['product']['category_name']) {
                $data['product']['category_name'] = $data['product']['category_name']->title_en;
            }
            $data['product']['company'] = Company::select('id' , 'title_en as title')->find($data['product']['company_id']); 

            $product_options = ProductOption::where('product_id' , $data['product']['id'])->select('id' , 'option_id' , 'value_en as value')->get();
            for($i = 0 ; $i < count($product_options) ; $i++){
                $option = Option::find($product_options[$i]['option_id']);
                $product_options[$i]['key'] = "";
                if ($option) {
                    $product_options[$i]['key'] = $option['title_en'];
                }
            }

        }else{
            $data['product'] = Product::select('id' , 'title_ar as title' , 'description_ar as description' , 'offer' , 'price_before_offer' , 'final_price' , 'offer_percentage' , 'car_type_id' , 'company_id', 'year')->find($id);
            $data['product']['category_name'] = CarType::select('title_ar')->find($data['product']['car_type_id']);
            if ($data['product']['category_name']) {
                $data['product']['category_name'] = $data['product']['category_name']->title_ar;
            }
            $data['product']['company'] = Company::select('id' , 'title_en as title')->find($data['product']['company_id']); 

            $product_options = ProductOption::where('product_id' , $data['product']['id'])->select('id' , 'option_id' , 'value_ar as value')->get();
            for($i = 0 ; $i < count($product_options) ; $i++){
                $option = Option::find($product_options[$i]['option_id']);
                $product_options[$i]['key'] = "";
                if ($option) {
                    $product_options[$i]['key'] = $option['title_ar'];
                }
            }
        }
        
        $final = $data['product']['final_price'] * $currency['value'];
        $priceBefore = $data['product']['price_before_offer'] * $currency['value'];
        $data['product']['final_price'] = number_format((float)$final, 3, '.', '');
        $data['product']['price_before_offer'] = number_format((float)$priceBefore, 3, '.', '');
        
        $data['product']['images'] = ProductImage::where('product_id' , $data['product']['id'])->pluck('image');

        // $data['product']['favorite'] = false;
        if(auth()->user()){
            $user_id = auth()->user()->id;

            $prevfavorite = Favorite::where('product_id' , $data['product']['id'])->where('user_id' , $user_id)->first();
            if($prevfavorite){
                $data['product']['favorite'] = true;
            }else{
                $data['product']['favorite'] = false;
            }

        }else{
            $data['product']['favorite'] = false;
        }

        $data['product']['options'] = $product_options;
        
        
        if($request->lang == 'en'){
            $data['related'] = Product::select('id', 'title_en as title' , 'final_price' , 'price_before_offer' , 'offer' , 'offer_percentage' , 'car_type_id', 'year', 'type')->where('deleted' , 0)->where('sub_category_id' , $data['product']['sub_category_id'])->where('id' , '!=' , $data['product']['id'])->get();
        }else{
            $data['related'] = Product::select('id', 'title_ar as title' , 'final_price' , 'price_before_offer' , 'offer' , 'offer_percentage' , 'car_type_id', 'year', 'type')->where('deleted' , 0)->where('sub_category_id' , $data['product']['sub_category_id'])->where('id' , '!=' , $data['product']['id'])->get();
        }
        
        for($j = 0; $j < count($data['related']) ; $j++){
            
            $final2 = $data['related'][$j]['final_price'] * $currency['value'];
            $priceBefore2 = $data['related'][$j]['price_before_offer'] * $currency['value'];
            $data['related'][$j]['final_price'] = number_format((float)$final2, 3, '.', '');
            $data['related'][$j]['price_before_offer'] = number_format((float)$priceBefore2, 3, '.', '');
            

            if(auth()->user()){
                $user_id = auth()->user()->id;
    
                $prevfavorite = Favorite::where('product_id' , $data['related'][$j]['id'])->where('user_id' , $user_id)->first();
                if($prevfavorite){
                    $data['related'][$j]['favorite'] = true;
                }else{
                    $data['related'][$j]['favorite'] = false;
                }
    
            }else{
                $data['related'][$j]['favorite'] = false;
            }


            if($request->lang == 'en'){
                $data['related'][$j]['category_name'] = CarType::where('id' , $data['related'][$j]['car_type_id'])->pluck('title_en as title')->first();
            }else{
                $data['related'][$j]['category_name'] = CarType::where('id' , $data['related'][$j]['car_type_id'])->pluck('title_ar as title')->first();
            }
            

            $data['related'][$j]['image'] = ProductImage::where('product_id' , $data['related'][$j]['id'])->pluck('image')->first();;
        }


        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    public function getecommerceproducts(Request $request){
        $toCurr = trim(strtolower($request->curr));
        if ($toCurr == "kwd") {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
        }
        $car_type_level2_id = $request->sub_car_type_level2_id;
        $sub_category_id = $request->sub_category_id;
        $type = $request->type;

        if($request->lang == 'en'){
            $products = Product::select('id', 'title_en as title' , 'final_price'  , 'price_before_offer' , 'offer' , 'offer_percentage', 'created_at' , 'updated_at' , 'type' , 'year' , 'sub_two_car_type_id' , 'sub_category_id' )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0);
        }else{
            $products = Product::select('id', 'title_ar as title' , 'final_price' , 'price_before_offer' , 'offer' , 'offer_percentage', 'created_at' , 'updated_at' , 'type' , 'year' , 'sub_two_car_type_id' , 'sub_category_id' )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0);
        }

        if ($request->type) {
            $products->where('type', $request->type);
        }

        if ($request->sub_category_id) {
            $products->where('sub_category_id', $request->sub_category_id);
        }

        if ($request->sub_car_type_level2_id) {
            $products->where('sub_two_car_type_id', $request->sub_car_type_level2_id);
        }

        $data['products_count'] =  $products->get()->count();
        $products = $products->simplePaginate(16);




        for($i = 0; $i < count($products); $i++){
            $final = $products[$i]['final_price'] * $currency['value'];
            $priceBefore = $products[$i]['price_before_offer'] * $currency['value'];
            $products[$i]['final_price'] = number_format((float)$final, 3, '.', '');
            $products[$i]['price_before_offer'] = number_format((float)$priceBefore, 2, '.', '');
            if(auth()->user()){
                $user_id = auth()->user()->id;

                $prevfavorite = Favorite::where('product_id' , $products[$i]['id'])->where('product_type' , 1)->where('user_id' , $user_id)->first();
                if($prevfavorite){
                    $products[$i]['favorite'] = true;
                }else{
                    $products[$i]['favorite'] = false;
                }

            }else{
                $products[$i]['favorite'] = false;
            }

            $products[$i]['image'] = ProductImage::where('product_id' , $products[$i]['id'])->pluck('image')->first();
			
        }
        $products = json_encode($products);
        $products = json_decode($products);
        $data['products'] = $products;
           


        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    public function getecommercefilterproducts(Request $request){
        $toCurr = trim(strtolower($request->curr));
        if ($toCurr == "kwd") {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
        }

        $products = Product::select('id', 'title_' . $request->lang . ' as title' , 'final_price'  , 'price_before_offer' , 'offer' , 'offer_percentage', 'created_at' , 'updated_at' , 'type' , 'year' , 'sub_one_car_type_id' , 'sub_two_car_type_id', 'car_type_id', 'sub_category_id', 'category_id'  )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0);

        if ($request->has('year') && $request->year != 0) {
            $compatible = ProductCompatible::where('year', $request->year)->pluck('product_id')->toArray();
            $products->whereIn('id', $compatible);
        }
        
        if($request->has('price_from') && $request->has('price_to')){
            $request->price_from = $request->price_from / $currency['value'];
            $request->price_to = $request->price_to / $currency['value'];
            // dd(strval($request->price_to));
            if ($request->price_from == 0 && $request->price_to == 0) {

            }else {
                $products->whereBetween('final_price', [$request->price_from, $request->price_to]);
            }
        }
        
        if (isset($request->type) && $request->type != 0) {
            $products->where('type', $request->type);
        }
        
        // category id = car_type_id
        if (isset($request->category_id) && $request->category_id != 0) {
            $products->where('car_type_id', $request->category_id);
        }

        if (isset($request->sub_car_type_id) && $request->sub_car_type_id != 0) {
            $products->where('sub_one_car_type_id' , $request->sub_car_type_id);
        }

        if (isset($request->sub_car_type2_id) && $request->sub_car_type2_id != 0) {
            $products->where('sub_two_car_type_id' , $request->sub_car_type2_id);
        }

        if (isset($request->sub_car_type3_id) && $request->sub_car_type3_id != 0) {
            $products->where('category_id' , $request->sub_car_type3_id);
        }

        if (isset($request->sub_car_type4_id) && $request->sub_car_type4_id != 0) {
            $products->where('sub_category_id' , $request->sub_car_type4_id);
        }

        $data['products_count'] = $products->get()->count();
            // dd($products);
        $products = $products->simplePaginate(16);
        
        for($i = 0; $i < count($products); $i++){
            $final = $products[$i]['final_price'] * $currency['value'];
            $priceBefore = $products[$i]['price_before_offer'] * $currency['value'];
            $products[$i]['final_price'] = number_format((float)$final, 3, '.', '');
            $products[$i]['price_before_offer'] = number_format((float)$priceBefore, 2, '.', '');
            if(auth()->user()){
                $user_id = auth()->user()->id;

                $prevfavorite = Favorite::where('product_id' , $products[$i]['id'])->where('product_type' , 1)->where('user_id' , $user_id)->first();
                if($prevfavorite){
                    $products[$i]['favorite'] = true;
                }else{
                    $products[$i]['favorite'] = false;
                }

            }else{
                $products[$i]['favorite'] = false;
            }


            $products[$i]['image'] = ProductImage::where('product_id' , $products[$i]['id'])->pluck('image')->first();
			
        }
        $products = json_encode($products);
        $products = json_decode($products);
        $data['products'] = $products;        
        

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);

    }

    public function ecommercesearch(Request $request){
        $toCurr = trim(strtolower($request->curr));
        if ($toCurr == "kwd") {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
        }
        $search = $request->query('search');

        if(! $search){
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null, $request->lang);
            return response()->json($response , 406);
        }

        if($request->lang == 'en'){
            $products = Product::select('title_en as title', 'type', 'final_price'  , 'price_before_offer' , 'offer' , 'offer_percentage' , 'id', 'year')->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->Where(function($query) use ($search) {
                $query->Where('title_en', 'like', '%' . $search . '%')->orWhere('title_ar', 'like', '%' . $search . '%');
            })->simplePaginate(12);
        }else{
            $products = Product::select('title_ar as title' , 'type', 'final_price'  , 'price_before_offer' , 'offer' , 'offer_percentage' , 'id', 'year')->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->Where(function($query) use ($search) {
                $query->Where('title_en', 'like', '%' . $search . '%')->orWhere('title_ar', 'like', '%' . $search . '%');
            })->simplePaginate(12);
        }

        for($i =0; $i < count($products); $i++){
            if(auth()->user()){
                $user_id = auth()->user()->id;

                $prevfavorite = Favorite::where('product_id' , $products[$i]['id'])->where('product_type' , 1)->where('user_id' , $user_id)->first();
                if($prevfavorite){
                    $products[$i]['favorite'] = true;
                }else{
                    $products[$i]['favorite'] = false;
                }

            }else{
                $products[$i]['favorite'] = false;
            }
            $final = $products[$i]['final_price'] * $currency['value'];
            $priceBefore = $products[$i]['price_before_offer'] * $currency['value'];
            $products[$i]['final_price'] = number_format((float)$final, 3, '.', '');
            $products[$i]['price_before_offer'] = number_format((float)$priceBefore, 2, '.', '');
            $products[$i]['image'] = ProductImage::where('product_id' , $products[$i]['id'])->pluck('image')->first();
        }




        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $products , $request->lang) ;
        return response()->json($response , 200);
    }


    public function getecommercecompanyproducts(Request $request){
        $toCurr = trim(strtolower($request->curr));
        if ($toCurr == "kwd") {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
        }
        $company_id = $request->id;
        $type = $request->type;


        if($company_id && $type){
            if($request->lang == 'en'){
                $products = Product::select('id', 'title_en as title' , 'final_price'  , 'price_before_offer' , 'offer' , 'offer_percentage', 'created_at' , 'updated_at' , 'type', 'year' )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->where('company_id' , $request->id)->where('type' , $request->type)->simplePaginate(16);
            }else{
                $products = Product::select('id', 'title_ar as title' , 'final_price' , 'price_before_offer' , 'offer' , 'offer_percentage', 'created_at' , 'updated_at' , 'type', 'year'  )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->where('company_id' , $request->id)->where('type' , $request->type)->simplePaginate(16);
            }
            $all  = Product::select('id', 'title_ar as title' , 'final_price' , 'price_before_offer' , 'offer' , 'offer_percentage', 'created_at' , 'updated_at' , 'type', 'year'  )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->where('company_id' , $request->id)->where('type' , $request->type)->get();
        }else if($company_id && !$type){
            if($request->lang == 'en'){
                $products = Product::select('id', 'title_en as title' , 'final_price' , 'price_before_offer' , 'offer' , 'offer_percentage', 'created_at' , 'updated_at' , 'type', 'year' )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->where('company_id' , $request->id)->simplePaginate(16);
            }else{
                $products = Product::select('id', 'title_ar as title' , 'final_price' , 'price_before_offer' , 'offer' , 'offer_percentage', 'created_at' , 'updated_at' , 'type', 'year'  )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->where('company_id' , $request->id)->simplePaginate(16);
            }
            $all  = Product::select('id', 'title_ar as title' , 'final_price' , 'price_before_offer' , 'offer' , 'offer_percentage', 'created_at' , 'updated_at' , 'type', 'year'  )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->where('company_id' , $request->id)->get();
        }

        if($request->lang == 'en'){
            $data['company'] = Company::select('id' , 'image' , 'title_en as title')->find($request->id);
        }else{
            $data['company'] = Company::select('id' , 'image' , 'title_ar as title')->find($request->id);
        }
        $data['company']['product_count'] = count($all);

        

        for($i = 0; $i < count($products); $i++){
            $final = $products[$i]['final_price'] * $currency['value'];
            $priceBefore = $products[$i]['price_before_offer'] * $currency['value'];
            $products[$i]['final_price'] = number_format((float)$final, 3, '.', '');
            $products[$i]['price_before_offer'] = number_format((float)$priceBefore, 2, '.', '');
            if(auth()->user()){
                $user_id = auth()->user()->id;

                $prevfavorite = Favorite::where('product_id' , $products[$i]['id'])->where('product_type' , 1)->where('user_id' , $user_id)->first();
                if($prevfavorite){
                    $products[$i]['favorite'] = true;
                }else{
                    $products[$i]['favorite'] = false;
                }

            }else{
                $products[$i]['favorite'] = false;
            }

       
            
            $products[$i]['image'] = ProductImage::where('product_id' , $products[$i]['id'])->pluck('image')->first();
			
        }
        $products = json_encode($products);
        $products = json_decode($products);
        $data['products'] =    $products;    




        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);

    }

    public function getcompanies(Request $request){
        if($request->lang == 'en'){
            $companies = Company::select('id' , 'title_en as title' , 'image')->simplePaginate(16);
        }else{
            $companies = Company::select('id' , 'title_ar as title' , 'image')->simplePaginate(16);
        }
        
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $companies , $request->lang);
        return response()->json($response , 200);


    }

    public function getdeliverymethods(Request $request){
        $toCurr = trim(strtolower($request->curr));
        if ($toCurr == "kwd") {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
        }
        $delivery_methods = DeliveryMethod::where('deleted', 0)->get()->toArray();
        
        if($request->lang == 'en'){
            $delivery_methods = DeliveryMethod::select('id' , 'title_en as title' , 'icon' , 'description_en as description')->get();
        }else{
            $delivery_methods = DeliveryMethod::select('id' , 'title_ar as title' , 'icon' , 'description_ar as description')->get();
        }
        if (isset($request->product_id)) {
            $product = Product::where('id', $request->product_id)->select('installation_cost', 'weight', 'length', 'height', 'width', 'global_shipping')->first();
        }
        
        if (count($delivery_methods) > 0) {
            for ($i = 0; $i < count($delivery_methods); $i ++) {
                $price = 0;
                
                if ($delivery_methods[$i]['id'] == 2 && isset($request->product_id)) {
                    $price = $product['installation_cost'];
                }
                if ($request->country && $request->country != 0 && $delivery_methods[$i]['id'] == 3 && $product->global_shipping == 1) {
                    $country = Country::where('id', $request->country)->select('iso_code')->first();
                    $createClient = $this->createClient();
                    $soapClient = $createClient['soapClient'];
					//dd($country->iso_code);
                    $data['CI'] = $createClient['ci'];
                    $scaleWeight = 0;
                    $width = 0;
                    $length = 0;
                    $height = 0;
                    if (!empty($product->weight)) {
                        $scaleWeight = $product->weight;
                    }
                    if (!empty($product->Length)) {
                        $length = $product->Length;
                    }
                    if (!empty($product->height)) {
                        $height = $product->height;
                    }
                    if (!empty($product->width)) {
                        $width = $product->width;
                    }
                    $data['SI'] = [
                        "DestinationCityCode" => "",
                        "DestinationCountryCode" => $country->iso_code,
                        "Height" => $height,
                        "Length" => $length,
                        "OriginCountryCode" => 'KW',
                        "RateSheetType" => "NONDOC",
                        "ScaleWeight" => $scaleWeight,
                        "Width" => $width
                    ];
                    
                    $res = $soapClient->__SoapCall('ShipmentCostCalculationInfo', [$data]);
                    $price = $res->ShipmentCostCalculationInfoResult->Amount;
                }
                $final = $price * $currency['value'];
                $delivery_methods[$i]['price'] = number_format((float)$final, 3, '.', '');
            }
            if (($product->global_shipping != 1 && $request->country == 4) || ($product->global_shipping == 1 && $request->country == 4) ) {
                $delivery_methods = [$delivery_methods[0], $delivery_methods[1]];
            }elseif ($product->global_shipping == 1) {
                $delivery_methods = [$delivery_methods[2]];
            }else {
                $delivery_methods = [];
            }
        }

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $delivery_methods , $request->lang);
        return response()->json($response , 200);
    }

    public function getMaxMinPrice(Request $request) {
        $validator = Validator::make($request->all() , [
            'category_id' => 'required'
        ]);
        if($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , $validator->messages()->first() ,$validator->messages()->first(), null , $request->lang);
            return response()->json($response , 406);
        }
        $toCurr = trim(strtolower($request->curr));
        if ($toCurr == "kwd") {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
        }

        $minPrice = Product::where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->where("car_type_id", $request->category_id)->min('final_price');
        $convertedMinPrice = $minPrice * $currency['value'];
        $data['min_price'] = (int)$convertedMinPrice;
        $maxPrice = Product::where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->where("car_type_id", $request->category_id)->max('final_price');
        $convertedMaxPrice = $maxPrice * $currency['value'];
        $data['max_price'] = (int)$convertedMaxPrice;
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang) ;
        return response()->json($response , 200);
    }

    public function getOptionsByCatId(Request $request) {
        $lang = $request->lang;
        $optionIds = OptionsCategory::where('category_id', $request->category_id)->pluck('option_id')->toArray();
        $options = Option::whereIn('id', $optionIds)->select('id', 'title_' . $request->lang . ' as title')->orderBy('sort', 'asc')->get()
        ->map(function($row) use ($lang) {
            $row->values = OptionValue::where('option_id', $row->id)->select('id', 'value_' . $lang . ' as value', 'parent_id')->get()
            ->map(function($val) use ($lang) {
                $optionIds = OptionValue::where('parent_id', $val->id)->pluck('option_id')->toArray();
                $val->options = Option::whereIn('id', $optionIds)->select("id", 'title_' . $lang . ' as title', 'parent_id')->get()
                ->map(function($optionVal) use ($lang, $val) {
                    $optionVal->values = OptionValue::where('option_id', $optionVal->id)->where('parent_id', $val->id)->select('id', 'value_' . $lang . ' as value', 'parent_id')->get();
                    
                    return $optionVal;
                });
                
                return $val;
            });

            return $row;
        });

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $options , $request->lang) ;
        return response()->json($response , 200);
    }

    // filter
    public function filter(Request $request) {
        $validator = Validator::make($request->all() , [
            'order' => 'required',
            'category_id' => 'required'
        ]);
        if($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , $validator->messages()->first() ,$validator->messages()->first(), null , $request->lang);
            return response()->json($response , 406);
        }
        $lang = $request->lang;
        $toCurr = trim(strtolower($request->curr));
        if ($toCurr == "kwd") {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
        }

        $result = Product::query();
        $result = $result->select('id', 'title_' . $lang . ' as title' , 'final_price'  , 'price_before_offer' , 'offer' , 'offer_percentage', 'created_at' , 'updated_at' , 'type' , 'year' , 'sub_two_car_type_id' , 'sub_category_id' )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->where("car_type_id", $request->category_id);

        if ($request->from_price >= 0 && $request->to_price > 0) {
            $request->from_price = (double)$request->from_price / (double)$currency['value'];
            $request->to_price = (double)$request->to_price / (double)$currency['value'];
            
            $result = $result->whereRaw('final_price BETWEEN ' . $request->from_price . ' AND ' . $request->to_price . '');
        }

        if ($request->options && count($request->options) > 0) {
            $product_ids = [];
            foreach ($request->options as $key => $row) {
                $product_ids = ProductOption::where('option_id', $row['option_id'])->where('value_id', $row['option_value'])->pluck('product_id')->toArray();
            }

            $result = $result->whereIn('id', $product_ids);
        }

        if ($request->order == "recent") {
            $result = $result->orderBy('created_at', 'desc');
        }else if($request->order == "high_price") {
            $result = $result->orderBy('final_price', 'desc');
        }else {
            $result = $result->orderBy('final_price', 'asc');
        }
        if ($request->type && $request->type != 0) {
            $result = $result->where('type', $request->type);
        }
        $data['products_count'] = $result->get()->count();
        $products = $result->simplePaginate(16);

        for($i = 0; $i < count($products); $i++){
            $final = $products[$i]['final_price'] * $currency['value'];
            $priceBefore = $products[$i]['price_before_offer'] * $currency['value'];
            $products[$i]['final_price'] = number_format((float)$final, 3, '.', '');
            $products[$i]['price_before_offer'] = number_format((float)$priceBefore, 2, '.', '');
            if(auth()->user()){
                $user_id = auth()->user()->id;

                $prevfavorite = Favorite::where('product_id' , $products[$i]['id'])->where('product_type' , 1)->where('user_id' , $user_id)->first();
                if($prevfavorite){
                    $products[$i]['favorite'] = true;
                }else{
                    $products[$i]['favorite'] = false;
                }

            }else{
                $products[$i]['favorite'] = false;
            }


            $products[$i]['image'] = ProductImage::where('product_id' , $products[$i]['id'])->pluck('image')->first();
			
        }
        $data['products'] = $products;

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang) ;
        return response()->json($response , 200);
    }

}