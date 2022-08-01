<?php

namespace App\Http\Controllers;

use App\Company;
use App\DeliveryMethod;
use App\GovernorateAreas;
use App\Order;
use Illuminate\Http\Request;
use App\Setting;
use App\OrderItem;
use PDF;
use Carbon\Carbon;

class WebViewController extends Controller
{
    // get about
    public function getabout(Request $request){
        $data['lang'] = $request->lang;
        $setting = Setting::find(1);
        if($data['lang'] == 'en' ){
            $data['text'] = $setting['aboutapp_en'];
        }else{
            $data['text'] = $setting['aboutapp_ar'];
        }
        return view('webview.about' , $data);
    }

    // get terms and conditions
    public function gettermsandconditions(Request $request){
        $data['lang'] = $request->lang;
        $setting = Setting::find(1);
        if($data['lang'] == 'en' ){
            $data['title'] = 'Terms and Conditions';
            $data['text'] = $setting['termsandconditions_en'];
        }else{
            $data['title'] = 'الشروط و الأحكام';
            $data['text'] = $setting['termsandconditions_ar'];
        }
        return view('webview.termsandconditions' , $data);
    }

    // returnpolicy
    public function returnpolicy(Request $request){

        $data['lang'] = $request->lang;
        $setting = Setting::find(1);
        if($data['lang'] == 'en' ){
            $data['title'] = 'Return Policy';
            $data['text'] = $setting['return_policy_en'];
        }else{
            $data['title'] = 'سياسه الإرجاع';
            $data['text'] = $setting['return_policy_ar'];
        }
        return view('webview.termsandconditions' , $data);

    }

    
    // returnpolicy
    public function deliveryinformation(Request $request){

        $data['lang'] = $request->lang;
        $setting = Setting::find(1);
        if($data['lang'] == 'en' ){
            $data['title'] = 'Delivery Information';
            $data['text'] = $setting['delivery_information_en'];
        }else{
            $data['title'] = 'معلومات التوصيل';
            $data['text'] = $setting['delivery_information_ar'];
        }
        return view('webview.termsandconditions' , $data);

    }
    
