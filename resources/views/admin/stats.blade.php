@extends('admin.app')

@section('title' , __('messages.statistics'))
@push('styles')
@if(App::isLocale('ar'))
<link href="/admin/rtl/assets/css/apps/invoice.css" rel="stylesheet" type="text/css" />
@else
<link href="/admin/assets/css/apps/invoice.css" rel="stylesheet" type="text/css" />
@endif
@endpush
@section('content')
<div class="layout-px-spacing">
    <div class="row invoice layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="app-hamburger-container">
                <div class="hamburger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu chat-menu d-xl-none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></div>
            </div>
            <div class="doc-container">


                <div class="tab-title">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-12">
                            <div class="search">
                                <input type="text" class="form-control" placeholder="Search...">
                            </div>
                            <ul class="nav nav-pills inv-list-container d-block" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <div class="nav-link list-actions" id="invoice-00001" data-invoice-id="00001">
                                        <div class="f-m-body">
                                            <div class="f-head">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                            </div>
                                            <div class="f-body">
                                                <p class="invoice-number">{{ __('messages.statistics') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div class="nav-link list-actions" id="invoice-00002" data-invoice-id="00002">
                                        <div class="f-m-body">
                                            <div class="f-head">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                            </div>
                                            <div class="f-body">
                                                <p class="invoice-number">{{ __('messages.today_stats') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div class="nav-link list-actions" id="invoice-00003" data-invoice-id="00003">
                                        <div class="f-m-body">
                                            <div class="f-head">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                            </div>
                                            <div class="f-body">
                                                <p class="invoice-number">{{ __('messages.most_sold_product') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div class="nav-link list-actions" id="invoice-00004" data-invoice-id="00004">
                                        <div class="f-m-body">
                                            <div class="f-head">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                            </div>
                                            <div class="f-body">
                                                <p class="invoice-number">{{ __('messages.most_area_order') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div class="nav-link list-actions" id="invoice-00005" data-invoice-id="00005">
                                        <div class="f-m-body">
                                            <div class="f-head">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                            </div>
                                            <div class="f-body">
                                                <p class="invoice-number">{{ __('messages.most_user_order') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>



                <div class="invoice-container">
                    <div class="invoice-inbox">

                        <div class="inv-not-selected">
                            <p>{{ __('messages.Open_statistic_from_the_list') }}</p>
                        </div>

                        <div class="invoice-header-section">
                            {{-- <h4 class="inv-number"></h4> --}}
                            <div class="invoice-action">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer action-print" data-toggle="tooltip" data-placement="top" data-original-title="Reply"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                            </div>
                        </div>
                        
                        <div id="ct" class="">
                            
                            <div class="invoice-00001">
                                <div class="content-section  animated animatedFadeInUp fadeInUp">

                                    <div class="row inv--head-section">

                                        <div class="col-sm-6 col-12">
                                            <h3 class="in-heading">{{ __('messages.statistics') }}</h3>
                                        </div>
                                        
                                        
                                    </div>

                                    <div class="row inv--detail-section">
                                        <div class="col-12">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead class="">
                                                            <tr>
                                                                <th scope="col">{{ __('messages.users_count') }}</th>
                                                                <th scope="col">{{ $data['users'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.ads_count') }}</th>
                                                                <th scope="col">{{ $data['ads'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.categories_count') }}</th>
                                                                <th scope="col">{{ $data['categories'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.contact_us_count') }}</th>
                                                                <th scope="col">{{ $data['contact_us'] }}</th>
                                                            </tr>
                                                            {{--  <tr>
                                                                <th scope="col">{{ __('messages.brands_count') }}</th>
                                                                <th scope="col">{{ $data['brands'] }}</th>
                                                            </tr>  --}}
                                                            <tr>
                                                                <th scope="col">{{ __('messages.sub_categories_count') }}</th>
                                                                <th scope="col">{{ $data['sub_categories'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.products_count') }}</th>
                                                                <th scope="col">{{ $data['products'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.offers_count') }}</th>
                                                                <th scope="col">{{ $data['offers'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.areas_count') }}</th>
                                                                <th scope="col">{{ $data['areas'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.orders_count') }}</th>
                                                                <th scope="col">{{ $data['orders'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.orders_count') }}</th>
                                                                <th scope="col">{{ $data['orders'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.in_progress_orders_count') }}</th>
                                                                <th scope="col">{{ $data['in_progress_orders'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.canceled_orders_count') }}</th>
                                                                <th scope="col">{{ $data['canceled_orders'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.delivered_orders_count') }}</th>
                                                                <th scope="col">{{ $data['delivered_orders'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.delivered_orders_cost') }}</th>
                                                                <th scope="col">{{ $data['delivered_orders_cost'] }} {{ __('messages.dinar') }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.canceled_orders_cost') }}</th>
                                                                <th scope="col">{{ $data['canceled_orders_cost'] }} {{ __('messages.dinar') }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.in_progress_orders_cost') }}</th>
                                                                <th scope="col">{{ $data['in_progress_orders_cost'] }} {{ __('messages.dinar') }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.total_orders_cost') }}</th>
                                                                <th scope="col">{{ $data['total_orders_cost'] }} {{ __('messages.dinar') }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.cash_orders_cost') }}</th>
                                                                <th scope="col">{{ $data['cash_orders_cost'] }} {{ __('messages.dinar') }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.key_net_orders_cost') }}</th>
                                                                <th scope="col">{{ $data['key_net_orders_cost'] }} {{ __('messages.dinar') }}</th>
                                                            </tr>
                                                            {{--  <tr>
                                                                <th scope="col">{{ __('messages.key_net_home_orders_cost') }}</th>
                                                                <th scope="col">{{ $data['key_net_home_orders_cost'] }} {{ __('messages.dinar') }}</th>
                                                            </tr>  --}}
                                                        </thead>
                                                        
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div> 

                            <div class="invoice-00002">
                                <div class="content-section  animated animatedFadeInUp fadeInUp">

                                    <div class="row inv--head-section">

                                        <div class="col-sm-6 col-12">
                                            <h3 class="in-heading">{{ __('messages.today_stats') }}</h3>
                                        </div>
                                        
                                        
                                    </div>

                                    <div class="row inv--detail-section">
                                        <div class="col-12">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead class="">
                                                            <tr>
                                                                <th scope="col">{{ __('messages.users_today_count') }}</th>
                                                                <th scope="col">{{ $data['users_today_count'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.contact_us_today_count') }}</th>
                                                                <th scope="col">{{ $data['contact_us_today_count'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.products_today_count') }}</th>
                                                                <th scope="col">{{ $data['products_today_count'] }}</th>
                                                            </tr>
                                                            
                                                            
                                                            <tr>
                                                                <th scope="col">{{ __('messages.today_orders_count') }}</th>
                                                                <th scope="col">{{ $data['today_orders'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.in_progress_orders_today_count') }}</th>
                                                                <th scope="col">{{ $data['in_progress_orders_today_count'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.canceled_orders_today_count') }}</th>
                                                                <th scope="col">{{ $data['canceled_orders_today_count'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.delivered_orders_today_count') }}</th>
                                                                <th scope="col">{{ $data['delivered_orders_today_count'] }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.today_delivered_orders_cost') }}</th>
                                                                <th scope="col">{{ $data['today_delivered_orders_cost'] }} {{ __('messages.dinar') }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.today_canceled_orders_cost') }}</th>
                                                                <th scope="col">{{ $data['today_canceled_orders_cost'] }} {{ __('messages.dinar') }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.today_in_progress_orders_cost') }}</th>
                                                                <th scope="col">{{ $data['today_in_progress_orders_cost'] }} {{ __('messages.dinar') }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.today_cash_cost') }}</th>
                                                                <th scope="col">{{ $data['today_cash_cost'] }} {{ __('messages.dinar') }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.today_key_net_cost') }}</th>
                                                                <th scope="col">{{ $data['today_key_net_cost'] }} {{ __('messages.dinar') }}</th>
                                                            </tr>
                                                            {{--  <tr>
                                                                <th scope="col">{{ __('messages.today_key_net_home_cost') }}</th>
                                                                <th scope="col">{{ $data['today_key_net_home_cost'] }} {{ __('messages.dinar') }}</th>
                                                            </tr>  --}}
                                                            
                                                        </thead>
                                                        
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="invoice-00003">
                                <div class="content-section  animated animatedFadeInUp fadeInUp">

                                    <div class="row inv--head-section">

                                        <div class="col-sm-6 col-12">
                                            <h3 class="in-heading">{{ __('messages.most_sold_product') }}</h3>
                                        </div>
                                        
                                        
                                    </div>

                                    <div class="row inv--detail-section">
                                        <div class="col-12">
                                            @foreach ($data['most_sold_products'] as $prod)
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead class="">
                                                            <tr>
                                                                <th scope="col">{{ __('messages.title_en') }}</th>
                                                                <th scope="col"><a target="_blank" href="{{ route('products.details', $prod) }}">{{ $prod->title_en }}</a> </th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.title_ar') }}</th>
                                                                <th scope="col">{{ $prod->title_ar }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.count') }}</th>
                                                                <th scope="col">{{ $prod->cnt }}</th>
                                                            </tr>
                                                            
                                                        </thead>
                                                        
                                                    </table>
                                                    
                                                </div>
                                            </div>
                                            @endforeach
                                            
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="invoice-00004">
                                <div class="content-section  animated animatedFadeInUp fadeInUp">

                                    <div class="row inv--head-section">

                                        <div class="col-sm-6 col-12">
                                            <h3 class="in-heading">{{ __('messages.most_area_order') }}</h3>
                                        </div>
                                        
                                        
                                    </div>

                                    <div class="row inv--detail-section">
                                        <div class="col-12">
                                            @foreach ($data['most_areas_order'] as $area)
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead class="">
                                                            <tr>
                                                                <th scope="col">{{ __('messages.title_en') }}</th>
                                                                <th scope="col"><a target="_blank" href="{{ route('areas.details', $area) }}">{{ $area->title_en }}</a> </th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.title_ar') }}</th>
                                                                <th scope="col">{{ $area->title_ar }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.orders_number') }}</th>
                                                                <th scope="col">{{ $area->cnt }}</th>
                                                            </tr>
                                                            
                                                        </thead>
                                                        
                                                    </table>
                                                    
                                                </div>
                                            </div>
                                            @endforeach
                                            
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="invoice-00005">
                                <div class="content-section  animated animatedFadeInUp fadeInUp">

                                    <div class="row inv--head-section">

                                        <div class="col-sm-6 col-12">
                                            <h3 class="in-heading">{{ __('messages.most_user_order') }}</h3>
                                        </div>
                                        
                                        
                                    </div>

                                    <div class="row inv--detail-section">
                                        @foreach ($data['most_users_order'] as $user)
                                        <div class="col-12">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead class="">
                                                            <tr>
                                                                <th scope="col">{{ __('messages.user_name') }}</th>
                                                                <th scope="col"><a target="_blank" href="{{ route('users.details', $user) }}">{{ $user->name }}</a> </th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">{{ __('messages.orders_number') }}</th>
                                                                <th scope="col">{{ $user->cnt }}</th>
                                                            </tr>
                                                            
                                                        </thead>
                                                        
                                                    </table>
                                                    
                                                </div>
                                            </div>
                                            
                                        </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="inv--thankYou">
                        <div class="row">
                            <div class="col-sm-12 col-12">
                                <p class="">Thank you for doing Business with us.</p>
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>

        </div>
    </div>
</div>
    
@endsection