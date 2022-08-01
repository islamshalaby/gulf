<?php
namespace App\Http\Controllers\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\OrderItem;
use App\Area;
use App\Company;
use App\UserAddress;
use App\Product;
use App\DeliveryMethod;
use App\GovernorateAreas;
use App\Governorate;
use PDF;

class OrderController extends CompanyController{
    // get all orders
    public function show(Request $request){
        $data['company_id'] = Auth::user()->id;
        $governorates = Governorate::where('country_id', 4)->pluck("id")->toArray();
        $data['areas'] = GovernorateAreas::where('deleted', 0)->whereIn('governorate_id', $governorates)->orderBy('id', 'desc')->get();
        if (isset($request->order_status)) {
            $statusArray = [1, 2, 3];
            if ($request->order_status == 'closed') {
                $statusArray = [4, 5, 6];
            }
            $data['order_status'] = $request->order_status;
            $data['orders'] = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('order_items.shipping', [1, 2])
            ->where('order_items.company_id', Auth::user()->id)->whereIn('order_items.status', $statusArray);
        }else {
            $data['orders'] = Order::join('user_addresses', 'user_addresses.id', '=', 'orders.address_id')
            ->leftjoin('order_items', function($join) {
                $join->on('order_items.order_id', '=', 'orders.id');
            })
            ->whereIn('order_items.shipping', [1, 2])
            ->where('order_items.company_id', Auth::user()->id);
            if(isset($request->order_status2)){
                
                $data['order_status2'] = $request->order_status2;
                
                $data['orders'] = $data['orders']->whereIn('order_items.status', $data['order_status2']);
            }
            if (isset($request->area_id)) {
                $data['area'] = GovernorateAreas::where('id', $request->area_id)->select('id', 'name_en', 'name_ar')->first();
                $data['area_id'] = $request->area_id;
                $data['orders'] = $data['orders']->where('user_addresses.area_id', $request->area_id);
            }
            if(isset($request->from) && isset($request->to)){
                $data['from'] = $request->from;
                $data['to'] = $request->to;
                $data['orders'] = $data['orders']->whereDate('orders.created_at', '>=', $request->from)->whereDate('orders.created_at', '<=', $request->to);
            }
            if(isset($request->method)){
                $data['method'] = $request->method;
                $data['orders'] = $data['orders']->where('orders.payment_method', $request->method);
            }
        }
        
        $data['sum_price'] = "0.000";
        $data['orders'] = $data['orders']->select('orders.*')->groupBy('orders.id')->orderBy('orders.id', 'desc')->get();
        $data['sum_delivery'] = "0.000";
        $data['sum_installation'] = "0.000";
        $data['sum_total'] = "0.000";
        for ($i = 0; $i < count($data['orders']); $i ++) {
            $data['sum_price'] = $data['sum_price'] + $data['orders'][$i]->oItemCompany($data['company_id'])->sum('final_with_delivery');
            $totalDCost = "0.000";
            if ( !empty($data['orders'][$i]->address->goveronrateArea->deliveryCompany($data['company_id'])->delivery_cost) ) {
                $totalDCost = $data['orders'][$i]->address->goveronrateArea->deliveryCompany($data['company_id'])->delivery_cost;
            } 
            $data['sum_delivery'] = $data['sum_delivery'] + $totalDCost;
            $data['sum_total'] = $data['sum_total'] + $data['orders'][$i]->oItemCompany($data['company_id'])->sum('final_with_delivery') + $totalDCost;
        }
        $data['sum_total'] = number_format((float)$data['sum_total'], 3, '.', '');
        // dd($data['sum_total']);
        return view('company.orders' , ['data' => $data]);
    }

