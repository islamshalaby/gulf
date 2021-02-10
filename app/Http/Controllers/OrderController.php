<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserAddress;
use App\Area;
use App\Visitor;
use App\Product;
use App\ProductImage;
use App\Cart;
use App\Order;
use App\OrderItem;
use App\DeliveryMethod;
use App\Company;
use App\Currency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\APIHelpers;


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

        $sub_total_price = 0;
        $delivery_cost =0;
        for($i = 0; $i < count($cart); $i++){
            $product = Product::select('id' , 'final_price' , 'remaining_quantity')->find($cart[$i]['product_id']);
            if($product->remaining_quantity < $cart[$i]['count']){
                $response = APIHelpers::createApiResponse(true , 406 , 'The remaining amount of the product is not enough' , 'الكميه المتبقيه من المنتج غير كافيه'  , null , $request->lang);
                return response()->json($response , 406);
            }
            // if($request->payment_method == 2 || $request->payment_method == 3){
            //     $product->remaining_quantity = $product->remaining_quantity - $cart[$i]['count'];
            //     // return $product->remaining_quantity ;
            //     $product->save();
            // }
            $sub_total_price = $sub_total_price + ($product['final_price'] * $cart[$i]['count']);
            
            $delivery_cost = $delivery_cost + $cart[$i]['delivery_cost'];

        }

        // $area_id = UserAddress::find($request->address_id)['area_id'];
        // $delivery_cost = Area::find($area_id)['delivery_cost'];

        if($request->payment_method == 1){
            $order = new Order();
            $order->user_id = $user_id;
            $order->address_id = $request->address_id;
            $order->payment_method = $request->payment_method;
            $order->subtotal_price = $sub_total_price;
            $order->delivery_cost = $delivery_cost;
            $order->total_price = $sub_total_price + $delivery_cost;
            $str = 'abcdefghijklmnopqrstuvwxyz';
            $order->order_number = substr(str_shuffle(uniqid() . $str) , -7);
            $order->save();

            for($i = 0; $i < count($cart); $i++){
                $order_item = new OrderItem();
                $order_item->order_id = $order->id;
                $order_item->product_id = $cart[$i]['product_id'];
                $order_item->count = $cart[$i]['count'];
                $order_item->shipping = $cart[$i]['method'];
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

            $path='https://apitest.myfatoorah.com/v2/SendPayment';
            $token="bearer rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL";

            $headers = array(
                'Authorization:' .$token,
                'Content-Type:application/json'
            );
            $price = $sub_total_price + $delivery_cost;
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
            curl_setopt($curl_session,CURLOPT_URL, $path);
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

        $sub_total_price = 0;
        $delivery_cost =0;
        for($i = 0; $i < count($cart); $i++){
            $product = Product::select('id' , 'final_price' , 'remaining_quantity')->find($cart[$i]['product_id']);
       
            $product->remaining_quantity = $product->remaining_quantity - $cart[$i]['count'];
            // return $product->remaining_quantity ;
            $product->save();

            $sub_total_price = $sub_total_price + ($product['final_price'] * $cart[$i]['count']);

            // if ($cart[$i]['option_id'] != 0) {
            //     for ($n = 0; $n < count($product->multiOptions); $n ++) {
            //         if ($product->multiOptions[$n]['id'] == $cart[$i]['option_id']) {
            //             $sub_total_price = $sub_total_price + ($product->multiOptions[$n]['final_price'] * $cart[$i]['count']);
            //         }
            //     }
            // }
            $delivery_cost = $delivery_cost + $cart[$i]['delivery_cost'];

        }

        // $area_id = UserAddress::find($request->address_id)['area_id'];
        // $delivery_cost = Area::find($area_id)['delivery_cost'];


        $order = new Order();
        $order->user_id = $user_id;
        $order->address_id = $request->address_id;
        $order->subtotal_price = $sub_total_price;
        $order->delivery_cost = $delivery_cost;
        $order->total_price = $sub_total_price + $delivery_cost;
        $str = 'abcdefghijklmnopqrstuvwxyz';
        $order->order_number = substr(str_shuffle(uniqid() . $str) , -7);
        $order->save();

        for($i = 0; $i < count($cart); $i++){
            $order_item =  new OrderItem();
            $order_item->order_id = $order->id;
            $order_item->product_id = $cart[$i]['product_id'];
            $order_item->count = $cart[$i]['count'];
            $order_item->shipping = $cart[$i]['method'];
            $order_item->save();
            $cartItem = Cart::find($cart[$i]['id']);
            $cartItem->delete();                       
        }


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
        if($request->curr != 'kwd'){
            $totalPrice = $order->total_price * $currency['value'];
            $data['total_price'] = number_format((float)$totalPrice, 3, '.', '');
            $subPrice = $order->subtotal_price * $currency['value'];
            $data['subtotal_price'] = number_format((float)$subPrice, 3, '.', '');
            $dCost = $order->delivery_cost * $currency['value'];
            $data['delivery_cost'] = number_format((float)$dCost, 3, '.', '');
        }
        $data['payment_method'] = $order->payment_method;
        $data['products_count'] = OrderItem::where('order_id' , $order_id)->count();
        $ids = OrderItem::where('order_id' , $order_id)->select('id','product_id', 'shipping')->get()->toArray();
        $products = [];
        for($i = 0; $i < count($ids); $i++){
            if($request->lang == 'en'){
                $product = Product::select('id' , 'title_en as title' , 'final_price as price', 'company_id')->find($ids[$i]['product_id'])->makeHidden('company_id');
				$company = Company::where('id', $product['company_id'])->select('title_en as title')->first();
                $product['delivery_method'] = DeliveryMethod::where('id', $ids[$i]['shipping'])->select('title_en as title', 'price')->first();
            }else{
                $product = Product::select('id' , 'title_ar as title' , 'final_price as price', 'company_id')->find($ids[$i]['product_id'])->makeHidden('company_id');
				$company = Company::where('id', $product['company_id'])->select('title_ar as title')->first();
                $product['delivery_method'] = DeliveryMethod::where('id', $ids[$i]['shipping'])->select('title_ar as title', 'price')->first();
            }
            if($request->curr != 'kwd'){
                $dMethod = $product['delivery_method']['price'] * $currency['value'];
                $product['delivery_method']['price'] = number_format((float)$dMethod, 3, '.', '');
                $pPrice = $product['price'] * $currency['value'];
                $product['price'] = number_format((float)$pPrice, 3, '.', '');
            }
            $product['count'] = OrderItem::find($ids[$i]['id'])['count'];
            
            $product['company'] = $company['title'];
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
            'item_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }
        $item = OrderItem::find($request->item_id);
        if (!isset($item['id'])) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Item is not exist' , 'عنصر غير موجود' , null , $request->lang);
            return response()->json($response , 406);
        }
        if ($item->order->status != 1) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Order is not current' , 'الطلب ليس جارى' , null, $request->lang);
            return response()->json($response , 406);
        }

        $status = $item->order->status;
        if ($item->order->subtotal_price - ($item->product->final_price * $item->count) == 0) {
            $status = 3;
        }else {
            $item->delete();
        }
        $item->order->update([
            'subtotal_price' => $item->order->subtotal_price - ($item->product->final_price * $item->count),
            'total_price' => $item->order->total_price - ($item->product->final_price * $item->count),
            'status' => $status
        ]);

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , '' , $request->lang);
        return response()->json($response , 200);
    }

}