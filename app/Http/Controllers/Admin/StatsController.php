<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\DB;
use \Carbon\Carbon;
use App\User;
use App\Ad;
use App\Category;
use App\ContactUs;
use App\Brand;
use App\SubCategory;
use App\Product;
use App\Offer;
use App\Area;
use App\Order;
use App\OrderItem;

class StatsController extends AdminController{
    public function show() {
        $data['users'] = User::count();
        $data['ads'] = Ad::count();
        $data['categories'] = Category::where('deleted', 0)->count();
        $data['contact_us'] = ContactUs::count();
        $data['brands'] = Brand::where('deleted', 0)->count();
        $data['sub_categories'] = SubCategory::where('deleted', 0)->count();
        $data['products'] = Product::where('deleted', 0)->count();
        $data['offers'] = Offer::count();
        $data['areas'] = Area::where('deleted', 0)->count();
        $data['orders'] = Order::count();
        $data['in_progress_orders'] = Order::where('status', 1)->count();
        $data['canceled_orders'] = Order::where('status', 5)->count();
        $data['delivered_orders'] = Order::where('status', 4)->count();
        $data['delivered_orders_cost'] = Order::where('status', 4)->sum('total_price');
        $data['canceled_orders_cost'] = Order::where('status', 5)->sum('total_price');
        $data['in_progress_orders_cost'] = Order::where('status', 1)->sum('total_price');
        $data['total_orders_cost'] = Order::sum('total_price');
        $data['cash_orders_cost'] = Order::where('payment_method', 1)->where('status', 2)->sum('total_price');
        $data['key_net_orders_cost'] = Order::where('payment_method', 2)->where('status', 2)->sum('total_price');
        $data['key_net_home_orders_cost'] = Order::where('payment_method', 2)->where('status', 2)->sum('total_price');
        $data['today_orders'] = Order::whereDate('created_at', Carbon::today())->count();
        $data['users_today_count'] = User::whereDate('created_at', Carbon::today())->count();
        $data['contact_us_today_count'] = ContactUs::whereDate('created_at', Carbon::today())->count();
        $data['products_today_count'] = Product::whereDate('created_at', Carbon::today())->count();
        $data['in_progress_orders_today_count'] = Order::where('status', 1)->whereDate('created_at', Carbon::today())->count();
        $data['canceled_orders_today_count'] = Order::where('status', 5)->whereDate('created_at', Carbon::today())->count();
        $data['delivered_orders_today_count'] = Order::where('status', 4)->whereDate('created_at', Carbon::today())->count();
        $data['today_delivered_orders_cost'] = Order::where('status', 4)->whereDate('created_at', Carbon::today())->sum('total_price');
        $data['today_canceled_orders_cost'] = Order::where('status', 5)->whereDate('created_at', Carbon::today())->sum('total_price');
        $data['today_in_progress_orders_cost'] = Order::where('status', 1)->whereDate('created_at', Carbon::today())->sum('total_price');
        $data['today_cash_cost'] = Order::where('payment_method', 1)->where('status', 2)->whereDate('created_at', Carbon::today())->sum('total_price');
        $data['today_key_net_cost'] = Order::where('payment_method', 2)->where('status', 2)->whereDate('created_at', Carbon::today())->sum('total_price');
        $data['today_key_net_home_cost'] = Order::where('payment_method', 2)->where('status', 2)->whereDate('created_at', Carbon::today())->sum('total_price');
        $data['most_sold_products']=OrderItem::join('products','products.id', '=','order_items.product_id')
        ->select('products.id','products.title_en','products.title_ar', DB::raw('SUM(count) as cnt'))
        ->groupBy('order_items.product_id')
        ->groupBy('products.id')
		->groupBy('products.title_en')
		->groupBy('products.title_ar')
        ->orderBy('cnt', 'desc')->take(3)->get();
        
        $data['most_areas_order'] = Order::join('user_addresses', 'user_addresses.id', '=', 'orders.address_id')
        ->join('areas as ar1', 'user_addresses.area_id', '=', 'ar1.id')
        ->select('user_addresses.id', 'user_addresses.area_id', 'ar1.title_en', 'ar1.title_ar', 'ar1.id',  DB::raw('COUNT(orders.id) as cnt'))
        ->groupBy('user_addresses.id')
        ->groupBy('user_addresses.area_id')
        ->groupBy('ar1.title_en')
        ->groupBy('ar1.title_ar')
        ->groupBy('ar1.id')
        ->orderBy('cnt', 'desc')->take(3)->get();

        $data['most_users_order'] = Order::join('users', 'users.id', '=', 'orders.user_id')
        ->select('users.name', 'users.id', DB::raw('COUNT(orders.id) as cnt'))
        ->groupBy('users.name')
        ->groupBy('users.id')
        ->orderBy('cnt', 'desc')->take(3)->get();
        
        return view('admin.stats', ['data' => $data]);
    }
}