    // get shipping orders
    public function showShipping(Request $request){
        $data['company_id'] = Auth::user()->id;
        $governorates = Governorate::where('country_id', 4)->pluck("id")->toArray();
        $data['areas'] = GovernorateAreas::where('deleted', 0)->whereIn('governorate_id', $governorates)->orderBy('id', 'desc')->get();
        if (isset($request->order_status)) {
            $statusArray = [1, 2, 3];
            if ($request->order_status == 'closed') {
                $statusArray = [4, 5, 6];
            }
            $data['order_status'] = $request->order_status;
            $data['orders'] = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('order_items.shipping', [3])
            ->where('order_items.company_id', Auth::user()->id)->whereIn('order_items.status', $statusArray);
        }else {
            $data['orders'] = Order::join('user_addresses', 'user_addresses.id', '=', 'orders.address_id')
            ->leftjoin('order_items', function($join) {
                $join->on('order_items.order_id', '=', 'orders.id');
            })
            ->whereIn('order_items.shipping', [3])
            ->where('order_items.company_id', Auth::user()->id);
            if(isset($request->order_status2)){
                
                $data['order_status2'] = $request->order_status2;
                
                $data['orders'] = $data['orders']->whereIn('order_items.status', $data['order_status2']);
            }
            if (isset($request->area_id)) {
                $data['area'] = GovernorateAreas::where('id', $request->area_id)->select('id', 'name_en', 'name_ar')->first();
                $data['area_id'] = $request->area_id;
                $data['orders'] = $data['orders']->where('user_addresses.area_id', $request->area_id);
            }
            if(isset($request->from) && isset($request->to)){
                $data['from'] = $request->from;
                $data['to'] = $request->to;
                $data['orders'] = $data['orders']->whereDate('orders.created_at', '>=', $request->from)->whereDate('orders.created_at', '<=', $request->to);
            }
            if(isset($request->method)){
                $data['method'] = $request->method;
                $data['orders'] = $data['orders']->where('orders.payment_method', $request->method);
            }
        }
        
        $data['sum_price'] = "0.000";
        $data['orders'] = $data['orders']->select('orders.*')->groupBy('orders.id')->orderBy('orders.id', 'desc')->get();
        $data['sum_delivery'] = "0.000";
        $data['sum_installation'] = "0.000";
        $data['sum_total'] = "0.000";
        for ($i = 0; $i < count($data['orders']); $i ++) {
            $data['sum_price'] = $data['sum_price'] + $data['orders'][$i]->oItemCompany($data['company_id'])->sum('final_with_delivery');
            $totalDCost = "0.000";
            if ( !empty($data['orders'][$i]->address->goveronrateArea->deliveryCompany($data['company_id'])->delivery_cost) ) {
                $totalDCost = $data['orders'][$i]->address->goveronrateArea->deliveryCompany($data['company_id'])->delivery_cost;
            } 
            $data['sum_delivery'] = $data['sum_delivery'] + $totalDCost;
            $data['sum_total'] = $data['sum_total'] + $data['orders'][$i]->oItemCompany($data['company_id'])->sum('final_with_delivery') + $totalDCost;
        }
        $data['sum_total'] = number_format((float)$data['sum_total'], 3, '.', '');

        // dd($data['orders'][0]->oItemsCompany($data['company_id'])->get());
        
        return view('company.shipping_orders' , ['data' => $data]);
    }

    // get delivery reports
    public function showDeliveryReports(Request $request) {
        $data['company_id'] = Auth::user()->id;
        if (isset($request->order_status)) {
            $statusArray = [1, 2, 3];
            if ($request->order_status == 'delivered') {
                $statusArray = [4];
            }
            $data['order_status'] = $request->order_status;
            $data['orders'] = OrderItem::join('orders', 'orders.id', 'order_items.order_id')->where('company_id', Auth::user()->id)->whereIn('order_items.status', $statusArray)->orderBy('id' , 'desc');
        }else{
            $data['orders'] = OrderItem::join('orders', 'orders.id', 'order_items.order_id')->where('company_id', Auth::user()->id)->whereIn('order_items.status', [1, 2, 3 ,4]);
            if(isset($request->area_id)){
                $data['area'] = GovernorateAreas::where('id', $request->area_id)->select('id', 'name_en', 'name_ar')->first();
                $data['area_id'] = $request->area_id;
                $data['orders'] = $data['orders']->leftjoin('user_addresses', function($join) {
                    $join->on('user_addresses.id', '=', 'orders.address_id');
                })
                ->where('area_id', $request->area_id);
            }
            if(isset($request->from) && isset($request->to)){
                $data['from'] = $request->from;
                $data['to'] = $request->to;
                $data['orders'] = $data['orders']->whereDate('order_items.created_at', '>=', $request->from)->whereDate('orders.created_at', '<=', $request->to);
            }
            if(isset($request->method)){
                $data['method'] = $request->method;
                $data['orders'] = $data['orders']->where('orders.payment_method', $request->method);
            }
            if(isset($request->order_status2)){
                $data['order_status2'] = $request->order_status2;
                if (in_array($data['order_status2'], [5, 6])) {
                    $data['orders'] = $data['orders']->where('order_items.status', $request->order_status2);
                }else {
                    $data['orders'] = $data['orders']->where('orders.status', $request->order_status2);
                }
            }
            if(isset($request->company)){
                $data['company'] = $request->company;
                $data['orders'] = $data['orders']->where('order_items.company_id', $request->company);
            }
        }
        
        $governorates = Governorate::where('country_id', 4)->pluck("id")->toArray();
        $data['areas'] = GovernorateAreas::where('deleted', 0)->whereIn('governorate_id', $governorates)->orderBy('id', 'desc')->get();
        $data['sum_price'] = $data['orders']->sum('final_price');
        $data['sum_delivery'] = $data['orders']->sum('orders.delivery_cost');
        $data['sum_installation'] = $data['orders']->sum('order_items.installation_cost');
        $data['sum_total'] = 0;
        $data['orders'] = $data['orders']->select('order_items.*')->orderBy('orders.id', 'desc')->get();
        for ($i = 0; $i < count($data['orders']); $i ++) {
            $data['sum_total'] = $data['sum_total'] + ($data['orders'][$i]['final_price'] * $data['orders'][$i]['count']) + ($data['orders'][$i]['installation_cost'] * $data['orders'][$i]['count']);
        }

        return view('company.delivery_reports' , ['data' => $data]);
    }

