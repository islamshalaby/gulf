@extends('admin.ecommerce_app')

@section('title' , __('messages.order_details'))

@section('content')
        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.order_details') }} 
                        @if ($data['order']['status'] == 2)
                            ( <a style="color: #1b55e2" target="_blank" href="{{ route('orders.invoice', $data['order']['id']) }}">
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
                        @if ($data['order']['status'] == 2)
                        <tr>
                            <td class="label-table" > {{ __('messages.invoice') }}</td>
                            <td>
                                <a href="{{ route('orders.invoice', $data['order']['id']) }}">
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
                                <a href="{{ route('orders.action', [$data['order']->id, 3]) }}" onclick='return confirm("{{ __('messages.are_you_sure') }}");' class="btn btn-sm btn-danger">
                                    {{ __('messages.cancel_order') }}
                                </a>
                                <a href="{{ route('orders.action', [$data['order']->id, 2]) }}" onclick='return confirm("{{ __('messages.are_you_sure') }}");' class="btn btn-sm btn-success">
                                    {{ __('messages.order_delivered') }}
                                </a>
                                @elseif ($data['order']->status == 2)
                                {{ __('messages.delivered') }}
                                @else
                                {{ __('messages.canceled') }}
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
                @foreach ($data['order']->items as $item)
                <table class="table table-bordered mb-4">
                    <tbody>
                        <tr>
                            <td class="label-table" > {{ __('messages.product') }}</td>
                            <td>
                                <a target="_blank" href="{{ route('products.details', $item->product_id) }}">
                                {{ App::isLocale('en') ? $item->title_en : $item->title_ar }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.count') }}</td>
                            <td>
                                {{ $item->count }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                @endforeach
                
            </div>
        </div>
    </div>  
    
@endsection