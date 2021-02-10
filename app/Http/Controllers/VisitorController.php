<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\APIHelpers;
use App\Visitor;
use App\Cart;
use App\Favorite;
use App\Product;
use App\ProductImage;
use App\DeliveryMethod;
use App\Company;
use App\Currency;

class VisitorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' , ['except' => ['create' , 'add' , 'delete' , 'get' , 'changecount' , 'getcartcount']]);
    }

    // create visitor 
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'unique_id' => 'required',
            // 'fcm_token' => "required",
            'type' => 'required' // 1 -> iphone ---- 2 -> android
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }

        $last_visitor = Visitor::where('unique_id' , $request->unique_id)->first();
        if($last_visitor){
            // $last_visitor->fcm_token = $request->fcm_token;
            // $last_visitor->save();
            $visitor = $last_visitor;
        }else{
            $visitor = new Visitor();
            $visitor->unique_id = $request->unique_id;
            // $visitor->fcm_token = $request->fcm_token;
            $visitor->type = $request->type;
            $visitor->save();
        }


        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $visitor , $request->lang);
        return response()->json($response , 200);
    }

    // add to cart
    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'unique_id' => 'required',
            'product_id' => 'required',
            'method' => 'required'
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }

        $visitor = Visitor::where('unique_id' , $request->unique_id)->first();
        if($visitor){
            $cart = Cart::where('visitor_id' , $visitor->id)->where('product_id' , $request->product_id)->where('method', $request->method)->first();
            $product = Product::find($request->product_id);
            if($product->remaining_quantity < 1){
                $response = APIHelpers::createApiResponse(true , 406 , 'The remaining amount of the product is not enough' , 'الكميه المتبقيه من المنتج غير كافيه'  , null , $request->lang);
                return response()->json($response , 406);
            }
            $deliveryMethod = DeliveryMethod::where('id', $request->method)->select('price')->first();
            
            if($cart){
                $count = $cart->count;
                $cart->count = $count + 1;
                $cart->save();
            }else{
                $cart = new Cart();
                $cart->count = 1;
                $cart->product_id = $request->product_id;
                $cart->visitor_id = $visitor->id;
                $cart->method = $request->method;
                $cart->delivery_cost = $deliveryMethod['price'];
                $cart->save();
            }

            $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $cart , $request->lang);
            return response()->json($response , 200);

        }else{
            $response = APIHelpers::createApiResponse(true , 406 , 'This Unique Id Not Registered' , 'This Unique Id Not Registered' , null , $request->lang);
            return response()->json($response , 406);
        }

    }

    // remove from cart
    public function delete(Request $request){
        $validator = Validator::make($request->all(), [
            'unique_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }

        $visitor = Visitor::where('unique_id' , $request->unique_id)->first();
        if($visitor){

            if($request->product_id){
                $cart = Cart::where('product_id' , $request->product_id)->where('visitor_id' , $visitor->id)->first();
                $cart->delete();
            }else{
                Cart::where('visitor_id' , $visitor->id)->delete();
            }


            $response = APIHelpers::createApiResponse(false , 200 , '' , '' , null , $request->lang);
            return response()->json($response , 200);

        }else{
            $response = APIHelpers::createApiResponse(true , 406 , 'This Unique Id Not Registered' , 'This Unique Id Not Registered' , null , $request->lang);
            return response()->json($response , 406);
        }



    }

    // get cart
    public function get(Request $request){
        $toCurr = trim(strtolower($request->curr));
        if ($toCurr == "kwd") {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
        }
        
        $validator = Validator::make($request->all(), [
            'unique_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }

        $visitor = Visitor::where('unique_id' , $request->unique_id)->first();
        if($visitor){
            $visitor_id =  $visitor['id'];
            $cart = Cart::where('visitor_id' , $visitor_id)->select('product_id as id' , 'count', 'method', 'delivery_cost')->get();
            
            $data['subtotal_price'] = 0;
            for($i = 0; $i < count($cart); $i++){
                if($request->lang == 'en'){
                    $product = Product::select('title_en as title' , 'final_price' , 'price_before_offer', 'offer', 'offer_percentage', 'company_id')->find($cart[$i]['id']);
                    $company = Company::where('id', $product['company_id'])->select('title_en as title')->first();
                    $deliveryMethod = DeliveryMethod::where('id', $cart[$i]['method'])->select('title_en as title', 'price')->first();
                }else{
                    $product = Product::select('title_ar as title' , 'final_price' , 'price_before_offer', 'offer', 'offer_percentage', 'company_id')->find($cart[$i]['id']);
                    $company = Company::where('id', $product['company_id'])->select('title_ar as title')->first();
                    $deliveryMethod = DeliveryMethod::where('id', $cart[$i]['method'])->select('title_ar as title', 'price')->first();
                }

                if(auth()->user()){
                    $user_id = auth()->user()->id;
                    $prevfavorite = Favorite::where('product_id' , $cart[$i]['id'])->where('user_id' , $user_id)->first();
                    if($prevfavorite){
                        $cart[$i]['favorite'] = true;
                    }else{
                        $cart[$i]['favorite'] = false;
                    }
    
                }else{
                    $cart[$i]['favorite'] = false;
                }

                $cart[$i]['title'] = $product['title'];
                $cart[$i]['final_price'] = $product['final_price'];
                $cart[$i]['price_before_offer'] = $product['price_before_offer'];
				$cart[$i]['offer'] = $product['offer'];
				$cart[$i]['offer_percentage'] = $product['offer_percentage'];
				$cart[$i]['company_id'] = $product['company_id'];
                $cart[$i]['company_name'] = $company['title'];
                $cart[$i]['delivery_method_title'] = $deliveryMethod['title'];
                $cart[$i]['delivery_method_price'] = $cart[$i]['delivery_cost'];
                
                $cart[$i]['image'] = ProductImage::select('image')->where('product_id' , $cart[$i]['id'])->first()['image'];
                if($request->curr != 'kwd'){
                    $cart[$i]['final_price'] = $product['final_price'] * $currency['value'];
                    $pBO = $product['price_before_offer'] * $currency['value'];
                    $cart[$i]['price_before_offer'] = number_format((float)$pBO, 3, '.', '');
                    $dCost = $cart[$i]['delivery_cost'] * $currency['value'];
                    $cart[$i]['delivery_cost'] = number_format((float)$dCost, 3, '.', '');
                    $deliveryMP = $cart[$i]['delivery_method_price'] * $currency['value'];
                    $cart[$i]['delivery_method_price'] = number_format((float)$deliveryMP, 3, '.', '');
                    // dd($currency['value']);
                }
                $data['subtotal_price'] = $data['subtotal_price'] + ($cart[$i]['final_price'] * $cart[$i]['count']);
            }
            
            $data['cart'] = $cart;
            $data['count'] = count($cart);
            
            $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
            return response()->json($response , 200);

        }else{
            $response = APIHelpers::createApiResponse(true , 406 , 'This Unique Id Not Registered' , 'This Unique Id Not Registered' , null , $request->lang);
            return response()->json($response , 406);
        }
        

    }

    // get cart count 
    public function getcartcount(Request $request){
        $validator = Validator::make($request->all(), [
            'unique_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }

        $visitor = Visitor::where('unique_id' , $request->unique_id)->first();
        if($visitor){

            $visitor_id =  $visitor['id'];
            $cart = Cart::where('visitor_id' , $visitor_id)->select('product_id as id' , 'count')->get();
            $count['count'] = count($cart);

            $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $count , $request->lang);
            return response()->json($response , 200);

        }else{
            $response = APIHelpers::createApiResponse(true , 406 , 'This Unique Id Not Registered' , 'This Unique Id Not Registered' , null , $request->lang);
            return response()->json($response , 406);
        }
    }

    // change count
    public function changecount(Request $request){
 
        $validator = Validator::make($request->all(), [
            'unique_id' => 'required',
            'product_id' => 'required',
            'new_count' => 'required'
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }

        $visitor = Visitor::where('unique_id' , $request->unique_id)->first();

        $product = Product::find($request->product_id);
        if($product->remaining_quantity < $request->new_count){
            $response = APIHelpers::createApiResponse(true , 406 , 'The remaining amount of the product is not enough' , 'الكميه المتبقيه من المنتج غير كافيه'  , null , $request->lang);
            return response()->json($response , 406);
        }

        if($visitor){

            $cart = Cart::where('product_id' , $request->product_id)->where('visitor_id' , $visitor->id)->first();
            $cart->count = $request->new_count;
            $cart->save();
            $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $cart , $request->lang);
            return response()->json($response , 200);

        }else{
            $response = APIHelpers::createApiResponse(true , 406 , 'This Unique Id Not Registered' , 'This Unique Id Not Registered' , null , $request->lang);
            return response()->json($response , 406);
        }
        
    }

    // delete all


}