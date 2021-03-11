<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Favorite;
use App\Category;
use App\Product;
use App\AdProduct;
use App\ProductImage;
use App\AdProductImage;
use App\Currency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\APIHelpers;


class FavoriteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api' , ['except' => []]);
    }

    public function addecommercetofavorites(Request $request){
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة'  , null , $request->lang);
            return response()->json($response , 406);
        }
        $user_id = auth()->user()->id;

        $prevfavorite = Favorite::where('product_id' , $request->product_id)->where('product_type' , 1)->where('user_id' , $user_id)->first();
        if($prevfavorite){
            $response = APIHelpers::createApiResponse(true , 406 , 'This product added to favorite list before' , 'تم إضافه هذا المنتج للمفضله من قبل'  , null , $request->lang);
            return response()->json($response , 406);
        }

        $favorite = new Favorite();
        $favorite->product_id = $request->product_id;
        $favorite->user_id = $user_id;
        $favorite->product_type = 1;
        $favorite->save();

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $favorite , $request->lang);
        return response()->json($response , 200);
    }

    public function removeecommercefromfavorites(Request $request){
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة'  , null , $request->lang);
            return response()->json($response , 406);
        }

        $user_id = auth()->user()->id;
        $favorite = Favorite::where('product_id' , $request->product_id)->where('product_type' ,1)->where('user_id' , $user_id)->first();
        if($favorite){
            $favorite->delete();
            $deleted = (object)["product_id" => 0, "user_id" => 0, "updated_at" => "", "created_at" => "", "id" => 0 , "type" => 0 , "price" => 0];
            $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $deleted , $request->lang);
            return response()->json($response , 200);

        }else{
            $response = APIHelpers::createApiResponse(false , 200 , '' , '' , [] , $request->lang);
            return response()->json($response , 200);
        }

    }

    public function getecommercefavorites(Request $request){
        $toCurr = trim(strtolower($request->curr));
        if ($toCurr == "kwd") {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
        }
        $user_id = auth()->user()->id;
        $favorites = Favorite::where('user_id' , $user_id)->where('product_type' , 1)->pluck('product_id')->toArray();
        if($request->lang == 'en'){
            $products = Product::whereIn('id', $favorites)->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->select('id', 'title_en as title' , 'final_price as price' , 'type', 'year' )->get();
        }else{
            $products = Product::whereIn('id', $favorites)->where('deleted' , 0)->where('hidden' , 0)->where('remaining_quantity', '>', 0)->select('id', 'title_ar as title' , 'final_price as price' , 'type', 'year' )->get();
        }

        
 
        for($i =0 ; $i < count($products); $i++){
            $final = $products[$i]['price'] * $currency['value'];
            $products[$i]['price'] = number_format((float)$final, 3, '.', '');
            $products[$i]['favorite'] = true;
            $products[$i]['image'] = ProductImage::where('product_id' , $products[$i]['id'])->pluck('image')->first();
        }


        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $products , $request->lang);
        return response()->json($response , 200);

    }

    public function addAdtofavorites(Request $request){
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة'  , null , $request->lang);
            return response()->json($response , 406);
        }
        $user_id = auth()->user()->id;

        $prevfavorite = Favorite::where('product_id' , $request->product_id)->where('product_type' , 2)->where('user_id' , $user_id)->first();
        if($prevfavorite){
            $response = APIHelpers::createApiResponse(true , 406 , 'This product added to favorite list before' , 'تم إضافه هذا المنتج للمفضله من قبل'  , null , $request->lang);
            return response()->json($response , 406);
        }

        $favorite = new Favorite();
        $favorite->product_id = $request->product_id;
        $favorite->user_id = $user_id;
        $favorite->product_type = 2;
        $favorite->save();

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $favorite , $request->lang);
        return response()->json($response , 200);
    }

    public function removeAdfromfavorites(Request $request){
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة'  , null , $request->lang);
            return response()->json($response , 406);
        }

        $user_id = auth()->user()->id;
        $favorite = Favorite::where('product_id' , $request->product_id)->where('product_type' ,2)->where('user_id' , $user_id)->first();
        if($favorite){
            $favorite->delete();
            $deleted = (object)["product_id" => 0, "user_id" => 0, "updated_at" => "", "created_at" => "", "id" => 0 , "type" => 0 , "price" => 0];
            $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $deleted , $request->lang);
            return response()->json($response , 200);

        }else{
            $response = APIHelpers::createApiResponse(false , 200 , '' , '' , [] , $request->lang);
            return response()->json($response , 200);
        }

    }

    public function getAdfavorites(Request $request){
        $user_id = auth()->user()->id;
        $favorites = Favorite::where('user_id' , $user_id)->where('product_type' , 2)->pluck('product_id')->toArray();
        // dd($favorites);
        $products = AdProduct::whereIn('id', $favorites)->where('country_id', $request->country)->select('id' , 'title' , 'price'  , 'publication_date as date', 'selected as feature', 'year')->orderBy('publication_date' , 'DESC')->get();
 
        for($i =0 ; $i < count($products); $i++){
            $products[$i]['price'] = number_format((float)$products[$i]['price'], 3, '.', '');
            $products[$i]['favorite'] = true;
            $products[$i]['image'] = AdProductImage::where('product_id' , $products[$i]['id'])->pluck('image')->first();
        }


        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $products , $request->lang);
        return response()->json($response , 200);

    }

}