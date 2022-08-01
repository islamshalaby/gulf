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
use App\DeliveryArea;
use App\UserAddress;

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
            $shippingExist = Cart::where('visitor_id' , $visitor->id)->first();
            if ($request->method != 3 && $shippingExist && $shippingExist->method == 3) {
                $response = APIHelpers::createApiResponse(true , 406 , 'You can not add products without shipping .. remove products in cart first' , 'لا يمكنك إضافة منتجات بدون شحن دولى للعربة .. إمسح المنتجات الموجودة بالعربة أولاً' , null , $request->lang);
                return response()->json($response , 406);
            }elseif ($request->method == 3 && $shippingExist && $shippingExist->method != 3) {
                $response = APIHelpers::createApiResponse(true , 406 , 'You can not add products with shipping .. remove products in cart first' , 'لا يمكنك إضافة منتجات شحن دولى للعربة .. إمسح المنتجات الموجودة بالعربة أولاً' , null , $request->lang);
                return response()->json($response , 406);
            }else {
                $cart = Cart::where('visitor_id' , $visitor->id)->where('product_id' , $request->product_id)->where('method', $request->method)->first();
                $product = Product::find($request->product_id);
                if($product->remaining_quantity < 1){
                    $response = APIHelpers::createApiResponse(true , 406 , 'The remaining amount of the product is not enough' , 'الكميه المتبقيه من المنتج غير كافيه'  , null , $request->lang);
                    return response()->json($response , 406);
                }
                
                $installationCost = "0.000";
                if ($request->method == 2) {
                    $installationCost = $product->installation_cost;
                }
                $deliveryMethod = DeliveryMethod::where('id', $request->method)->select('price')->first();
                
                if($cart){
                    $count = $cart->count;
                    $cart->count = $count + 1;
                    $cart->installation_cost = $installationCost;
                    // $cart->delivery_cost = $deliveryCost;
                    $cart->save();
                }else{
                    $cart = new Cart();
                    $cart->count = 1;
                    $cart->product_id = $request->product_id;
                    $cart->visitor_id = $visitor->id;
                    $cart->method = $request->method;
                    $cart->installation_cost = $installationCost;
                    // $cart->delivery_cost = $deliveryCost;
                    $cart->save();
                }
    
                $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $cart , $request->lang);
                return response()->json($response , 200);
            }
            

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
            $cart = Cart::where('visitor_id' , $visitor_id)->select('product_id as id' , 'count', 'method', 'delivery_cost', 'installation_cost')->get()->makeHidden('delivery_cost');
            
            $data['subtotal_price'] = "0.000";
            $data['delivery_cost'] = "0.000";
            $data['installation_cost'] = "0.000";
            $data['total_shipping_cost'] = "0.000";
            $pluckProducts = Cart::where('visitor_id' , $visitor_id)->pluck('product_id')->toArray();
            $pluckCompanies = Product::whereIn('id', $pluckProducts)->pluck("company_id")->toArray();
            $sumCompaniesShipping = "0.000";
            
            if (isset($request->address_id) && $request->address_id != 0) {
                $address = UserAddress::where('id', $request->address_id)->select('area_id')->first();
                $sumCompaniesShipping = DeliveryArea::whereIn('store_id', $pluckCompanies)->where('area_id', $address['area_id'])->sum('delivery_cost');
                $iso_code = $address->goveronrateArea->governorate->country->iso_code;
            }
            for($i = 0; $i < count($cart); $i++){
                if($request->lang == 'en'){
                    $product = Product::select('title_en as title' , 'final_price' , 'price_before_offer', 'offer', 'offer_percentage', 'company_id', 'weight', 'width', 'height', 'length')->find($cart[$i]['id']);
                    $company = Company::where('id', $product['company_id'])->select('title_en as title')->first();
                }else{
                    $product = Product::select('title_ar as title' , 'final_price' , 'price_before_offer', 'offer', 'offer_percentage', 'company_id', 'weight', 'width', 'height', 'length')->find($cart[$i]['id']);
                    $company = Company::where('id', $product['company_id'])->select('title_ar as title')->first();
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
                $fPrice = $product['final_price'] * $currency['value'];
                $cart[$i]['final_price'] = number_format((float)$fPrice, 3, '.', '');
                $pBPrice = $product['price_before_offer'] * $currency['value'];
                $cart[$i]['price_before_offer'] = number_format((float)$pBPrice, 3, '.', '');
				$cart[$i]['offer'] = $product['offer'];
				$cart[$i]['offer_percentage'] = $product['offer_percentage'];
				$cart[$i]['company_id'] = $product['company_id'];
                $cart[$i]['company_name'] = $company['title'];
                
                $cart[$i]['image'] = ProductImage::select('image')->where('product_id' , $cart[$i]['id'])->first()['image'];
                $subTP = ($data['subtotal_price'] + ($cart[$i]['final_price'] * $cart[$i]['count'])) * $currency['value'];
                $data['subtotal_price'] = number_format((float)$subTP, 3, '.', '');
                
                $iCost = ($data['installation_cost'] + ($cart[$i]['installation_cost'] * $cart[$i]['count']));
                $data['installation_cost'] = number_format((float)$iCost, 3, '.', '');
                $cart[$i]['shipping_cost'] = "0.000";
                if ($cart[$i]['method'] == 3 && isset($request->address_id) && $request->address_id != 0) {
                    $createClient = $this->createClient();
                    $soapClient = $createClient['soapClient'];
                    $dataShipping['CI'] = $createClient['ci'];
                    
                    $ScaleWeight = 0;
                    $Width = 0;
                    $Length = 0;
                    $Height = 0;
                    if (!empty($product->weight)) {
                        $ScaleWeight = $product->weight * $cart[$i]['count'];
                    }
                    if (!empty($product->Length)) {
                        $Length = $product->Length;
                    }
                    if (!empty($product->height)) {
                        $Height = $product->height;
                    }
                    if (!empty($product->width)) {
                        $Width = $product->width;
                    }
                    $dataShipping['SI'] = [
                        'DestinationCountryCode' => $iso_code,
                        'ScaleWeight' => $ScaleWeight,
                        'Length' => $Length,
                        'Height' => $Height,
                        'Width' => $Width,
                        'RateSheetType' => 'NONDOC',
                        'OriginCountryCode' => 'KW',
                        'DestinationCityCode' => ''
                    ];
                    
                    $res = $soapClient->__SoapCall('ShipmentCostCalculationInfo', [$dataShipping]);
                    // dd($res);
                    $cart[$i]['shipping_cost'] = $res->ShipmentCostCalculationInfoResult->Amount * $currency['value'];
                    $cart[$i]['shipping_cost'] = number_format((float)$cart[$i]['shipping_cost'], 3, '.', '');
                    $data['total_shipping_cost'] = $cart[$i]['shipping_cost'] + $data['total_shipping_cost'];
                }
            }
            $data['hide_cash'] = false;
            // dd($cart[0]['method']);
            if (isset($cart[0]) && $cart[0]['method'] == 3) {
                $data['hide_cash'] = true;
                $data['delivery_cost'] = "0.000";
                $tCost = ($data['subtotal_price'] + $data['installation_cost'] + $data['total_shipping_cost']);
            }else {
                $totalDCost = $sumCompaniesShipping * $currency['value'];
                $data['delivery_cost'] = number_format((float)$totalDCost, 3, '.', '');
                $tCost = ($data['delivery_cost'] + $data['subtotal_price'] + $data['installation_cost']);
            }
            
            $data['total_shipping_cost'] = number_format((float)$data['total_shipping_cost'], 3, '.', '');
            
            $data['total_cost'] = number_format((float)$tCost, 3, '.', '');
            
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