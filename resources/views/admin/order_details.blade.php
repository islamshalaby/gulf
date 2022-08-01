@extends('admin.ecommerce_app')

@section('title' , __('messages.order_details'))

@section('content')
        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.order_details') }} 
                        @if ($data['order']['status'] == 4)
                            ( <a style="color: #1b55e2" target="_blank" href="{{ route('orders.invoice', $data['order']['id']) }}?download=1">
                                {{ __('messages.invoice') }}
                            </a> )
                        @endif
                    </h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table class="table table-bordered mb-4">
                    <tbody>
                        <tr>
                            <td class="label-table" > {{ __('messages.order_number') }}</td>
                            <td>
                                {{ $data['order']['order_number'] }}
                            </td>
                        </tr>
                        @if ($data['order']['status'] == 4)
                        <tr>
                            <td class="label-table" > {{ __('messages.invoice') }}</td>
                            <td>
                                <a href="{{ route('orders.invoice', $data['order']['id']) }}?download=1">
                                    {{ __('messages.invoice') }}
                                </a>
                            </td>
                        </tr>
                        @endif
                        
                        <tr>
                            <td class="label-table" > {{ __('messages.order_date') }}</td>
                            <td>
                                {{ $data['order']['created_at']->format("d-m-y") }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.user') }} </td>
                            <td>
                                <a target="_blank" href="{{ route('users.details', $data['order']->user->id) }}">
                                    {{ $data['order']->user->name }}
                                </a>
                            </td>
                        </tr>  
                        <tr>
                            <td class="label-table" > {{ __('messages.payment_method') }} </td>
                            <td>
                                @if($data['order']->payment_method == 1)
                                    {{ __('messages.key_net') }}
                                    @elseif ($data['order']->payment_method == 2)
                                    {{ __('messages.key_net_from_home') }}
                                    @else
                                    {{ __('messages.cash') }}
                                    @endif
                            </td>
                        </tr>  
                        <tr>
                            <td class="label-table" > {{ __('messages.status') }} </td>
                            <td>
                                @if($data['order']->status == 1)
                                {{ __('messages.in_progress') }}
                                @elseif ($data['order']->status == 2)
                                {{ __('messages.delivery_stage') }}
                                @elseif ($data['order']->status == 3)
                                {{ __('messages.installation') }}
                                @elseif ($data['order']->status == 4)
                                {{ __('messages.order_delivered') }}
                                @elseif ($data['order']->status == 5)
                                {{ __('messages.canceled_from_user') }}
                                @else
                                {{ __('messages.canceled_from_admin') }}
                                @endif
                            </td>
                        </tr>  
                        <tr>
                            <td class="label-table" > {{ __('messages.price') }} </td>
                            <td>
                                {{ $data['order']['subtotal_price'] . " " . __('messages.dinar') }}
                            </td>
                        </tr>  
                        <tr>
                            <td class="label-table" > {{ __('messages.delivery_cost') }} </td>
                            <td>
                                {{ $data['order']['delivery_cost'] . " " . __('messages.dinar') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.installation_cost') }} </td>
                            <td>
                                {{ $data['order']['installation_cost'] . " " . __('messages.dinar') }}
                            </td>
                        </tr>
                        @if ($data['order']['shipping_cost'] > 0)
                        <tr>
                            <td class="label-table" > {{ __('messages.shipping_cost') }} </td>
                            <td>
                                {{ $data['order']['shipping_cost'] . " " . __('messages.dinar') }}
                            </td>
                        </tr>
                        @endif
                        
                        <tr>
                            <td class="label-table" > {{ __('messages.total') }} </td>
                            <td>
                                {{ $data['order']['total_price'] . " " . __('messages.dinar') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.address') }} </td>
                            <td>
                                <a target="_blank" href="{{ route('address.details', $data['order']->address->id) }}">
                                {{ $data['order']->address->street }}
                                </a>
                            </td>
                        </tr>
                       
                    </tbody>
                </table>
                <h5>{{ __('messages.products') }}</h5>
                @foreach ($data['items'] as $item)
                <table class="table table-bordered mb-4">
                    <tbody>
                        @if ($item->shipment)
                        <tr style="background-color: #929292">
                            <td class="label-table" style="color : #EFEFEF" > {{ __('messages.shipment_number') }}</td>
                            <td style="color : #EFEFEF">
                                {{ $item->shipment->airway_bill_number }}
                            </td>
                        </tr>
                        @endif
                        
                        <tr>
                            <td class="label-table" > {{ __('messages.product') }}</td>
                            <td>
                                <a target="_blank" href="{{ route('products.details', $item->product_id) }}">
                                {{ App::isLocale('en') ? $item->product->title_en : $item->product->title_ar }}
                                </a> 
                                @if($item->status == 1)
                                    @if($item->shipping == 3)
                                    <a class="btn btn-danger" onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="{{ route('orders.cancel.item', [$item->id, 'shipping']) }}">
                                        {{ __('messages.cancel') }}
                                    </a>
                                    @else
                                    <a class="btn btn-danger" onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="{{ route('orders.cancel.item', [$item->id, 'other']) }}">
                                        {{ __('messages.cancel') }}
                                    </a>
                                    @endif
                                @endif
                                @if($item->shipping == 2 && $item->status == 4)
                                <a class="btn btn-info" onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="{{ route('orders.install.item', $item->id) }}">
                                    {{ __('messages.installation') }}
                                </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.delivery_method') }}</td>
                            <td>
                                @if($item->shipping == 1)
                                {{ __('messages.only_delivery') }}
                                @elseif ($item->shipping == 2)
                                {{ __('messages.delivery_and_installation') }}
                                @elseif ($item->shipping == 3)
                                {{ __('messages.global_shipping') }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.count') }}</td>
                            <td>
                                {{ $item->count }}
                            </td>
                        </tr>
                        
                        
                        <tr>
                            <td class="label-table" > {{ __('messages.price_before_discount') }}</td>
                            <td>
                                {{ $item->price_before_offer == 0 ? $item->final_price : $item->price_before_offer }} {{ __('messages.dinar') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.price_after_discount') }}</td>
                            <td>
                                {{ $item->final_price }} {{ __('messages.dinar') }}
                            </td>
                        </tr>
                        @if ($item->shipping == 2)
                        <tr>
                            <td class="label-table" > {{ __('messages.status') }}</td>
                            <td>
                                @if($item->status == 3)
                                {{ __('messages.installed') }}
                                @else
                                {{ __('messages.not_installed') }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        
                    </tbody>
                </table>
                @endforeach
                
            </div>
        </div>
    </div>  
    
@endsection