    // get main orders reports
    public function getMainOrdersReport(Request $request) {
        if (isset($request->order_status)) {
            $statusArray = [1, 2, 3];
            if ($request->order_status == 'closed') {
                $statusArray = [4, 5, 6];
            }
            $data['order_status'] = $request->order_status;
            $data['orders'] = Order::whereIn('status', $statusArray);
        }else{
            $data['orders'] = Order::join('user_addresses', 'user_addresses.id', '=', 'orders.address_id');
            if(isset($request->order_status2)){
                $statusArray = [1, 2, 3];
                if ($request->order_status2 == 'closed') {
                    $statusArray = [4, 5, 6];
                }
                $data['order_status2'] = $request->order_status2;
                $data['orders'] = $data['orders']->whereIn('status', $statusArray);
            }
            if(isset($request->area_id)){
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

        $data['sum_subtotal'] = $data['orders']->sum('subtotal_price');
        $data['sum_subtotal'] = number_format((float)$data['sum_subtotal'], 3, '.', '');
        $data['sum_delivery_cost'] = $data['orders']->sum('delivery_cost');
        $data['sum_delivery_cost'] = number_format((float)$data['sum_delivery_cost'], 3, '.', '');
        $data['sum_installation_cost'] = $data['orders']->sum('installation_cost');
        $data['sum_installation_cost'] = number_format((float)$data['sum_installation_cost'], 3, '.', '');
        $data['sum_total_price'] = $data['orders']->sum('total_price');
        $data['sum_total_price'] = number_format((float)$data['sum_total_price'], 3, '.', '');
        $data['today'] = Carbon::now()->format('d-m-Y');
        $data['orders'] = $data['orders']->select('orders.*')->orderBy('orders.id', 'desc')->get();

        $data['setting'] = Setting::where('id', 1)->first();
        $pdf = PDF::loadView('admin.main_report_admin_pdf', ['data' => $data]);
            
        return $pdf->stream('download.pdf');
    }

    // get main orders reports
    public function getCompanyMainOrdersReport(Request $request) {
        if (isset($request->order_status)) {
            $statusArray = [1, 2, 3];
            if ($request->order_status == 'closed') {
                $statusArray = [4, 5, 6];
            }
            $data['order_status'] = $request->order_status;
            $data['orders'] = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->where('order_items.company_id', $request->company_id)->whereIn('order_items.status', $statusArray);
        }else{
            $data['orders'] = Order::join('user_addresses', 'user_addresses.id', '=', 'orders.address_id')
            ->leftjoin('order_items', function($join) {
                $join->on('order_items.order_id', '=', 'orders.id');
            })
            ->where('order_items.company_id', $request->company_id);
            if(isset($request->order_status2)){
                
                $data['order_status2'] = $request->order_status2;
                $data['orders'] = $data['orders']->whereIn('order_items.status', $data['order_status2']);
            }
            if(isset($request->area_id)){
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
        $data['orders'] = $data['orders']->select('orders.*')->groupBy('orders.id')->orderBy('orders.id', 'desc')->get();
        $data['sum_subtotal'] = "0.000";
        $data['sum_delivery_cost'] = "0.000";
        $data['sum_installation_cost'] = "0.000";
        $data['sum_total_price'] = "0.000";
        for ($i = 0; $i < count($data['orders']); $i ++) {
            $data['sum_subtotal'] = $data['sum_subtotal'] + $data['orders'][$i]->oItemCompany($request->company_id)->sum('final_with_delivery');
            $data['sum_delivery_cost'] = $data['sum_delivery_cost'] + $data['orders'][$i]->address->area->deliveryCompany($request->company_id)->delivery_cost;
            $data['sum_total_price'] = $data['sum_total_price'] + $data['orders'][$i]->oItemCompany($request->company_id)->sum('final_with_delivery') + $data['orders'][$i]->address->area->deliveryCompany($request->company_id)->delivery_cost;
        }
        $data['sum_subtotal'] = number_format((float)$data['sum_subtotal'], 3, '.', '');
        $data['sum_delivery_cost'] = number_format((float)$data['sum_delivery_cost'], 3, '.', '');
        $data['sum_installation_cost'] = number_format((float)$data['sum_installation_cost'], 3, '.', '');
        $data['sum_total_price'] = number_format((float)$data['sum_total_price'], 3, '.', '');
        $data['today'] = Carbon::now()->format('d-m-Y');
        $data['company'] = Company::where('id', $request->company_id)->select('id', 'image', 'title_ar')->first();

        $pdf = PDF::loadView('company.main_report_company_pdf', ['data' => $data]);
            
        return $pdf->stream('download.pdf');
    }

    // get sales report admin
    public function getSalesReport2Admin(Request $request) {
        $data['orders'] = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id');
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
            $data['orders'] = $data['orders']->whereBetween('order_items.created_at', array($request->from, $request->to));
        }
        if(isset($request->method)){
            $data['method'] = $request->method;
            $data['orders'] = $data['orders']
            ->where('orders.payment_method', $request->method);
        }
        if(isset($request->delivery)){
            $data['delivery'] = $request->delivery;
            $data['delivery_method'] = DeliveryMethod::where('id', $data['delivery'])->first();
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
            $data['company_name'] = Company::where('id', $data['company'])->select('title_en', 'title_ar')->first();
            $data['orders'] = $data['orders']
            ->where('order_items.company_id', $request->company);
        }
        
        $data['sum_final_price'] = $data['orders']->sum('final_price');
        $data['sum_final_price'] = number_format((float)$data['sum_final_price'], 3, '.', '');
        $data['sum_installation'] = $data['orders']->sum('order_items.installation_cost');
        $data['sum_installation'] = number_format((float)$data['sum_installation'], 3, '.', '');
        $data['today'] = Carbon::now()->format('d-m-Y');
        $data['orders'] = $data['orders']->select('order_items.*')->orderBy('id', 'desc')->get();
        $data['sum_total'] = 0;
        for ($i = 0; $i < count($data['orders']); $i ++) {
            $data['sum_total'] = $data['sum_total'] + ($data['orders'][$i]['final_price'] * $data['orders'][$i]['count']) + ($data['orders'][$i]['installation_cost'] * $data['orders'][$i]['count']);
        }
        $data['sum_total'] = number_format((float)$data['sum_total'], 3, '.', '');
        $data['setting'] = Setting::where('id', 1)->first();
        $pdf = PDF::loadView('admin.sales_report_admin_pdf', ['data' => $data]);
            
        return $pdf->stream('download.pdf');
    }

    // get installation report admin
    public function getInstallationReportAdmin(Request $request) {
        $data['orders'] = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')
        ->where('order_items.shipping', 2);
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
            $data['orders'] = $data['orders']->whereBetween('order_items.created_at', array($request->from, $request->to));
        }
        if(isset($request->method)){
            $data['method'] = $request->method;
            $data['orders'] = $data['orders']
            ->where('orders.payment_method', $request->method);
        }
        if(isset($request->delivery)){
            $data['delivery'] = $request->delivery;
            $data['delivery_method'] = DeliveryMethod::where('id', $data['delivery'])->first();
            $data['orders'] = $data['orders']
            ->where('order_items.shipping', $request->delivery);
        }
        if(isset($request->order_status2)){
            $data['order_status2'] = $request->order_status2;
            if (in_array($data['order_status2'], [5, 6, 4, 3])) {
                $data['orders'] = $data['orders']->where('order_items.status', $request->order_status2);
            }else {
                $data['orders'] = $data['orders']->where('orders.status', $request->order_status2);
            }
        }
        if(isset($request->company)){
            $data['company'] = $request->company;
            $data['company_name'] = Company::where('id', $data['company'])->select('title_en', 'title_ar')->first();
            $data['orders'] = $data['orders']
            ->where('order_items.company_id', $request->company);
        }
        
        $data['sum_final_price'] = $data['orders']->sum('final_price');
        $data['sum_final_price'] = number_format((float)$data['sum_final_price'], 3, '.', '');
        $data['sum_installation'] = $data['orders']->sum('order_items.installation_cost');
        $data['sum_installation'] = number_format((float)$data['sum_installation'], 3, '.', '');
        $data['today'] = Carbon::now()->format('d-m-Y');
        $data['orders'] = $data['orders']->select('order_items.*')->orderBy('id', 'desc')->get();
        $data['sum_total'] = 0;
        for ($i = 0; $i < count($data['orders']); $i ++) {
            $data['sum_total'] = $data['sum_total'] + ($data['orders'][$i]['final_price'] * $data['orders'][$i]['count']) + ($data['orders'][$i]['installation_cost'] * $data['orders'][$i]['count']);
        }
        $data['sum_total'] = number_format((float)$data['sum_total'], 3, '.', '');
        $data['setting'] = Setting::where('id', 1)->first();
        $pdf = PDF::loadView('admin.installation_report_admin_pdf', ['data' => $data]);
            
        return $pdf->stream('download.pdf');
    }

    // get sales report admin
    public function getSalesReport2Company(Request $request) {
        $data['orders'] = OrderItem::join('orders', 'orders.id', '=', 'order_items.order_id')->where('order_items.company_id', $request->company_id);
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
            $data['orders'] = $data['orders']->whereBetween('order_items.created_at', array($request->from, $request->to));
        }
        if(isset($request->method)){
            $data['method'] = $request->method;
            $data['orders'] = $data['orders']
            ->where('orders.payment_method', $request->method);
        }
        if(isset($request->delivery)){
            $data['delivery'] = $request->delivery;
            $data['delivery_method'] = DeliveryMethod::where('id', $data['delivery'])->first();
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
            $data['company_name'] = Company::where('id', $data['company'])->select('title_en', 'title_ar')->first();
            $data['orders'] = $data['orders']
            ->where('order_items.company_id', $request->company);
        }
        
        $data['sum_final_price'] = $data['orders']->sum('final_price');
        $data['sum_final_price'] = number_format((float)$data['sum_final_price'], 3, '.', '');
        $data['sum_installation'] = $data['orders']->sum('order_items.installation_cost');
        $data['sum_installation'] = number_format((float)$data['sum_installation'], 3, '.', '');
        $data['today'] = Carbon::now()->format('d-m-Y');
        $data['orders'] = $data['orders']->select('order_items.*')->orderBy('id', 'desc')->get();
        $data['sum_total'] = 0;
        for ($i = 0; $i < count($data['orders']); $i ++) {
            $data['sum_total'] = $data['sum_total'] + ($data['orders'][$i]['final_price'] * $data['orders'][$i]['count']);
        }
        $data['sum_total'] = number_format((float)$data['sum_total'], 3, '.', '');
        $data['company'] = Company::where('id', $request->company_id)->select('id', 'image', 'title_ar')->first();
        $pdf = PDF::loadView('company.sales_report_company_pdf', ['data' => $data]);
            
        return $pdf->stream('download.pdf');
    }

    // get delivery report
    public function getDeliveryReport(Request $request) {
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
                $data['company_name'] = Company::where('id', $data['company'])->select('title_en', 'title_ar')->first();
                $data['orders'] = $data['orders']->where('order_items.company_id', $request->company);
            }
        }
        
