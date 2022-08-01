<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;
use App\OffersSection;
use App\ControlOffer;
use App\Product;
use App\AdProduct;
use App\ProductImage;
use App\AdProductImage;
use App\Category;
use App\Favorite;
use App\Country;
use App\Currency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\APIHelpers;


class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' , ['except' => ['getoffers' , 'getoffersandroid' , 'getselected' , 'get_ecommerce_offers', 'get_ad_offers']]);
    }


    public function get_ecommerce_offers(Request $request) {
        $toCurr = trim(strtolower($request->curr));
        if ($toCurr == "kwd") {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
        }
        $offers_sections = OffersSection::where('type', 1)->orderBy('sort', 'asc')->get();
        $data = [];
        for($i = 0; $i < count($offers_sections); $i++){
            $element = [];
            $element['icon'] = $offers_sections[$i]['icon'];
            if($request->lang == 'en'){
                $element['title'] = $offers_sections[$i]['title_en'];
            }else{
                $element['title'] = $offers_sections[$i]['title_ar'];
            }
            $ids = ControlOffer::where('offers_section_id' , $offers_sections[$i]['id'])->pluck('offer_id');
            if($request->lang == 'en'){
                $element['data'] = Product::select('id', 'title_en as title' , 'offer' , 'offer_percentage' , 'final_price', 'price_before_offer' , 'type', 'year')->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->whereIn('id' , $ids)->get();
            }else{
                $element['data'] = Product::select('id', 'title_ar as title' , 'offer' , 'offer_percentage' , 'final_price', 'price_before_offer' , 'type', 'year')->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->whereIn('id' , $ids)->get();
            }
            
            for($j = 0; $j < count($element['data']) ; $j++){
                $final = $element['data'][$j]['final_price'] * $currency['value'];
                $priceBefore = $element['data'][$j]['price_before_offer'] * $currency['value'];
                $element['data'][$j]['final_price'] = number_format((float)$final, 3, '.', '');
                $element['data'][$j]['price_before_offer'] = number_format((float)$priceBefore, 2, '.', '');
                
                if(auth()->user()){
                    $user_id = auth()->user()->id;

                    $prevfavorite = Favorite::where('product_id' , $element['data'][$j]['id'])->where('product_type' , 1)->where('user_id' , $user_id)->first();
                    if($prevfavorite){
                        $element['data'][$j]['favorite'] = true;
                    }else{
                        $element['data'][$j]['favorite'] = false;
                    }

                }else{
                    $element['data'][$j]['favorite'] = false;
                }

                
                

                $element['data'][$j]['image'] = ProductImage::where('product_id' , $element['data'][$j]['id'])->pluck('image')->first();
            }

            array_push($data , $element);
        }

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }

    public function get_ad_offers(Request $request) {
        $country = Country::where('id', $request->country)->select('id', 'currency')->first();
        $fromCurr = trim(strtolower($country['currency']));
        $toCurr = trim(strtolower($request->curr));
        if ($fromCurr == $toCurr) {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', $fromCurr)->where('to', $toCurr)->first();
        }
        $offers_sections = OffersSection::where('type', 2)->orderBy('sort', 'asc')->get();
        $data = [];
        for($i = 0; $i < count($offers_sections); $i++){
            $element = [];
            $element['icon'] = $offers_sections[$i]['icon'];
            if($request->lang == 'en'){
                $element['title'] = $offers_sections[$i]['title_en'];
            }else{
                $element['title'] = $offers_sections[$i]['title_ar'];
            }
            $ids = ControlOffer::where('offers_section_id' , $offers_sections[$i]['id'])->pluck('offer_id');
            // dd($request->country);
            $element['data'] = AdProduct::select('id' , 'title' , 'price'  , 'publication_date as date', 'selected as feature', 'year')->where('deleted', 0)->where('status' , 1)->where('country_id', $request->country)->whereIn('id' , $ids)->get();
            
            if (count($element['data']) > 0) {
                for ($j = 0; $j < count($element['data']); $j ++) {
                    $proPrice = $element['data'][$j]['price'] * $currency['value'];
                    $element['data'][$j]['price'] = number_format((float)$proPrice, 3, '.', '');

                    if(auth()->user()){
                        $user_id = auth()->user()->id;
    
                        $prevfavorite = Favorite::where('product_id' , $element['data'][$j]['id'])->where('product_type' , 2)->where('user_id' , $user_id)->first();
                        if($prevfavorite){
                            $element['data'][$j]['favorite'] = true;
                        }else{
                            $element['data'][$j]['favorite'] = false;
                        }
    
                    }else{
                        $element['data'][$j]['favorite'] = false;
                    }
    
                    $element['data'][$j]['image'] = AdProductImage::where('product_id' , $element['data'][$j]['id'])->pluck('image')->first();
                }
            }

            array_push($data , $element);
        }

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }


    public function getoffers(Request $request){
        $offers_before = Offer::orderBy('sort' , 'ASC')->get();
        $offers = [];
        
        for($i = 0; $i < count($offers_before); $i++){
            if($offers_before[$i]['type'] == 1){
                $result = Product::find($offers_before[$i]['target_id']);
                if($result['deleted'] == 0 && $result['hidden'] == 0){
                    array_push($offers , $offers_before[$i]);
                }
            }else{
                $result = Category::find($offers_before[$i]['target_id']);
                if($result['deleted'] == 0 ){
                    array_push($offers , $offers_before[$i]);
                }
            }


        }


        $new_offers = [];
        for($i = 0; $i < count($offers); $i++){
            array_push($new_offers , $offers[$i]);
            if($offers[$i]->size == 3){
                if(count($offers) > 1 ){
                    if($offers[$i-1]->size != 3){
                        if(count($offers) > $i+1 ){
                            if($offers[$i+1]->size != 3){
                                $offer_element = new \stdClass();
                                $offer_element->id = 0;
                                $offer_element->image  = '';
                                $offer_element->size = 3;
                                $offer_element->type = 0;
                                $offer_element->target_id = 0;
                                $offer_element->sort = 0;
                                $offer_element->created_at = "";
                                $offer_element->updated_at = "";
                                array_push($new_offers , $offer_element);
                            }
                        }
                    }

                }
            }                        
        }
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $new_offers , $request->lang);
        return response()->json($response , 200);
    }

    public function getoffersandroid(Request $request){

        $offers_before = Offer::orderBy('sort' , 'ASC')->get();
        $offers = [];
        
        for($i = 0; $i < count($offers_before); $i++){
            if($offers_before[$i]['type'] == 1){
                $result = Product::find($offers_before[$i]['target_id']);
                if($result['deleted'] == 0 && $result['hidden'] == 0){
                    array_push($offers , $offers_before[$i]);
                }
            }else{
                $result = Category::find($offers_before[$i]['target_id']);
                if($result['deleted'] == 0){
                    array_push($offers , $offers_before[$i]);
                }
            }



        }

        $new_offers = [];
        for($i = 0; $i < count($offers); $i++){
            if($offers[$i]->size == 1 || $offers[$i]->size == 2 ){
                $count = count($new_offers);
                $new_offers[$count] = [];
                array_push($new_offers[$count] , $offers[$i]);
                $offer_element = new \stdClass();
                $offer_element->id = 0;
                $offer_element->image  = '';
                $offer_element->size = $offers[$i]->size;
                $offer_element->type = 0;
                $offer_element->target_id = 0;
                $offer_element->sort = 0;
                $offer_element->created_at = "";
                $offer_element->updated_at = "";
                array_push($new_offers[$count] , $offer_element);
            }

            if($offers[$i]->size == 3){

                if(count($offers) > 1 ){

                    $count_offers = count($new_offers);

                    $last_count = count($new_offers[$count_offers - 1]);
                    
                    if($last_count == 2){
                        $new_offers[$count_offers] = [];
                        array_push($new_offers[$count_offers] , $offers[$i]);
                        if(count($offers) > $i+1 ){
                             if($offers[$i+1]->size != 3){
                                $offer_element = new \stdClass();
                                $offer_element->id = 0;
                                $offer_element->image  = '';
                                $offer_element->size = 3;
                                $offer_element->type = 0;
                                $offer_element->target_id = 0;
                                $offer_element->sort = 0;
                                $offer_element->created_at = "";
                                $offer_element->updated_at = "";
                                array_push($new_offers[$count_offers] , $offer_element);
                            }
                        }else{
                            $offer_element = new \stdClass();
                            $offer_element->id = 0;
                            $offer_element->image  = '';
                            $offer_element->size = 3;
                            $offer_element->type = 0;
                            $offer_element->target_id = 0;
                            $offer_element->sort = 0;
                            $offer_element->created_at = "";
                            $offer_element->updated_at = "";
                            array_push($new_offers[$count_offers] , $offer_element);
                        }
                    }else{
                        array_push($new_offers[$count_offers - 1] , $offers[$i]);
                    }

                }else{
                    $count = count($new_offers);
                    $new_offers[$count] = [];
                    array_push($new_offers[$count] , $offers[$i]);
                    $offer_element = new \stdClass();
                    $offer_element->id = 0;
                    $offer_element->image  = '';
                    $offer_element->size = $offers[$i]->size;
                    $offer_element->type = 0;
                    $offer_element->target_id = 0;
                    $offer_element->sort = 0;
                    $offer_element->created_at = "";
                    $offer_element->updated_at = "";
                    array_push($new_offers[$count] , $offer_element);
                }
                
            }

        }

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $new_offers , $request->lang);
        return response()->json($response , 200);

    }

    public function getselected(Request $request){
        if($request->lang == 'en'){
            $products = Product::select('id', 'title_en as title' , 'final_price as price'  )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->where('selected' , 1)->get();
        }else{
            $products = Product::select('id', 'title_ar as title' , 'final_price as price' )->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->where('selected' , 1)->get();
        }

        for($i = 0; $i < count($products); $i++){
            
            if(auth()->user()){
                $user_id = auth()->user()->id;

                $prevfavorite = Favorite::where('product_id' , $products[$i]['id'])->where('user_id' , $user_id)->where('product_type' , 1)->first();
                if($prevfavorite){
                    $products[$i]['favorite'] = true;
                }else{
                    $products[$i]['favorite'] = false;
                }

            }else{
                $products[$i]['favorite'] = false;
            }
            
            $products[$i]['image'] = ProductImage::where('product_id' , $products[$i]['id'])->pluck('image')->first();
			 $products[$i]['product_type'] = 1;
        }

        $data['products'] = $products;


        $ad_products = AdProduct::select('id', 'title' , 'price'  )->where('status' , 1)->where('selected' , 1)->get();

        for($i = 0; $i < count($ad_products); $i++){
            
            if(auth()->user()){
                $user_id = auth()->user()->id;

                $prevfavorite = Favorite::where('product_id' , $ad_products[$i]['id'])->where('user_id' , $user_id)->where('product_type' , 2)->first();
                if($prevfavorite){
                    $ad_products[$i]['favorite'] = true;
                }else{
                    $ad_products[$i]['favorite'] = false;
                }

            }else{
                $ad_products[$i]['favorite'] = false;
            }
            
            $ad_products[$i]['image'] = AdProductImage::where('product_id' , $ad_products[$i]['id'])->pluck('image')->first();
			$ad_products[$i]['product_type'] = 2;
        }

        $data['ad_products'] = $ad_products;
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);

    }

}