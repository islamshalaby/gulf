<?php
namespace App\Http\Controllers\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\OrderItem;
use App\Area;
use App\UserAddress;
use App\Product;
use App\ProductMultiOption;

class OrderController extends CompanyController{
    // get all orders
    public function show(Request $request){
        $products = Product::where('deleted', 0)->where('hidden', 0)->where('company_id', Auth::user()->id)->pluck('id');
        $orderItems = OrderItem::whereIn('product_id', $products)->pluck('order_id');
        $orderItems = array_unique($orderItems->toArray());
        $itemsOrdered = [];
        foreach ($orderItems as $key => $value) {
			array_push($itemsOrdered, $value); 
		}
        $data['orders'] = Order::whereIn('id', $itemsOrdered)->orderBy('id' , 'desc')->get();

        for ($n = 0; $n < count($data['orders']); $n ++) {
            $oitems = OrderItem::where('order_id', $data['orders'][$n]['id'])->whereIn('product_id', $products)->select('count', 'final_price', 'shipping');
            $total = 0;
            for ($k = 0; $k < count($oitems); $k ++) {
                $total = $total + ($oitems[$k]['count'] * $oitems[$k]['final_price']);
            }
            $data['orders'][$n]['total_price'] = $total;
        }
        
        $data['areas'] = Area::where('deleted', 0)->orderBy('id', 'desc')->get();
        $data['sum_price'] = Order::sum('subtotal_price');
        $data['sum_delivery'] = Order::sum('delivery_cost');
        $data['sum_total'] = Order::sum('total_price');
        
        return view('company.orders' , ['data' => $data]);
    }

    // cancel | delivered order
    public function action_order(Order $order, $status) {
        if($status == 5){
            $order_id = $order->id;
            $order_items = OrderItem::where('order_id' , $order_id)->get();
            for($i = 0; $i < count($order_items); $i++){
                $count = $order_items[$i]['count'];
                $product_id = $order_items[$i]['product_id'];
                if ($order->status == 4) {
                    $product = Product::find($product_id);
                    $product->remaining_quantity = $product->remaining_quantity + $count;
                    $product->sold_count = $product->sold_count - $count;
                    $product->save();
                    // if ($order_items[$i]['option_id'] != 0) {
                    //     $m_option = ProductMultiOption::find($order_items[$i]['option_id']);
                    //     $m_option->update(['remaining_quantity' => $m_option->remaining_quantity + $count, 'sold_count' => $m_option->sold_count - $count]);
                    // }
                }
            }
        }

        if($status == 4){
            $order_id = $order->id;
            $order_items = OrderItem::where('order_id' , $order_id)->get();
            for($i = 0; $i < count($order_items); $i++){
                $count = (int)$order_items[$i]['count'];
                $product_id = $order_items[$i]['product_id'];
                $product = Product::where('id', $product_id)->first();
                $sum_count = $product->sold_count + $count;
                $product->sold_count = $sum_count;
                $product->save();
                
                // if ($order_items[$i]['option_id'] != 0) {
                //     $m_option = ProductMultiOption::find($order_items[$i]['option_id']);
                //     $m_option->update(['sold_count' => (int)$m_option->sold_count + $count]);
                // }
            }
        }

        $order->update(['status' => (int)$status]);


        return redirect()->back();
    }

    

    // details
    public function details(Order $order) {
        $data['order'] = $order;

        return view('admin.order_details', ['data' => $data]);
    }