        $data['sum_subtotal'] = $data['orders']->sum('final_price');
        $data['sum_subtotal'] = number_format((float)$data['sum_subtotal'], 3, '.', '');
        $data['sum_delivery'] = $data['orders']->sum('orders.delivery_cost');
        $data['sum_delivery_cost'] = number_format((float)$data['sum_delivery'], 3, '.', '');
        $data['sum_installation'] = $data['orders']->sum('order_items.installation_cost');
        $data['sum_installation'] = number_format((float)$data['sum_installation'], 3, '.', '');
        $data['sum_total_price'] = $data['orders']->sum('total_price');
        $data['sum_total_price'] = number_format((float)$data['sum_total_price'], 3, '.', '');
        $data['today'] = Carbon::now()->format('d-m-Y');
        $data['orders'] = $data['orders']->select('order_items.*')->orderBy('orders.id', 'desc')->get();
        $data['sum_total'] = 0;
        for ($i = 0; $i < count($data['orders']); $i ++) {
            $data['sum_total'] = $data['sum_total'] + ($data['orders'][$i]['final_price'] * $data['orders'][$i]['count']) + ($data['orders'][$i]['installation_cost'] * $data['orders'][$i]['count']);
        }
        $data['sum_total'] = number_format((float)$data['sum_total'], 3, '.', '');

