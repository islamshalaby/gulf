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
use App\Option;
use App\ProductMultiOption;
use App\DeliveryMethod;
use App\Ad;
use App\Favorite;
use App\Setting;
use App\Currency;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' , ['except' => ['getdetails'  , 'getcategoryproducts' , 'getecommerceproducts' , 'getecommercefilterproducts' , 'ecommercesearch' , 'getecommerceproductdetails' , 'getecommercecompanyproducts' , 'getcompanies' , 'getdeliverymethods', 'getMaxMinPrice']]);
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
            $data['product'] = Product::select('id' , 'title_en as title' , 'description_en as description' , 'offer' , 'price_before_offer' , 'final_price' , 'offer_percentage' , 'sub_category_id' , 'company_id', 'year')->find($id);
            $data['product']['category_name'] = SubCategory::select('title_en')->find($data['product']['sub_category_id'])->title_en;
            $data['product']['company'] = Company::select('id' , 'title_en as title')->find($data['product']['company_id']); 

            $product_options = ProductOption::where('product_id' , $data['product']['id'])->select('id' , 'option_id' , 'value_en as value')->get();
            for($i = 0 ; $i < count($product_options) ; $i++){
                $product_options[$i]['key'] = Option::find($product_options[$i]['option_id'])->title_en;
            }

        }else{
            $data['product'] = Product::select('id' , 'title_ar as title' , 'description_ar as description' , 'offer' , 'price_before_offer' , 'final_price' , 'offer_percentage' , 'sub_category_id' , 'company_id', 'year')->find($id);
            $data['product']['category_name'] = SubCategory::select('title_ar')->find($data['product']['sub_category_id'])->title_ar;
            $data['product']['company'] = Company::select('id' , 'title_en as title')->find($data['product']['company_id']); 

            $product_options = ProductOption::where('product_id' , $data['product']['id'])->select('id' , 'option_id' , 'value_ar as value')->get();
            for($i = 0 ; $i < count($product_options) ; $i++){
                $product_options[$i]['key'] = Option::find($product_options[$i]['option_id'])->title_ar;
            }
        }
        if($toCurr != 'kwd'){
            $final = $data['product']['final_price'] * $currency['value'];
            $priceBefore = $data['product']['price_before_offer'] * $currency['value'];
            $data['product']['final_price'] = number_format((float)$final, 3, '.', '');
            $data['product']['price_before_offer'] = number_format((float)$priceBefore, 3, '.', '');
        }
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
            $data['related'] = Product::select('id', 'title_en as title' , 'final_price' , 'price_before_offer' , 'offer' , 'offer_percentage' , 'sub_category_id', 'year')->where('deleted' , 0)->where('sub_category_id' , $data['product']['sub_category_id'])->where('id' , '!=' , $data['product']['id'])->get();
        }else{
            $data['related'] = Product::select('id', 'title_ar as title' , 'final_price' , 'price_before_offer' , 'offer' , 'offer_percentage' , 'sub_category_id', 'year')->where('deleted' , 0)->where('sub_category_id' , $data['product']['sub_category_id'])->where('id' , '!=' , $data['product']['id'])->get();
        }
        
        for($j = 0; $j < count($data['related']) ; $j++){
            if($toCurr != 'kwd'){
                $final2 = $data['related'][$j]['final_price'] * $currency['value'];
                $priceBefore2 = $data['related'][$j]['price_before_offer'] * $currency['value'];
                $data['related'][$j]['final_price'] = number_format((float)$final2, 3, '.', '');
                $data['related'][$j]['price_before_offer'] = number_format((float)$priceBefore2, 3, '.', '');
            }

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
                $data['related'][$j]['category_name'] = SubCategory::where('id' , $data['related'][$j]['sub_category_id'])->pluck('title_en as title')->first();
            }else{
                $data['related'][$j]['category_name'] = SubCategory::where('id' , $data['related'][$j]['sub_category_id'])->pluck('title_ar as title')->first();
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
            if($request->curr != 'kwd'){
                $final = $products[$i]['final_price'] * $currency['value'];
                $priceBefore = $products[$i]['price_before_offer'] * $currency['value'];
                $products[$i]['final_price'] = number_format((float)$final, 3, '.', '');
                $products[$i]['price_before_offer'] = number_format((float)$priceBefore, 2, '.', '');
            }
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
        $sub_car_type_level1_id = $request->sub_car_type_level1_id;
        $sub_car_type_level2_id = $request->sub_car_type_level2_id;

        if($request->lang == 'en'){
            $products = Product::select('id', 'title_en as title' , 'final_price'  , 'price_before_offer' , 'offer' , 'offer_percentage', 'created_at' , 'updated_at' , 'type' , 'year' , 'sub_one_car_type_id' , 'sub_two_car_type_id'  )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0);
        }else{
            $products = Product::select('id', 'title_ar as title' , 'final_price' , 'price_before_offer' , 'offer' , 'offer_percentage', 'created_at' , 'updated_at' , 'type' , 'year' , 'sub_one_car_type_id' , 'sub_two_car_type_id' )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0);
        }

        if (isset($sub_car_type_level1_id) && $sub_car_type_level1_id != 0) {
            $products->where('sub_one_car_type_id' , $sub_car_type_level1_id);
        }
        

        if($sub_car_type_level2_id && $sub_car_type_level2_id != 0 ){
            $products->where('sub_two_car_type_id', $request->sub_car_type_level2_id);
        }

        if ($request->has('year') && $request->year != 0) {
            $products->where('year', $request->year);
        }
        // dd(($request->price_from != 0 && $request->price_to != 0));
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

        if (isset($request->sub_car_type_level3_id) && $request->sub_car_type_level3_id != 0) {
            $products->where('category_id', $request->sub_car_type_level3_id);
        }

        if (isset($request->sub_car_type_level4_id) && $request->sub_car_type_level4_id != 0) {
            $products->where('sub_category_id', $request->sub_car_type_level4_id);
        }

        if (isset($request->sub_category_id) && $request->sub_category_id != 0) {
            $products->where('sub_category_id', $request->sub_category_id);
        }

        if (isset($request->car_type_level2_id) && $request->car_type_level2_id != 0) {
            $products->where('sub_two_car_type_id', $request->sub_car_type_level2_id);
        }

        $data['products_count'] = $products->get()->count();

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
        $delivery_methods = DeliveryMethod::where('deleted', 0)->get();

        if($request->lang == 'en'){
            $delivery_methods = DeliveryMethod::select('id' , 'title_en as title' , 'icon' , 'price' , 'description_en as description')->get();
        }else{
            $delivery_methods = DeliveryMethod::select('id' , 'title_ar as title' , 'icon' , 'price' , 'description_ar as description')->get();
        }

        if (count($delivery_methods) > 0) {
            for ($i = 0; $i < count($delivery_methods); $i ++) {
                
                $final = $delivery_methods[$i]['price'] * $currency['value'];
                $delivery_methods[$i]['price'] = number_format((float)$final, 3, '.', '');
            }
        }

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $delivery_methods , $request->lang);
        return response()->json($response , 200);
    }

    public function getMaxMinPrice(Request $request) {
        $toCurr = trim(strtolower($request->curr));
        if ($toCurr == "kwd") {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
        }

        $minPrice = Product::where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->min('final_price');
        $convertedMinPrice = $minPrice * $currency['value'];
        $data['min_price'] = (int)$convertedMinPrice;
        $maxPrice = Product::where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->max('final_price');
        $convertedMaxPrice = $maxPrice * $currency['value'];
        $data['max_price'] = (int)$convertedMaxPrice;
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang) ;
        return response()->json($response , 200);
    }

}