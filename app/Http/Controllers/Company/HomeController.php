<?php
namespace App\Http\Controllers\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ContactUs;
use App\User;
use App\Ad;
use App\Category;
use App\Product;
use App\Brand;
use App\SubCategory;
use App\Offer;
use App\HomeSection;
use App\Area;
use App\Order;
use App\OrderItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends CompanyController{

    // get home
    public function show(){
        
        $data['products_less_than_ten'] = Product::where('company_id', Auth::user()->id)->where('deleted' , 0)->where('remaining_quantity' , '<' , 10)->count();
        $data['most_sold_products']= Product::where('company_id', Auth::user()->id)->where('deleted' , 0)->where('sold_count', '>', 0)->orderBy('sold_count', 'desc')->take(7)->get();

        $data['recent_orders'] = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')->where('order_items.company_id', Auth::user()->id)->orderBy('orders.id' , 'desc')->select('orders.*')->groupBy('orders.id')->take(7)->get();
        
        $in_progress_orders = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')->where('order_items.company_id', Auth::user()->id)->where('order_items.status', 1)->select('orders.*')->groupBy('orders.id')->get();
        $data['in_progress_orders'] = "0.000";
        for ($in = 0; $in < count($in_progress_orders); $in ++) {
            // dd($in_progress_orders[$in]->address->goveronrateArea);
            $dCost = "0.000";
            if ($in_progress_orders[$in]->address->goveronrateArea->deliveryCompany(Auth::user()->id)->delivery_cost) {
                $dCost = $in_progress_orders[$in]->address->goveronrateArea->deliveryCompany(Auth::user()->id)->delivery_cost;
            }
            $data['in_progress_orders'] = $data['in_progress_orders'] + $in_progress_orders[$in]->oItemsCompany(Auth::user()->id)->sum('final_with_delivery') + $dCost;
        }
        $canceled_orders = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')->where('order_items.company_id', Auth::user()->id)->whereIn('order_items.status', [5, 6])->select('orders.*')->groupBy('orders.id')->get();
        $data['canceled_orders'] = "0.000";
        for ($can = 0; $can < count($canceled_orders); $can ++) {
            $dCost = "0.000";
            if ($canceled_orders[$can]->address->goveronrateArea->deliveryCompany(Auth::user()->id)->delivery_cost) {
                $dCost = $canceled_orders[$can]->address->goveronrateArea->deliveryCompany(Auth::user()->id)->delivery_cost;
            }
            $data['canceled_orders'] = $data['canceled_orders'] + $canceled_orders[$can]->oItemsCompany(Auth::user()->id)->sum('final_with_delivery') + $dCost;
        }
        $delivered_orders = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')->where('order_items.company_id', Auth::user()->id)->where('order_items.status', 4)->select('orders.*')->groupBy('orders.id')->get();
        $data['delivered_orders'] = "0.000";
        for ($del = 0; $del < count($delivered_orders); $del ++) {
            $dCost = "0.000";
            if ($delivered_orders[$del]->address->goveronrateArea->deliveryCompany(Auth::user()->id)->delivery_cost) {
                $dCost = $$delivered_orders[$del]->address->goveronrateArea->deliveryCompany(Auth::user()->id)->delivery_cost;
            }
            $data['delivered_orders'] = $data['delivered_orders'] + $delivered_orders[$del]->oItemsCompany(Auth::user()->id)->sum('final_with_delivery') + $dCost;
        }
        $data['total_value'] = (double)$data['in_progress_orders'] + (double)$data['canceled_orders'] + (double)$data['delivered_orders'];

        $data['monthly_canceled_orders'] = OrderItem::where('order_items.company_id', Auth::user()->id)->select('id', 'created_at')
        ->whereIn('order_items.status', [5, 6])
        ->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });
        $data['canceled_orders_count'] = [];
        $data['canceled_orders_arr'] = [];

        foreach ($data['monthly_canceled_orders'] as $key => $value) {
            $data['canceled_orders_count'][(int)$key] = count($value);
        }

        for($i = 1; $i <= 12; $i++){
            if(!empty($data['canceled_orders_count'][$i])){
                $data['canceled_orders_arr'][$i] = $data['canceled_orders_count'][$i];    
            }else{
                $data['canceled_orders_arr'][$i] = 0;    
            }
        }

        $data['monthly_completed_orders'] = OrderItem::where('order_items.company_id', Auth::user()->id)->select('id', 'created_at')
        ->where('order_items.status', 4)
        ->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });
        $data['completed_orders_count'] = [];
        $data['completed_orders_arr'] = [];

        foreach ($data['monthly_completed_orders'] as $key => $value) {
            $data['completed_orders_count'][(int)$key] = count($value);
        }

        for($i = 1; $i <= 12; $i++){
            if(!empty($data['completed_orders_count'][$i])){
                $data['completed_orders_arr'][$i] = $data['completed_orders_count'][$i];    
            }else{
                $data['completed_orders_arr'][$i] = 0;    
            }
        }

        $data['monthly_Inprogress_orders'] = OrderItem::where('order_items.company_id', Auth::user()->id)->select('id', 'created_at')
        ->where('order_items.status', 1)
        ->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });
        $data['Inprogress_orders_count'] = [];
        $data['Inprogress_orders_arr'] = [];

        foreach ($data['monthly_Inprogress_orders'] as $key => $value) {
            $data['Inprogress_orders_count'][(int)$key] = count($value);
        }

        for($i = 1; $i <= 12; $i++){
            if(!empty($data['Inprogress_orders_count'][$i])){
                $data['Inprogress_orders_arr'][$i] = $data['Inprogress_orders_count'][$i];    
            }else{
                $data['Inprogress_orders_arr'][$i] = 0;    
            }
        }

        $delivered_orders_cost = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')->where('order_items.company_id', Auth::user()->id)->where('order_items.status', 4)->select('orders.*')->groupBy('orders.id')->get();
        $data['delivered_orders_cost'] = "0.000";
        for ($d = 0; $d < count($delivered_orders_cost); $d ++) {
            $data['delivered_orders_cost'] = $data['delivered_orders_cost'] + $delivered_orders_cost[$d]->oItemsCompany(Auth::user()->id)->sum('final_with_delivery') + $delivered_orders_cost[$d]->address->area->deliveryCompany(Auth::user()->id)->delivery_cost;
        }

        return view('company.home', ['data' => $data]);
    }

}