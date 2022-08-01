<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserAddress;
use App\Shipment;
use App\Visitor;
use App\Product;
use App\ProductImage;
use App\Cart;
use App\Order;
use App\OrderItem;
use App\DeliveryMethod;
use App\Company;
use App\Currency;
use App\DeliveryArea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\APIHelpers;
use App\Setting;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' , ['except' => ['excute_pay' , 'pay_sucess' , 'pay_error']]);
    }
    
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'unique_id' => 'required',
            'address_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة'  , null , $request->lang);
            return response()->json($response , 406);
        }

        $user_id = auth()->user()->id;
        $visitor  = Visitor::where('unique_id' , $request->unique_id)->first();
        $user_id_unique_id = $visitor->user_id;
        $visitor_id = $visitor->id;
        $cart = Cart::where('visitor_id' , $visitor_id)->get();

        if(count($cart) == 0){
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة'  , null , $request->lang);
            return response()->json($response , 406);
        }

        $sub_total_price = "0.000";
        $deliveryCost = "0.000";
        $installationCost = "0.000";
        $address = UserAddress::where('id', $request->address_id)->select('area_id')->first();
        
        $pluckProducts = Cart::where('visitor_id' , $visitor_id)->pluck('product_id')->toArray();
        $pluckCompanies = Product::whereIn('id', $pluckProducts)->pluck("company_id")->toArray();
        $sumCompaniesShipping = DeliveryArea::whereIn('store_id', $pluckCompanies)->where('area_id', $address['area_id'])->sum('delivery_cost');
        
        if ($sumCompaniesShipping) {
            $deliveryCost = number_format((float)$sumCompaniesShipping, 3, '.', '');
        }
        
        for($i = 0; $i < count($cart); $i++){
            $product = Product::select('id' , 'final_price' , 'remaining_quantity', 'installation_cost')->find($cart[$i]['product_id']);
            if($product->remaining_quantity < $cart[$i]['count']){
                $response = APIHelpers::createApiResponse(true , 406 , 'The remaining amount of the product is not enough' , 'الكميه المتبقيه من المنتج غير كافيه'  , null , $request->lang);
                return response()->json($response , 406);
            }
            
            $sub_total_price = $sub_total_price + ($product['final_price'] * $cart[$i]['count']);
            $installationCost = $installationCost + ($cart[$i]['installation_cost'] * $cart[$i]['count']);
        }

        if($request->payment_method == 1){
            if (count($cart) > 0 && $cart[0]['method'] == 3) {
                $response = APIHelpers::createApiResponse(true , 406 , 'Shipment only available with online payment' , 'الشحن الدولى متاح فقط مع الدفع اون لاين'  , null , $request->lang);
                return response()->json($response , 406);
            }
            $order = new Order();
            $order->user_id = $user_id;
            $order->address_id = $request->address_id;
            $order->payment_method = $request->payment_method;
            $sub_total_price = number_format((float)$sub_total_price, 3, '.', '');
            $order->subtotal_price = $sub_total_price;
            $order->delivery_cost = $deliveryCost;
            $order->installation_cost = $installationCost;
            $order->total_price = $sub_total_price + $deliveryCost + $installationCost;
            $str = 'abcdefghijklmnopqrstuvwxyz';
            $order->order_number = substr(str_shuffle(uniqid() . $str) , -7);
            $order->save();

            for($i = 0; $i < count($cart); $i++){
                $product = Product::where('id', $cart[$i]['product_id'])->select('final_price', 'price_before_offer', 'company_id')->first();
                $order_item = new OrderItem();
                $order_item->order_id = $order->id;
                $order_item->product_id = $cart[$i]['product_id'];
                $order_item->count = $cart[$i]['count'];
                $order_item->installation_cost = $cart[$i]['installation_cost'];
                $order_item->shipping = $cart[$i]['method'];
                $order_item->final_price = $product['final_price'];
                $order_item->price_before_offer = $product['price_before_offer'];
                $order_item->final_with_delivery = $product['final_price'] * $cart[$i]['count'];
                $order_item->total_installation = $cart[$i]['installation_cost'] * $cart[$i]['count'];
                $order_item->company_id = $product['company_id'];
                $order_item->save();
                $cartItem = Cart::find($cart[$i]['id']);
                $cartItem->delete();                        
            }

            $data = (object)['url' => ''];

            $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
            return response()->json($response , 200);
        }else{
            $root_url = $request->root();
            $user = auth()->user();

            $path='https://api.myfatoorah.com/v2/SendPayment';
            $token="bearer NzayASut0b87tNogaYyczrdiKSK-aJXUBwQ0k_8oW-xvzec_gnsQh3OZFNIm_5OhgpV_xNrw_55G8PL1XcIFOWerfWU_76Y-Sp3fUC0cFMmXWYnCmagkT7ee7h9A8qlvFANQpN94XgQ5L4jekSX6-d1XzrssifVlQoYwFAB6M12yy_m7FxveonieCnyUrFDRihWcJmyE1aNU4lnw7kOWEnoAg4ESu1FF42-MJ9AgmOv1VFFk-wTpp_3_ndzdgAFaG1BjMl4zmG3SExoUilYj48wtGQlrzDkkWw5s-XFlTb7s3w8wYT1TwaF0H7Jqs2ciP4HglqpPZUdxpbJJbWKG5vfkj1_DgDc9uo6KfZaKQYVvDkwg8yyMvXiMw9WZR-AdEpKnMK3ntRT31m3h6Zmuy0lH5IN2oRoQ1j4qSb9WjUNJeN0A0ViP_YSbdWPpn_JKKqVeGF7UQybE2qTaeqpjtTVk8aMXVQ9wZGgeqowAtuMBCmmg1Vny-9m13A3PkzP3GeAH78iEkwHjSDkLlIgAvzson1YOSFr5c1ZqLP9NLxSJQKzIsk-eTbrfyQsTpJg7EkaCri01e5ibPhTYd0eyZ1vSAMgBPjwTO2puf1Qw5p9bEsaJvUJ7HaR5OmKAAGgdEp9_h3bWf7SACNWJ8G-jtu5XOOkS9qkBXZxuUSJa-1OM959c";
            $testPath='https://apitest.myfatoorah.com/v2/SendPayment';
            $testToken="bearer rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL";

            $headers = array(
                'Authorization:' .$testToken,
                'Content-Type:application/json'
            );
            $price = $sub_total_price + $deliveryCost;
            
            $call_back_url = $root_url."/api/ecommerce/excute_pay?user_id=".$user->id."&unique_id=".$request->unique_id."&address_id=".$request->address_id;
            $error_url = $root_url."/api/ecommerce/pay/error";
            $fields =array(
                "CustomerName" => $user->name,
                "NotificationOption" => "LNK",
                "InvoiceValue" => $price,
                "CallBackUrl" => $call_back_url,
                "ErrorUrl" => $error_url,
                "Language" => "AR",
                "CustomerEmail" => $user->email
            );  

            $payload =json_encode($fields);
            $curl_session =curl_init();
            curl_setopt($curl_session,CURLOPT_URL, $testPath);
            curl_setopt($curl_session,CURLOPT_POST, true);
            curl_setopt($curl_session,CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl_session,CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_session,CURLOPT_IPRESOLVE, CURLOPT_IPRESOLVE);
            curl_setopt($curl_session,CURLOPT_POSTFIELDS, $payload);
            $result=curl_exec($curl_session);
            curl_close($curl_session);
            $result = json_decode($result);
            
            $data['url'] = $result->Data->InvoiceURL;
            
            $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' , $data , $request->lang );
            return response()->json($response , 200);
        }
    }


    public function excute_pay(Request $request){
        $user = User::find($request->user_id);
        $user_id = $user->id;
        $visitor  = Visitor::where('unique_id' , $request->unique_id)->first();
        $user_id_unique_id = $visitor->user_id;
        $visitor_id = $visitor->id;
        $cart = Cart::where('visitor_id' , $visitor_id)->get();

        $sub_total_price = "0.000";
        $deliveryCost = "0.000";
        $installationCost = "0.000";
        $address = UserAddress::where('id', $request->address_id)->select('area_id')->first();
        $pluckProducts = Cart::where('visitor_id' , $visitor_id)->pluck('product_id')->toArray();
        $pluckCompanies = Product::whereIn('id', $pluckProducts)->pluck("company_id")->toArray();
        
        for($i = 0; $i < count($cart); $i++){
            $product = Product::select('id' , 'final_price' , 'remaining_quantity', 'installation_cost', 'description_en')->find($cart[$i]['product_id']);
            if($product->remaining_quantity < $cart[$i]['count']){
                $response = APIHelpers::createApiResponse(true , 406 , 'The remaining amount of the product is not enough' , 'الكميه المتبقيه من المنتج غير كافيه'  , null , $request->lang);
                return response()->json($response , 406);
            }
            
            $sub_total_price = $sub_total_price + ($product['final_price'] * $cart[$i]['count']);
            $installationCost = $installationCost + ($cart[$i]['installation_cost'] * $cart[$i]['count']);
        }

        
        $order = new Order();
        $order->user_id = $user_id;
        $order->address_id = $request->address_id;
        $order->payment_method = 2;
        $order->subtotal_price = $sub_total_price;
        $order->delivery_cost = $deliveryCost;
        $order->installation_cost = $installationCost;
        $total = "0.000";
        if (count($cart) > 0 && $cart[0]['method'] != 3) {
            $sumCompaniesShipping = DeliveryArea::whereIn('store_id', $pluckCompanies)->where('area_id', $address['area_id'])->sum('delivery_cost');
            if ($sumCompaniesShipping) {
                $deliveryCost = $sumCompaniesShipping;
            }
        }
        $total = $sub_total_price + $deliveryCost + $installationCost;
        $str = 'abcdefghijklmnopqrstuvwxyz';
        $order->order_number = substr(str_shuffle(uniqid() . $str) , -7);
        $order->save();
        $shipmentCost = "0.000";
        for($i = 0; $i < count($cart); $i++){
            // shipment
                $product = Product::where('id', $cart[$i]['product_id'])->select('final_price', 'price_before_offer', 'company_id', 'description_en', 'origin_country', 'width', 'length', 'height', 'weight', 'title_en')->first();
                $order_item = new OrderItem();
                $order_item->order_id = $order->id;
                $order_item->product_id = $cart[$i]['product_id'];
                $order_item->count = $cart[$i]['count'];
                $order_item->installation_cost = $cart[$i]['installation_cost'];
                $order_item->shipping = $cart[$i]['method'];
                $order_item->final_price = $product['final_price'];
                $order_item->price_before_offer = $product['price_before_offer'];
                $order_item->final_with_delivery = $product['final_price'] * $cart[$i]['count'];
                $order_item->total_installation = $cart[$i]['installation_cost'] * $cart[$i]['count'];
                $order_item->company_id = $product['company_id'];
                if ($cart[$i]['method'] == 3) {
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
                        'DestinationCountryCode' => $order->address->goveronrateArea->governorate->country->iso_code,
                        'ScaleWeight' => $ScaleWeight,
                        'Length' => $Length,
                        'Height' => $Height,
                        'Width' => $Width,
                        'RateSheetType' => 'NONDOC',
                        'OriginCountryCode' => 'KW',
                        'DestinationCityCode' => ''
                    ];
                    $shippingCost = $soapClient->__SoapCall('ShipmentCostCalculationInfo', [$dataShipping]);
                    $order_item->shipping_cost = $shippingCost->ShipmentCostCalculationInfoResult->Amount;
                    $shipmentCost = $shipmentCost + $shippingCost->ShipmentCostCalculationInfoResult->Amount;
                    
                    $senderSettings = Setting::where('id', 1)->first();
                    $homePhone = $user->phone;
                    $whatsapp = "";
                    $originCountry = "KW";
                    $senderHomePhone = $senderSettings->phone;
                    if (!empty($user->phone2)) {
                        $homePhone = $user->phone2;
                    }
                    if (!empty($user->whatsapp_number)) {
                        $whatsapp = $user->whatsapp_number;
                    }
                    if (!empty($product->origin_country)) {
                        $originCountry = $product->origin_country;
                    }
                    if (!empty($senderSettings->phone2)) {
                        $senderHomePhone = $senderSettings->phone2;
                    }
                    //dd(substr($product->description_en, 0, 190));
                    $data_shipment = [
                        'sender_email' => $senderSettings->email,
                        'receiver_email' => $user->email,
                        'receiver_phone' => str_replace("+", "", $homePhone),
                        'receiver_mobile' => str_replace("+", "", $user->phone),
                        'receiver_whats' => str_replace("+", "", $whatsapp),
                        'shipment_description' => $product->title_en,
                        'product_description' => $product->title_en,
                        'product_origin_country' => $originCountry,
                        'quantity' => $cart[$i]['count'],
                        'unit_price' => $product['final_price'],
                        'packages_number' => 1,
                        'order_number' => $order->order_number,
                        'receiver_id' => $user->id,
                        'receiver_name' => $user->name,
                        'sender_address' => $senderSettings->address_en,
                        'sender_country' => "KW",
                        'sender_mobile' => str_replace("+", "", $senderSettings->phone),
                        'sender_name' => $senderSettings->app_name_en,
                        'sender_phone' => str_replace("+", "", $senderHomePhone),
                        'receiver_address' => $order->address->goveronrateArea->title_ar . ", ش " . $order->address->street  . ", قطعة " . $order->address->piece  . ", جاده " . $order->address->gaddah,
                        'receiver_country' => $order->address->goveronrateArea->governorate->country->iso_code,
                        'receiver_mobile' => str_replace("+", "", $user->phone),
                        'receiver_name' => $user->name,
                        'receiver_phone' => str_replace("+", "", $homePhone),
                        'weight' => $product->weight
                    ];
                    $totalShippingCost = ($shippingCost->ShipmentCostCalculationInfoResult->Amount * $cart[$i]['count']) + ($product['final_price'] * $cart[$i]['count']);
                    $receiverCity = "NA";
                    if (!empty($order->address->goveronrateArea->city_code)) {
                        $receiverCity = $order->address->goveronrateArea->city_code;
                    }
    
                    // create shpment
                    $shipment = $this->createShipment($data_shipment, $totalShippingCost, $receiverCity, $Height, $Length, $Width);
                    $order_item->save();
                    // Shipment_CreationResult
                    Shipment::create(['order_id' => $order_item->id, 'airway_bill_number' => strval($shipment->Shipment_CreationResult)]);
                }else {
                    $order_item->save();
                }
                
               
            
            $cartItem = Cart::find($cart[$i]['id']);
            $cartItem->delete();                        
        }

        $thisOrder = Order::where('id', $order->id)->first();
        $thisOrder->shipping_cost = $shipmentCost;
        $thisOrder->total_price = $total + $shipmentCost;
        $thisOrder->save();

        return redirect('api/ecommerce/pay/success'); 
    }

    public function pay_sucess(){
        return "Please wait ...";
    }

    public function pay_error(){
        return "Please wait ...";
    }


    public function getorders(Request $request){
        $toCurr = trim(strtolower($request->curr));
        if ($toCurr == "kwd") {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
        }
        $user_id = auth()->user()->id;
        $orders = Order::where('user_id' , $user_id)->select('id' , 'status' , 'order_number' , 'created_at as date' , 'total_price' , 'status')->orderBy('id' , 'desc')->get();
		
        $ordersDays = Order::where('user_id' , $user_id)->orderBy('id' , 'desc')->pluck('created_at')->toArray();
        
        for ($k = 0; $k < count($ordersDays); $k ++) {
            $ordersDays[$k] = date_format(date_create($ordersDays[$k]) , "d-m-Y");
        }
		
        $unrepeated_days1 = array_unique($ordersDays);
		$unrepeated_days = [];
        foreach ($unrepeated_days1 as $key => $value) {
			array_push($unrepeated_days, $value); 
		}
        $data = [];
        $days = [];
		
        for ($n = 0; $n < count($unrepeated_days); $n ++) {
            
            $dayOrders = [];
            for($i = 0; $i < count($orders); $i++){
                if ($unrepeated_days[$n] == date_format(date_create($orders[$i]['date']), "d-m-Y")) {
                    $date = date_create($orders[$i]['date']);
                    
                    $ordercount = OrderItem::where('order_id' , $orders[$i]['id'])->pluck('count')->toArray();
                    $orders[$i]['count'] = array_sum($ordercount);
                    $tPrice = $orders[$i]['total_price'];
                    if($request->curr != 'kwd'){
                        $totalPrice = $orders[$i]['total_price'] * $currency['value'];
                        $tPrice = number_format((float)$totalPrice, 3, '.', '');
                    }
                    $dayOrder = (object)[
						'id' => $orders[$i]['id'],
                        'date' => date_format($date , "d-m-Y"),
                        'count' => array_sum($ordercount),
                        'status' => $orders[$i]['status'],
                        'order_number' => $orders[$i]['order_number'],
                        'total_price' => $tPrice
                    ];

                    array_push($dayOrders, $dayOrder);
                }
                
            }
            
            $data[$n]['day'] = $unrepeated_days[$n];
            $data[$n]['orders'] = $dayOrders;
        }
        
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }
    
    public function orderdetails(Request $request){
        $toCurr = trim(strtolower($request->curr));
        if ($toCurr == "kwd") {
            $currency = ["value" => 1];
        }else {
            $currency = Currency::where('from', "kwd")->where('to', $toCurr)->first();
        }
        $order_id = $request->id;
        $order = Order::find($order_id);
        $data['id'] = $order->id;
        $data['order_number'] = $order->order_number;
        $date = date_create($order->created_at);
        $data['date'] = date_format($date ,  'd-M-Y');
        $data['status'] = $order->status;
        $data['subtotal_price'] = $order->subtotal_price;
        $data['delivery_cost'] = $order->delivery_cost;
        $data['total_price'] = $order->total_price;
        $data['installation_cost'] = $order->installation_cost;
        
        $totalPrice = $order->total_price * $currency['value'];
        $data['total_price'] = number_format((float)$totalPrice, 3, '.', '');
        $subPrice = $order->subtotal_price * $currency['value'];
        $data['subtotal_price'] = number_format((float)$subPrice, 3, '.', '');
        $dCost = $order->delivery_cost * $currency['value'];
        $data['delivery_cost'] = number_format((float)$dCost, 3, '.', '');
        $iCost = $order->installation_cost * $currency['value'];
        $data['installation_cost'] = number_format((float)$iCost, 3, '.', '');
        $shipping = $order->shipping_cost * $currency['value'];
        $data['total_shipping_cost'] = number_format((float)$shipping, 3, '.', '');
        $totalWithoutInstallation = $data['total_price'] - $data['installation_cost'];
        $data['total_without_installation'] = number_format((float)$totalWithoutInstallation, 3, '.', '');
        
        $data['payment_method'] = $order->payment_method;
        $data['products_count'] = OrderItem::where('order_id' , $order_id)->count();
        $ids = OrderItem::where('order_id' , $order_id)->select('id','product_id', 'shipping', 'status', 'installation_cost', 'shipping_cost')->get()->toArray();
        // dd();
        $products = [];
        for($i = 0; $i < count($ids); $i++){
            if($request->lang == 'en'){
                $product = Product::select('id' , 'title_en as title' , 'final_price as price', 'company_id')->find($ids[$i]['product_id'])->makeHidden('company_id');
				$company = Company::where('id', $product['company_id'])->select('title_en as title')->first();
                $product['delivery_method'] = DeliveryMethod::where('id', $ids[$i]['shipping'])->select('title_en as title')->first();
            }else{
                $product = Product::select('id' , 'title_ar as title' , 'final_price as price', 'company_id')->find($ids[$i]['product_id'])->makeHidden('company_id');
				$company = Company::where('id', $product['company_id'])->select('title_ar as title')->first();
                $product['delivery_method'] = DeliveryMethod::where('id', $ids[$i]['shipping'])->select('title_ar as title')->first();
            }
            
            $pPrice = $product['price'] * $currency['value'];
            $product['price'] = number_format((float)$pPrice, 3, '.', '');
            $product['shipping'] = $ids[$i]['shipping'];
            $product['status'] = $ids[$i]['status'];
            $product['shipping_number'] = "";
            $shipment = Shipment::where('order_id', $ids[$i]['id'])->first();
            if ($shipment) {
                $product['shipping_number'] = $shipment->airway_bill_number;
            }
            
            $product['shipping_cost'] = $ids[$i]['shipping_cost'];
            $product['count'] = OrderItem::find($ids[$i]['id'])['count'];
            
            $product['company'] = $company['title'];
            $product['installation_cost'] = $ids[$i]['installation_cost'];
            $product['image'] = ProductImage::where('product_id' , $product->id)->first()['image'];
			$product['product_id'] = $product['id'];
			$product['id'] = $ids[$i]['id'];
			
            array_push($products , $product);
        }
        $address = UserAddress::select('gaddah' , 'building' , 'floor' , 'apartment_number' , 'street')->find($order->address_id);
        if($address){
            $data['address'] = $address;
        }else{
            $data['address'] = new \stdClass();
        }

        $data['products'] = $products;
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);

    }
	
	// cancel item
    public function cancelItem(Request $request) {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'reason' => 'required'
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }
        $item = OrderItem::find($request->item_id);
        $shipment = Shipment::where('order_id', $request->item_id)->first();
        
        if (!isset($item['id'])) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Item is not exist' , 'عنصر غير موجود' , null , $request->lang);
            return response()->json($response , 406);
        }
        if ($item->order->status != 1) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Order is not current' , 'الطلب ليس جارى' , null, $request->lang);
            return response()->json($response , 406);
        }

        if ($shipment) {
            $shipRes = $this->cancelShipment($shipment->airway_bill_number, $request->reason);
            if ($shipRes && $shipRes->ShipmentVoidResult == 'Shipment Void Successfully') {
                $dcost = $item->order['delivery_cost'];
                $incost = $item->order['installation_cost'];
                $subTotal = $item->order['subtotal_price'] - ($item->final_price * $item->count);
                $subTotal = number_format((float)$subTotal, 3, '.', '');
                $incost = $incost - ($item->installation_cost * $item->count);
                $incost = number_format((float)$incost, 3, '.', '');
                $item->update([
                    'status' => 5,// canceled
                    'final_price' => '0.000',
                    'price_before_offer' => '0.000',
                    'installation_cost' => '0.000',
                    'shipping_cost' => '0.000'
                ]);

                $item->product->remaining_quantity = $item->product->remaining_quantity + $item->count;
                $item->product->save();

                $companyCanceledOrder = OrderItem::where('order_id', $item->order_id)->where('company_id', $item->company_id)->where('status', 5)->count('id');
                $companyOrder = OrderItem::where('order_id', $item->order_id)->where('company_id', $item->company_id)->count('id');
                $orderStatus = $item->order->status;
                if (count($item->order->canceledItems) == count($item->order->oItems)) {
                    $orderStatus = 5;
                }
                $totalShipping = $item->order->shipping_cost;
                if ($shipment) {
                    $totalShipping = $totalShipping - $item->shipping_cost;
                }else {
                    if ($companyCanceledOrder == $companyOrder) {
                        $companyDelivery = DeliveryArea::where('store_id', $item->company_id)->where('area_id', $item->order->address->area_id)->select('delivery_cost')->first();
                        $dcost = $dcost - $companyDelivery['delivery_cost'];
                    }
                }

                $item->order->update([
                    'subtotal_price' => $subTotal,
                    'delivery_cost' => $dcost,
                    'installation_cost' => $incost,
                    'shipping_cost' => $totalShipping,
                    'total_price' => $subTotal + $dcost + $incost,
                    'status' => $orderStatus
                ]);
                

                $response = APIHelpers::createApiResponse(false , 200 , '' , '' , '' , $request->lang);
                return response()->json($response , 200);
            }else {
                $response = APIHelpers::createApiResponse(true , 406 , 'Cancele failed .. Product has been shipped' , 'فشل إلغاء المنتج .. المنتج تم شحنه' , null, $request->lang);
                return response()->json($response , 406);
            }
        }else {
            $dcost = $item->order['delivery_cost'];
            $incost = $item->order['installation_cost'];
            $subTotal = $item->order['subtotal_price'] - ($item->final_price * $item->count);
            $subTotal = number_format((float)$subTotal, 3, '.', '');
            $incost = $incost - ($item->installation_cost * $item->count);
            $incost = number_format((float)$incost, 3, '.', '');
            $item->update([
                'status' => 5,// canceled
                'final_price' => '0.000',
                'price_before_offer' => '0.000',
                'installation_cost' => '0.000',
                'shipping_cost' => '0.000'
            ]);
    
            $item->product->remaining_quantity = $item->product->remaining_quantity + $item->count;
            $item->product->save();
    
            $companyCanceledOrder = OrderItem::where('order_id', $item->order_id)->where('company_id', $item->company_id)->where('status', 5)->count('id');
            $companyOrder = OrderItem::where('order_id', $item->order_id)->where('company_id', $item->company_id)->count('id');
            $orderStatus = $item->order->status;
            if (count($item->order->canceledItems) == count($item->order->oItems)) {
                $orderStatus = 5;
            }
            $totalShipping = $item->order->shipping_cost;
            if ($shipment) {
                $totalShipping = $totalShipping - $item->shipping_cost;
            }else {
                if ($companyCanceledOrder == $companyOrder) {
                    $companyDelivery = DeliveryArea::where('store_id', $item->company_id)->where('area_id', $item->order->address->area_id)->select('delivery_cost')->first();
                    $dcost = $dcost - $companyDelivery['delivery_cost'];
                }
            }
    
            $item->order->update([
                'subtotal_price' => $subTotal,
                'delivery_cost' => $dcost,
                'installation_cost' => $incost,
                'total_price' => $subTotal + $dcost + $incost,
                'status' => $orderStatus
            ]);
            
    
            $response = APIHelpers::createApiResponse(false , 200 , '' , '' , '' , $request->lang);
            return response()->json($response , 200);
        }
    }

}