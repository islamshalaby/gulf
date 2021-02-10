@extends('admin.ecommerce_app')

@section('title' , __('messages.invoice'))
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
                            
                            <ul class="nav nav-pills inv-list-container d-block" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <div class="nav-link list-actions" id="invoice-{{ $data['order']['order_number'] }}" data-invoice-id="{{ $data['order']['order_number'] }}">
                                        <div class="f-m-body">
                                            <div class="f-head">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                            </div>
                                            <div class="f-body">
                                                <p class="invoice-number">{{ __('messages.invoice') }} #{{ $data['order']['order_number'] }}</p>
                                                <p class="invoice-customer-name"><span>{{ __('messages.to') }}:</span> {{ $data['order']->user->name }}</p>
                                                <p class="invoice-generated-date">{{ __('messages.date') }}: {{ $data['order']['created_at']->format("d-m-y") }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="invoice-container">
                    <div class="invoice-inbox ps ps--active-y" style="height: calc(100vh - 197px);">

                        <div class="inv-not-selected" style="display: none;">
                            <p>Open an invoice from the list.</p>
                        </div>

                        <div class="invoice-header-section" style="display: flex;">
                            <h4 class="inv-number">{{ $data['order']['order_number'] }}#</h4>
                            <div class="invoice-action">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer action-print" data-toggle="tooltip" data-placement="top" data-original-title="Reply"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                            </div>
                        </div>
                        
                        <div id="ct" class="" style="display: block;">
                            
                            <div class="invoice-{{ $data['order']['order_number'] }}">
                                <div class="content-section  animated animatedFadeInUp fadeInUp">

                                    <div class="row inv--head-section">

                                        <div class="col-sm-6 col-12">
                                            <h3 class="in-heading">{{ __('messages.invoice') }}</h3>
                                        </div>
                                        <div class="col-sm-6 col-12 align-self-center text-sm-right">
                                            <div class="company-info">
                                                <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1581928924/<?=Auth::user()->custom['setting']['logo']?>" class="navbar-logo" alt="logo">
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row inv--detail-section">

                                        <div class="col-sm-7 align-self-center">
                                            <p class="inv-to">{{ __('messages.customer_data') }}</p>
                                        </div>
                                        <div class="col-sm-5 align-self-center  text-sm-right order-sm-0 order-1">
                                            {{-- <p class="inv-detail-title">{{ __('messages.from') }} : {{ __('messages.company') }}</p> --}}
                                        </div>
                                        
                                        <div class="col-sm-7 align-self-center">
                                            <p style="font-size: 18px;" class="inv-customer-name">{{ $data['order']->user->name }}</p>
                                            <p style="font-size: 18px;" class="inv-street-addr"><a style="text-decoration: none" href="https://www.google.com/maps/?q={{ $data['order']->address->latitude }},{{ $data['order']->address->longitude }}" target="_blank"> {{ $data['order']->address->area->title_en . ", " . __('messages.st') . " " . $data['order']->address->street . ", " . __('messages.piece') . " " . $data['order']->address->piece . ", " . __('messages.gaddah') . " " . $data['order']->address->gaddah  }} <br/> {{ __('messages.home') . " " . $data['order']->address->building . ', ' . __('messages.floor') . " "  . $data['order']->address->floor . ', ' . __('messages.apartment') . " " . $data['order']->address->apartment_number }}</a></p>
                                            <p class="inv-email-address">{{ $data['order']->user->phone }}</p>
                                            <p class="inv-email-address">{{ $data['order']->user->email }}</p>
                                            <p class="inv-email-address">{{ __('messages.additional_details') }} :</p>
                                            <i>{{ $data['order']->address->extra_details }}</i>
                                        </div>
                                        <div class="col-sm-5 align-self-center  text-sm-right order-2">
                                            <p class="inv-list-number"><span class="inv-title">{{ __('messages.order_number') }}: </span> <span class="inv-number">#{{ $data['order']['order_number'] }}</span></p>
                                            <p class="inv-created-date"><span class="inv-title">{{ __('messages.date') }} : </span> <span class="inv-date">{{ $data['order']['created_at']->format("d-m-y") }}</span></p>
                                            {{-- <p class="inv-due-date"><span class="inv-title">Due Date : </span> <span class="inv-date">26 Aug 2019</span></p> --}}
                                        </div>
                                    </div>

                                    <div class="row inv--product-table-section">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead class="">
                                                        <tr>
                                                            <th scope="col">S.No</th>
                                                            <th scope="col">{{ __('messages.items') }}</th>
                                                            <th class="text-right" scope="col">{{ __('messages.quantity') }}</th>
                                                            <th class="text-right" scope="col">{{ __('messages.product_price') }}</th>
                                                            <th class="text-right" scope="col">{{ __('messages.total') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data['order']->oItems as $item)
                                                        <tr>
                                                            <td>{{ $item->product->id }}</td>
                                                            <td>{{ App::isLocale('en') ? $item->product->title_en : $item->product->title_ar }}</td>
                                                            <td class="text-right">{{ $item->count }}</td>
                                                            <td class="text-right">{{ $item->option_id == 0 ? $item->product->final_price : $item->multiOption->final_price }} {{ __('messages.dinar') }}</td>
                                                            <td class="text-right">{{ $item->option_id == 0 ? (double)$item->product->final_price * (double)$item->count : (double)$item->multiOption->final_price * (double)$item->count }} {{ __('messages.dinar') }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-sm-5 col-12 order-sm-0 order-1">
                                            <div class="inv--payment-info">
                                                <div class="row">
                                                    <div class="col-sm-12 col-12">
                                                        <h6 class=" inv-title">{{ __('messages.payment_method') }}:</h6>
                                                    </div>
                                                    <div class="col-sm-4 col-12">
                                                        <p class=" inv-subtitle">
                                                        @if($data['order']->payment_method == 1)
                                                        {{ __('messages.key_net') }}
                                                        @elseif ($data['order']->payment_method == 2)
                                                        {{ __('messages.key_net_from_home') }}
                                                        @else
                                                        {{ __('messages.cash') }}
                                                        @endif
                                                        </p>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7 col-12 order-sm-1 order-0">
                                            <div class="inv--total-amounts text-sm-right">
                                                <div class="row">
                                                    <div class="col-sm-8 col-7">
                                                        <p class="">{{ __('messages.sub_total') }}: </p>
                                                    </div>
                                                    <div class="col-sm-4 col-5">
                                                        <p class="">{{ $data['order']['subtotal_price'] }} {{ __('messages.dinar') }}</p>
                                                    </div>
                                                    <div class="col-sm-8 col-7">
                                                        <p class="">{{ __('messages.delivery_cost') }}: </p>
                                                    </div>
                                                    <div class="col-sm-4 col-5">
                                                        <p class="">{{ $data['order']['delivery_cost'] }} {{ __('messages.dinar') }}</p>
                                                    </div>
                                                    <div class="col-sm-8 col-7 grand-total-title">
                                                        <h4 class="">{{ __('messages.invoice_total') }} : </h4>
                                                    </div>
                                                    <div class="col-sm-4 col-5 grand-total-amount">
                                                        <h4 class="">{{ $data['order']['total_price'] }} {{ __('messages.dinar') }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div> 
                        </div>


                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px; height: 459px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 271px;"></div></div><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px; height: 459px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 271px;"></div></div></div>

                    <div class="inv--thankYou" style="display: block;">
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