        $data['setting'] = Setting::where('id', 1)->first();
        $pdf = PDF::loadView('admin.delivery_report_admin_pdf', ['data' => $data]);
            
        return $pdf->stream('download.pdf');
    }

    // get delivery report
    public function getDeliveryReportCompany(Request $request) {
        if (isset($request->order_status)) {
            $statusArray = [1, 2, 3];
            if ($request->order_status == 'delivered') {
                $statusArray = [4];
            }
            $data['order_status'] = $request->order_status;
            $data['orders'] = OrderItem::join('orders', 'orders.id', 'order_items.order_id')->where('order_items.company_id', $request->company_id)->whereIn('order_items.status', $statusArray)->orderBy('id' , 'desc');
        }else{
            $data['orders'] = OrderItem::join('orders', 'orders.id', 'order_items.order_id')->where('order_items.company_id', $request->company_id)->whereIn('order_items.status', [1, 2, 3 ,4]);
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
        }
        
        $data['sum_subtotal'] = $data['orders']->sum('final_price');
        $data['sum_subtotal'] = number_format((float)$data['sum_subtotal'], 3, '.', '');
        $data['sum_delivery'] = $data['orders']->sum('orders.delivery_cost');
        $data['sum_delivery_cost'] = number_format((float)$data['sum_delivery'], 3, '.', '');
        $data['sum_installation'] = $data['orders']->sum('order_items.installation_cost');
        $data['sum_installation'] = number_format((float)$data['sum_installation'], 3, '.', '');
        $data['sum_total_price'] = $data['orders']->sum('total_price');
        $data['sum_total_price'] = number_format((float)$data['sum_total_price'], 3, '.', '');
        $data['today'] = Carbon::now()->format('d-m-Y');
        $data['orders'] = $data['orders']->select('order_items.*')->orderBy('orders.id', 'desc')->get();
        $data['sum_total'] = 0;
        for ($i = 0; $i < count($data['orders']); $i ++) {
            $data['sum_total'] = $data['sum_total'] + ($data['orders'][$i]['final_price'] * $data['orders'][$i]['count']) + ($data['orders'][$i]['installation_cost'] * $data['orders'][$i]['count']);
        }
        $data['sum_total'] = number_format((float)$data['sum_total'], 3, '.', '');

        $data['company'] = Company::where('id', $request->company_id)->select('id', 'image', 'title_ar')->first();

        $pdf = PDF::loadView('company.delivery_report_company_pdf', ['data' => $data]);
            
        return $pdf->stream('download.pdf');
    }
}