    // show products orders
    public function showProductsOrders(Request $request) {
        $data['company_id'] = Auth::user()->id;
        $data['orders'] = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')->where('order_items.company_id', Auth::user()->id);
        $data['delivery_methods'] = DeliveryMethod::where('deleted', 0)->get();
        if(isset($request->area_id)){
            $data['area'] = GovernorateAreas::where('id', $request->area_id)->select('id', 'name_en', 'name_ar')->first();
            $data['area_id'] = $request->area_id;
            $data['orders'] = $data['orders']
            ->leftjoin('user_addresses', function($join) {
                $join->on('user_addresses.id', '=', 'orders.address_id');
            })
            ->where('area_id', $request->area_id);
        }
        if(isset($request->from) && isset($request->to)){
            $data['from'] = $request->from;
            $data['to'] = $request->to;
            $data['orders'] = $data['orders']->whereDate('order_items.created_at', '>=', $request->from)->whereDate('order_items.created_at', '<=', $request->to);
        }
        if(isset($request->method)){
            $data['method'] = $request->method;
            $data['orders'] = $data['orders']
            ->where('orders.payment_method', $request->method);
        }
        if(isset($request->delivery)){
            $data['delivery'] = $request->delivery;
            $data['orders'] = $data['orders']
            ->where('order_items.shipping', $request->delivery);
        }
        if(isset($request->order_status2)){
            $data['order_status2'] = $request->order_status2;
            if (in_array($data['order_status2'], [5, 6])) {
                $data['orders'] = $data['orders']->where('order_items.status', $request->order_status2);
            }else {
                $data['orders'] = $data['orders']->where('orders.status', $request->order_status2);
            }
        }
        $governorates = Governorate::where('country_id', 4)->pluck("id")->toArray();
        $data['areas'] = GovernorateAreas::where('deleted', 0)->whereIn('governorate_id', $governorates)->orderBy('name_ar', 'asc')->get();
        $data['sum_price'] = $data['orders']->sum('final_price');
        $data['sum_price'] = number_format((float)$data['sum_price'], 3, '.', '');
        $data['orders'] = $data['orders']->select('order_items.*')->orderBy('id', 'desc')->get();
        $data['sum_total'] = 0;
        for ($i = 0; $i < count($data['orders']); $i ++) {
            $data['sum_total'] = $data['sum_total'] + ($data['orders'][$i]['final_price'] * $data['orders'][$i]['count']);
        }
        $data['sum_total'] = number_format((float)$data['sum_total'], 3, '.', '');
        

        return view('company.products_orders' , ['data' => $data]);
    }

    public function actionOrderCompany(Order $order, $status) {
        $deliveryCost = $order->address->area->deliveryCompany(Auth::user()->id)->delivery_cost;
        $installationCost = "0.000";
        $companyOrders = OrderItem::where('order_id', $order->id)->where('company_id', Auth::user()->id)->select('id', 'status', 'product_id')->get();
        for($i = 0; $i < count($companyOrders); $i ++) {
            $installationCost = $installationCost + ($companyOrders[$i]['installation_cost'] * $companyOrders[$i]['count']);
            $companyOrders[$i]->update(['status' => $status]);
            if ($status == 6) {
                $companyOrders[$i]->product->remaining_quantity = $companyOrders[$i]->product->remaining_quantity + $companyOrders[$i]->count;
                $companyOrders[$i]->product->save();
            }
        }
        
        if (count($order->oItems) == $order->dynamicOItems($status)->count('id')) {
            if ($status == 6) {
                $totalDelivery = "0.000";
                $totalInstallation = "0.000";
                $totalPrice = "0.000";
                $order->update(['status' => $status,
                'delivery_cost' => $totalDelivery,
                'installation_cost' => $totalInstallation,
                'total_price' => $totalPrice
                ]);
            }
            $order->update(['status' => $status]);
        }


        return redirect()->back()->with('success', __('messages.order_status_changed'));
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
            }
        }

        $order->update(['status' => (int)$status]);


        return redirect()->back();
    }

    

    // details
    public function details(Order $order) {
        $data['order'] = $order;
        $data['items'] = OrderItem::where('order_id', $order->id)->get();

        return view('company.order_details', ['data' => $data]);
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
    public function getInvoice(Request $request, Order $order) {
        $data['order'] = $order;
        $data['company'] = Company::where('id', Auth::user()->id)->first();
        if($request->has('download')){
            $pdf = PDF::loadView('company.invoice_pdf', ['data' => $data]);
            
            return $pdf->stream('download.pdf');
        }
    }
}