    // filter orders
    public function filter_orders(Request $request, $status) {
        if (isset($request->area_id)) {
            $addresses = UserAddress::with('orders')->where('area_id', $request->area_id)->get();
            $data['sum_price'] = 0;
            $data['sum_delivery'] = 0;
            $data['sum_total'] = 0;
            $orders = [];
            if (count($addresses) > 0) {
                foreach ($addresses as $address) {
                    if (count($address->orders) > 0) {
                        foreach($address->orders as $order) {
                            if ($order->status == $status) {
                                $data['sum_price'] += $order->subtotal_price;
                                $data['sum_delivery'] += $order->delivery_cost;
                                $data['sum_total'] += $order->total_price;
                                array_push($orders, $order);
                            }
                        }
                    }
                }
            }
            $data['orders'] = $orders;
            $data['areas'] = Area::where('deleted', 0)->orderBy('id', 'desc')->get();
            $data['area'] = Area::findOrFail($request->area_id);
        }elseif(isset($request->from)) {
            $data['orders'] = Order::where('status', $status)->whereBetween('created_at', array($request->from, $request->to))->get();
            $data['areas'] = Area::where('deleted', 0)->orderBy('id', 'desc')->get();
            $data['sum_price'] = Order::whereBetween('created_at', array($request->from, $request->to))->sum('subtotal_price');
            $data['sum_delivery'] = Order::whereBetween('created_at', array($request->from, $request->to))->sum('delivery_cost');
            $data['sum_total'] = Order::whereBetween('created_at', array($request->from, $request->to))->sum('total_price');
        }else {
            $data['orders'] = Order::where('status', $status)->get();
            $data['areas'] = Area::where('deleted', 0)->orderBy('id', 'desc')->get();
            $data['sum_price'] = Order::where('status', $status)->sum('subtotal_price');
            $data['sum_delivery'] = Order::where('status', $status)->sum('delivery_cost');
            $data['sum_total'] = Order::where('status', $status)->sum('total_price');
        }
        

        return view('admin.orders' , ['data' => $data]);
    }

    // fetch orders by area
    public function fetch_orders_by_area(Request $request) {
        $addresses = UserAddress::with('orders')->where('area_id', $request->area_id)->get();
        
        $orders = [];
        $data['sum_price'] = 0;
        $data['sum_delivery'] = 0;
        $data['sum_total'] = 0;
        if (count($addresses) > 0) {
            foreach ($addresses as $address) {
                if (count($address->orders) > 0) {
                    foreach($address->orders as $order) {
                        $data['sum_price'] += $order->subtotal_price;
                        $data['sum_delivery'] += $order->delivery_cost;
                        $data['sum_total'] += $order->total_price;
                        array_push($orders, $order);
                    }
                }
            }
        }
        $data['orders'] = $orders;
        $data['areas'] = Area::where('deleted', 0)->orderBy('id', 'desc')->get();
        $data['area'] = Area::findOrFail($request->area_id);
        return view('admin.orders' , ['data' => $data]);
    }

    // fetch order date range
    public function fetch_orders_date(Request $request) {
        $data['orders'] = Order::whereBetween('created_at', array($request->from, $request->to))->get();
        $data['areas'] = Area::where('deleted', 0)->orderBy('id', 'desc')->get();
        $data['from'] = '';
        $data['to'] = '';
        if (isset($request->from)) {
            $data['from'] = $request->from;
            $data['to'] = $request->to;
        }
        $data['sum_price'] = Order::whereBetween('created_at', array($request->from, $request->to))->sum('subtotal_price');
        $data['sum_delivery'] = Order::whereBetween('created_at', array($request->from, $request->to))->sum('delivery_cost');
        $data['sum_total'] = Order::whereBetween('created_at', array($request->from, $request->to))->sum('total_price');
        return view('admin.orders' , ['data' => $data]);
    }

    // fetch order payment method
    public function fetch_order_payment_method(Request $request) {
        $data['orders'] = Order::where('payment_method', $request->method)->get();
        $data['areas'] = Area::where('deleted', 0)->orderBy('id', 'desc')->get();
        $data['sum_price'] = Order::where('payment_method', $request->method)->sum('subtotal_price');
        $data['sum_delivery'] = Order::where('payment_method', $request->method)->sum('delivery_cost');
        $data['sum_total'] = Order::where('payment_method', $request->method)->sum('total_price');
        $data['method'] = $request->method;

        return view('admin.orders' , ['data' => $data]);
    }

    // get invoice
    public function getInvoice(Order $order) {
        $data['order'] = $order;
        // dd($data['order']->items);

        return view('admin.invoice', ['data' => $data]);
    }
}