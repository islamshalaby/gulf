<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\OrderItem;
use App\Area;
use App\Company;
use App\Governorate;
use App\GovernorateAreas;
use App\UserAddress;
use App\Product;
use App\ProductMultiOption;
use PDF;
use App\Setting;
use App\DeliveryArea;
use App\DeliveryMethod;
use App\Shipment;

class OrderController extends AdminController{
    // get all orders
    public function show(Request $request){
        $governorates = Governorate::where('country_id', 4)->pluck("id")->toArray();
        $data['areas'] = GovernorateAreas::where('deleted', 0)->whereIn('governorate_id', $governorates)->orderBy('id', 'desc')->get();
        if (isset($request->order_status)) {
            $statusArray = [1, 2, 3];
            if ($request->order_status == 'closed') {
                $statusArray = [4, 5, 6];
            }
            $data['order_status'] = $request->order_status;
            $data['orders'] = Order::whereIn('order_items.status', $statusArray)
            ->leftjoin('order_items', function($join) {
                $join->on('order_items.order_id', '=', 'orders.id');
            })
            ->whereIn('order_items.shipping', [1, 2]);
        }else {
            $data['orders'] = Order::join('user_addresses', 'user_addresses.id', '=', 'orders.address_id')
            ->leftjoin('order_items', function($join) {
                $join->on('order_items.order_id', '=', 'orders.id');
            })
            ->whereIn('order_items.shipping', [1, 2]);
            if(isset($request->order_status2)){
                $statusArray = [1, 2, 3];
                if ($request->order_status2 == 'closed') {
                    $statusArray = [4, 5, 6];
                }
                $data['order_status2'] = $request->order_status2;
                $data['orders'] = $data['orders']->whereIn('status', $statusArray);
            }
            if (isset($request->area_id)) {
                $data['area'] = GovernorateAreas::where('id', $request->area_id)->select('id', 'name_en', 'name_ar')->first();
                $data['area_id'] = $request->area_id;
                $data['orders'] = $data['orders']->where('area_id', $request->area_id);
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
        
        $data['sum_price'] = $data['orders']->sum('subtotal_price');
        $data['sum_delivery'] = $data['orders']->sum('orders.delivery_cost');
        $data['sum_installation'] = $data['orders']->sum('orders.installation_cost');
        $data['sum_total'] = $data['orders']->sum('total_price');
        $data['orders'] = $data['orders']->select('orders.*')->groupBy('order_items.order_id')->orderBy('orders.id', 'desc')->get();
        
        return view('admin.orders' , ['data' => $data]);
    }

    // shipping show
    public function shipping_show(Request $request){
        $governorates = Governorate::where('country_id', 4)->pluck("id")->toArray();
        $data['areas'] = GovernorateAreas::where('deleted', 0)->whereIn('governorate_id', $governorates)->orderBy('id', 'desc')->get();
        if (isset($request->order_status)) {
            $statusArray = [1, 2, 3];
            if ($request->order_status == 'closed') {
                $statusArray = [4, 5, 6];
            }
            $data['order_status'] = $request->order_status;
            $data['orders'] = Order::whereIn('order_items.status', $statusArray)
            ->leftjoin('order_items', function($join) {
                $join->on('order_items.order_id', '=', 'orders.id');
            })
            ->whereIn('order_items.shipping', [3]);
        }else {
            $data['orders'] = Order::join('user_addresses', 'user_addresses.id', '=', 'orders.address_id')
            ->leftjoin('order_items', function($join) {
                $join->on('order_items.order_id', '=', 'orders.id');
            })
            ->whereIn('order_items.shipping', [3]);
            if(isset($request->order_status2)){
                $statusArray = [1, 2, 3];
                if ($request->order_status2 == 'closed') {
                    $statusArray = [4, 5, 6];
                }
                $data['order_status2'] = $request->order_status2;
                $data['orders'] = $data['orders']->whereIn('status', $statusArray);
            }
            if (isset($request->area_id)) {
                $data['area'] = GovernorateAreas::where('id', $request->area_id)->select('id', 'name_en', 'name_ar')->first();
                $data['area_id'] = $request->area_id;
                $data['orders'] = $data['orders']->where('area_id', $request->area_id);
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
        
        $data['sum_price'] = $data['orders']->sum('subtotal_price');
        $data['sum_delivery'] = $data['orders']->sum('orders.delivery_cost');
        $data['sum_installation'] = $data['orders']->sum('orders.installation_cost');
        $data['sum_total'] = $data['orders']->sum('total_price');
        $data['orders'] = $data['orders']->select('orders.*')->groupBy('order_items.order_id')->orderBy('orders.id', 'desc')->get();
        
        return view('admin.shipping_orders' , ['data' => $data]);
    }

    // show products orders
    public function showInstallationOrders(Request $request) {
        $data['orders'] = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
        ->where('order_items.shipping', 2);
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
            if (in_array($data['order_status2'], [5, 6, 4, 3, 1])) {
                $data['orders'] = $data['orders']->where('order_items.status', $request->order_status2);
            }else {
                $data['orders'] = $data['orders']->where('orders.status', $request->order_status2);
            }
        }
        if(isset($request->company)){
            $data['company'] = $request->company;
            $data['orders'] = $data['orders']
            ->where('order_items.company_id', $request->company);
        }
        $data['companies'] = Company::where('deleted', 0)->orderBy('id', 'desc')->get();
        $data['areas'] = GovernorateAreas::where('deleted', 0)->orderBy('name_ar', 'asc')->get();
        $data['sum_price'] = $data['orders']->sum('final_price');
        $data['sum_price'] = number_format((float)$data['sum_price'], 3, '.', '');
        $data['orders'] = $data['orders']->select('order_items.*')->orderBy('id', 'desc')->get();
        $data['sum_total'] = 0;
        for ($i = 0; $i < count($data['orders']); $i ++) {
            $data['sum_total'] = $data['sum_total'] + ($data['orders'][$i]['final_price'] * $data['orders'][$i]['count']);
        }
        $data['sum_total'] = number_format((float)$data['sum_total'], 3, '.', '');

        return view('admin.installation_orders' , ['data' => $data]);
    }

    // show products orders
    public function showProductsOrders(Request $request) {
        $data['orders'] = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id');
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
        if(isset($request->company)){
            $data['company'] = $request->company;
            $data['orders'] = $data['orders']
            ->where('order_items.company_id', $request->company);
        }
        $data['companies'] = Company::where('deleted', 0)->orderBy('id', 'desc')->get();
        $data['areas'] = GovernorateAreas::where('deleted', 0)->orderBy('name_ar', 'asc')->get();
        $data['sum_price'] = $data['orders']->sum('final_price');
        $data['sum_price'] = number_format((float)$data['sum_price'], 3, '.', '');
        $data['orders'] = $data['orders']->select('order_items.*')->orderBy('id', 'desc')->get();
        $data['sum_total'] = 0;
        for ($i = 0; $i < count($data['orders']); $i ++) {
            $data['sum_total'] = $data['sum_total'] + ($data['orders'][$i]['final_price'] * $data['orders'][$i]['count']);
        }
        $data['sum_total'] = number_format((float)$data['sum_total'], 3, '.', '');

        return view('admin.products_orders' , ['data' => $data]);
    }

    // get delivery reports
    public function showDeliveryReports(Request $request) {
        if (isset($request->order_status)) {
            $statusArray = [1, 2, 3];
            if ($request->order_status == 'delivered') {
                $statusArray = [4];
            }
            $data['order_status'] = $request->order_status;
            $data['orders'] = OrderItem::join('orders', 'orders.id', 'order_items.order_id')->whereIn('orders.status', $statusArray)->orderBy('id' , 'desc');
        }else{
            $data['orders'] = OrderItem::join('orders', 'orders.id', 'order_items.order_id')->whereIn('orders.status', [1, 2, 3 ,4]);
            if(isset($request->area_id)){
                $data['area'] = GovernorateAreas::where('id', $request->area_id)->select('id', 'name_en', 'name_ar')->first();
                $data['area_id'] = $request->area_id;
                $data['orders'] = $data['orders']->leftjoin('user_addresses', function($join) {
                    $join->on('user_addresses.id', '=', 'orders.address_id');
                })
                ->where('orders.area_id', $request->area_id);
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
        
        $data['companies'] = Company::where('deleted', 0)->orderBy('id', 'desc')->get();
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

        return view('admin.delivery_reports' , ['data' => $data]);
    }

    // cancel item
    public function cancelItem(OrderItem $item, $type) {
        $shipment = Shipment::where('order_id', $item->id)->first();
        
        if ($shipment) {
            $shipRes = $this->cancelShipment($shipment->airway_bill_number, "wrong order");
        }
        $totalShipment = $item->order->shipping_cost;
        if ($type == 'shipping') {
            if (($shipRes && $shipRes->ShipmentVoidResult == 'Shipment Void Successfully') || $type = 'other') {
                $dcost = $item->order['delivery_cost'];
                $incost = $item->order['installation_cost'];
                $subTotal = $item->order['subtotal_price'] - ($item->final_price * $item->count);
                $subTotal = number_format((float)$subTotal, 3, '.', '');
                $incost = $incost - ($item->installation_cost * $item->count);
                $incost = number_format((float)$incost, 3, '.', '');
                $totalShipment = $totalShipment - $item->shipping_cost;
                $item->update([
                    'status' => 6,// canceled from admin
                    'final_price' => '0.000',
                    'price_before_offer' => '0.000',
                    'installation_cost' => '0.000',
                    'shipping_cost' => '0.000'
                ]);
                
                $item->product->remaining_quantity = $item->product->remaining_quantity + $item->count;
                $item->product->save();
        
                
                $companyOrder = OrderItem::where('order_id', $item->order_id)->where('company_id', $item->company_id)->count('id');
                
                $orderStatus = $item->order->status;
                if (count($item->order->canceledItems) == count($item->order->oItems)) {
                    $orderStatus = 6;
                }
                $item->order->update([
                    'subtotal_price' => $subTotal,
                    'delivery_cost' => $dcost,
                    'installation_cost' => $incost,
                    'total_price' => $subTotal + $totalShipment + $incost,
                    'status' => $orderStatus,
                    'shipping_cost' => $totalShipment
                ]);
        
                return redirect()->back()->with('success', __('messages.canceled_successfully'));
            }else {
                return redirect()->back()->with('fail', __('messages.cancel_failed'));
            }
        }else {
            $dcost = $item->order['delivery_cost'];
            $incost = $item->order['installation_cost'];
            $subTotal = $item->order['subtotal_price'] - ($item->final_price * $item->count);
            $subTotal = number_format((float)$subTotal, 3, '.', '');
            $incost = $incost - ($item->installation_cost * $item->count);
            $incost = number_format((float)$incost, 3, '.', '');
            // $totalShipment = $totalShipment - $item->shipping_cost;
            $item->update([
                'status' => 6,// canceled from admin
                'final_price' => '0.000',
                'price_before_offer' => '0.000',
                'installation_cost' => '0.000',
                'shipping_cost' => '0.000'
            ]);
            
            $item->product->remaining_quantity = $item->product->remaining_quantity + $item->count;
            $item->product->save();
    
            $companyCanceledOrder = OrderItem::where('order_id', $item->order_id)->where('company_id', $item->company_id)->where('status', 5)->count('id');
            $companyOrder = OrderItem::where('order_id', $item->order_id)->where('company_id', $item->company_id)->count('id');
            if ($companyCanceledOrder == $companyOrder) {
                $companyDelivery = DeliveryArea::where('store_id', $item->company_id)->where('area_id', $item->order->address->area_id)->select('delivery_cost')->first();
                $dcost = $dcost - $companyDelivery['delivery_cost'];
            }
            $orderStatus = $item->order->status;
            if (count($item->order->canceledItems) == count($item->order->oItems)) {
                $orderStatus = 6;
            }
            $item->order->update([
                'subtotal_price' => $subTotal,
                'delivery_cost' => $dcost,
                'installation_cost' => $incost,
                'total_price' => $subTotal + $dcost + $incost,
                'status' => $orderStatus,
                // 'shipping_cost' => $totalShipment
            ]);
        
            return redirect()->back()->with('success', __('messages.canceled_successfully'));
        }
        
        
    }

    // install item
    public function installItem(OrderItem $item) {
        $item->update([
            'status' => 3
        ]);

        return redirect()->back()->with('success', __('messages.canceled_successfully'));
    }

    // cancel | delivered order
    public function action_order(Order $order, $status) {
        if($status == 6){
            $order_id = $order->id;
            $order_items = OrderItem::where('order_id' , $order_id)->get();
            for($i = 0; $i < count($order_items); $i++){
                $count = $order_items[$i]['count'];
                $product_id = $order_items[$i]['product_id'];
                if (!in_array($order_items[$i]->status, [5, 6])) {
                    $order_items[$i]->update(['status' => $status]);
                }
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
                if (!in_array($order_items[$i]->status, [5, 6])) {
                    $order_items[$i]->update(['status' => $status]);
                }
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
        $data['items'] = OrderItem::where('order_id', $order->id)->get();

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
    public function getInvoice(Request $request, Order $order) {
        $data['order'] = $order;
        $data['setting'] = Setting::where('id', 1)->first();
        if($request->has('download')){
            $pdf = PDF::loadView('admin.invoice_pdf', ['data' => $data]);
            
            return $pdf->stream('download.pdf');
        }

        return view('admin.invoice', ['data' => $data]);
    }
}