@extends('admin.ecommerce_app')
@php
    $title = __('messages.show_orders');
    if (!empty($data['from'])) {
        $title = __('messages.show_orders') . " ( " . __('messages.from') . ": " . $data['from'] . " " . __('messages.to') . ": " . $data['to'] . " )";
    }else if (isset($data['area'])) {
        if (App::isLocale('en')) {
            $title = __('messages.show_orders') . " ( " . $data['area']['title_en'] . " )";
        }else {
            $title = __('messages.show_orders') . " ( " . $data['area']['title_ar'] . " )";
        }
        
    }else if(isset($data['method'])) {
        if($data['method'] == 1) {
            $title = __('messages.show_orders') . " ( " . __('messages.key_net') . " )";
        }elseif ($data['method'] == 2) {
            $title = __('messages.show_orders') . " ( " . __('messages.key_net_from_home') . " )";
        }else {
            $title = __('messages.show_orders') . " ( " . __('messages.cash') . " )";
        }
    }
@endphp

@section('title' , $title )
@php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
@endphp

@push('scripts')
    <script>
        var language = "{{ Config::get('app.locale') }}"
        $("#area_select").on("change", function() {
            $("#areaForm").submit()
        })
        $("#toDate").on("change", function() {
            console.log("test")
            $("#dateForm").submit()
        })
        $("#payment_select").on("change", function() {
            $("#paymentForm").submit()
        })
    </script>
    
    

    <script>
        var ttle = "{{ $title }}",
            sumPrice = "{{ $data['sum_price'] }}",
            priceString = "{{ __('messages.price') }}",
            deliveryString = "{{ __('messages.delivery_cost') }}",
            sumDelivery = "{{ $data['sum_delivery'] }}",
            sumTotal = "{{ $data['sum_total'] }}",
            totalString = "{{ __('messages.total_with_delivery') }}",
            dinar = "{{ __('messages.dinar') }}"
        var dTbls = $('#order-tbl').DataTable( {
            dom: 'Blfrtip',
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn', footer: true, exportOptions: {
                        columns: ':visible',
                        rows: ':visible'
                    }},
                    { extend: 'csv', className: 'btn', footer: true, exportOptions: {
                        columns: ':visible',
                        rows: ':visible'
                    } },
                    { extend: 'excel', className: 'btn', footer: true, exportOptions: {
                        columns: ':visible',
                        rows: ':visible'
                    } },
                    { extend: 'print', className: 'btn', footer: true, 
                        exportOptions: {
                            columns: ':visible',
                            rows: ':visible'
                        },customize: function(win) {
                            $(win.document.body).prepend(`<br /><h4 style="border-bottom: 1px solid; padding : 10px">${priceString} : ${sumPrice} ${dinar} | ${deliveryString} : ${sumDelivery} ${dinar} | ${totalString} : ${sumTotal} ${dinar}</h4>`); //before the table
                          }
                    }
                ]
            },
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [50, 100, 1000, 10000, 100000, 1000000, 2000000, 3000000, 4000000, 5000000],
            "pageLength": 50  
        } );
    </script>
    <script>
        var price = dTbls.column(6).data(),
            delivery = dTbls.column(7).data(),
            total = dTbls.column(8).data(),
            dinar = "{{ __('messages.dinar') }}"
        var totalPrice = parseFloat(price.reduce(function (a, b) { return parseFloat(a) + parseFloat(b); }, 0)).toFixed(2),
            totalDelivery = parseFloat(delivery.reduce(function (a, b) { return parseFloat(a) + parseFloat(b); }, 0)).toFixed(2),
            allTotal = parseFloat(total.reduce(function (a, b) { return parseFloat(a) + parseFloat(b); }, 0)).toFixed(2)

        $("#order-tbl tfoot").find('th').eq(6).text(`${totalPrice} ${dinar}`);
        $("#order-tbl tfoot").find('th').eq(7).text(`${totalDelivery} ${dinar}`);
        $("#order-tbl tfoot").find('th').eq(8).text(`${allTotal} ${dinar}`);
    </script>
    
@endpush

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing"> 
        <div class="statbox widget box box-shadow">
            <div class="col-lg-12 filtered-list-search mx-auto">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('orders.index') }}" type="button" class="btn btn-{{ strpos($url,'show') !== false || strpos($url,'fetchbydate') !== false ? 'light' : 'dark' }}">{{ __('messages.all_orders') }}</a>
                    <a href="{{ route('orders.filter', 1) }}" type="button" class="btn btn-{{ request()->segment(count(request()->segments())) == 1 ? 'light' : 'dark' }}">{{ __('messages.in_progress_orders') }}</a>
                    <a href="{{ route('orders.filter', 3) }}" type="button" class="btn btn-{{ request()->segment(count(request()->segments())) == 3 ? 'light' : 'dark' }}">{{ __('messages.canceled_orders') }}</a>
                    <a href="{{ route('orders.filter', 2) }}" type="button" class="btn btn-{{ request()->segment(count(request()->segments())) == 2 ? 'light' : 'dark' }}">{{ __('messages.delivered_orders') }}</a>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="row">
                    <div class="form-group col-md-3">
                        <form id="areaForm" method="" action="{{ strpos($url,'filter') !== false ? '' : route('orders.fetchbyarea') }}">
                            
                            <label for="area">{{ __('messages.area') }}</label>
                            <select required id="area_select" name="area_id" class="form-control">
                                <option disabled selected>{{ __('messages.select') }}</option>
                                @foreach ( $data['areas'] as $area )
                                <option {{ isset($data['area']) && $data['area']['id'] == $area->id ? 'selected' : '' }} value="{{ $area->id }}">{{ App::isLocale('en') ? $area->title_en : $area->title_ar }}</option>
                                @endforeach 
                            </select>
                                
                        </form>
                    </div>
                    <div class="form-group col-md-6">
                        <form id="dateForm" method="" action="{{ strpos($url,'filter') !== false ? '' : route('orders.fetchbydate') }}">
                            <div class="form-group mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="from">{{ __('messages.from') }}</label>
                                        <input required type="date" name="from" class="form-control" id="from" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="toDate">{{ __('messages.to') }}</label>
                                        <input required type="date" name="to" class="form-control" id="toDate" >
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>

                    <div class="form-group col-md-3">
                        <form id="paymentForm" method="" action="{{ strpos($url,'filter') !== false ? '' : route('orders.fetchbypayment') }}">
                            
                            <label for="payment_select">{{ __('messages.payment_method') }}</label>
                            <select required id="payment_select" name="method" class="form-control">
                                <option disabled selected>{{ __('messages.select') }}</option>
                                
                                <option {{ isset($data['method']) && $data['method'] == 1 ? 'selected' : '' }} value="1">{{ __('messages.key_net') }}</option>
                                <option {{ isset($data['method']) && $data['method'] == 2 ? 'selected' : '' }} value="2">{{ __('messages.key_net_from_home') }}</option>
                                <option {{ isset($data['method']) && $data['method'] == 3 ? 'selected' : '' }} value="3">{{ __('messages.cash') }}</option>
                                
                            </select>
                                
                        </form>
                    </div>
                </div>
                
        
            </div>
            
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.show_orders') }} 
                        @if (isset($data['area']))
                            @if(App::isLocale('en'))
                                {{ "( " . $data['area']['title_en'] . " )" }}
                            @else
                                {{ "( " . $data['area']['title_ar'] . " )" }}
                            @endif
                        @endif
                        <button data-show="0" class="btn btn-primary show_actions">{{ __('messages.hide_actions') }}</button>
                    </h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="order-tbl" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>{{ __('messages.order_number') }}</th>
                            <th>{{ __('messages.order_date') }}</th>
                            <th>{{ __('messages.user') }}</th>
                            <th>{{ __('messages.payment_method') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.price') }}</th>
                            <th>{{ __('messages.delivery_cost') }}</th>
                            <th>{{ __('messages.total_with_delivery') }}</th>
                            <th class="hide_col text-center">{{ __('messages.actions') }}</th>
                            <th class="text-center hide_col">{{ __('messages.details') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <?php $i = 1; ?>
                        @foreach ($data['orders'] as $order)
                            <tr>
                                <td><?=$i;?></td>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format("d-m-y") }}</td>
                                <td>
                                    <a target="_blank" href="{{ route('users.details', $order->user->id) }}">
                                    {{ $order->user->name }}
                                    </a>
                                </td>
                                <td>
                                    @if($order->payment_method == 1)
                                    {{ __('messages.key_net') }}
                                    @elseif ($order->payment_method == 2)
                                    {{ __('messages.key_net_from_home') }}
                                    @else
                                    {{ __('messages.cash') }}
                                    @endif
                                </td>
                                <td>
                                    @if($order->status == 1)
                                    {{ __('messages.in_progress') }}
                                    @elseif ($order->status == 2)
                                    {{ __('messages.delivery_stage') }}
                                    @elseif ($order->status == 3)
                                    {{ __('messages.installation') }}
                                    @elseif ($order->status == 4)
                                    {{ __('messages.order_delivered') }}
                                    @else
                                    {{ __('messages.canceled') }}
                                    @endif
                                </td>
                                <td>{{ $order->subtotal_price . " " . __('messages.dinar') }}</td>
                                <td>{{ $order->delivery_cost . " " . __('messages.dinar') }}</td>
                                <td>{{ $order->total_price . " " . __('messages.dinar') }}</td>
                                <td class="hide_col text-center">
                                    @if($order->status == 1)
                                    <a style="margin-bottom: 5px" href="{{ route('orders.action', [$order->id, 2]) }}" onclick='return confirm("{{ __('messages.are_you_sure') }}");' class="btn btn-sm btn-info hide_col">
                                        {{ __('messages.delivery_stage') }}
                                    </a>
                                    <a style="margin-bottom: 5px" href="{{ route('orders.action', [$order->id, 3]) }}" onclick='return confirm("{{ __('messages.are_you_sure') }}");' class="btn btn-sm btn-primary hide_col">
                                        {{ __('messages.installation') }}
                                    </a>
                                    <a style="margin-bottom: 5px" href="{{ route('orders.action', [$order->id, 4]) }}" onclick='return confirm("{{ __('messages.are_you_sure') }}");' class="btn btn-sm btn-success hide_col">
                                        {{ __('messages.order_delivered') }}
                                    </a>
                                    <a style="margin-bottom: 5px" href="{{ route('orders.action', [$order->id, 5]) }}" onclick='return confirm("{{ __('messages.are_you_sure') }}");' class="btn btn-sm btn-danger hide_col">
                                        {{ __('messages.cancel_order') }}
                                    </a>
                                    @elseif($order->status == 4)
                                    <a style="margin-bottom: 5px" href="{{ route('orders.action', [$order->id, 2]) }}" onclick='return confirm("{{ __('messages.are_you_sure') }}");' class="btn btn-sm btn-info hide_col">
                                        {{ __('messages.delivery_stage') }}
                                    </a>
                                    <a style="margin-bottom: 5px" href="{{ route('orders.action', [$order->id, 3]) }}" onclick='return confirm("{{ __('messages.are_you_sure') }}");' class="btn btn-sm btn-primary hide_col">
                                        {{ __('messages.installation') }}
                                    </a>
                                    <a style="margin-bottom: 5px" href="{{ route('orders.action', [$order->id, 5]) }}" onclick='return confirm("{{ __('messages.are_you_sure') }}");' class="btn btn-sm btn-danger hide_col">
                                        {{ __('messages.cancel_order') }}
                                    </a>
                                    @else
                                    
                                    <a style="margin-bottom: 5px" href="{{ route('orders.action', [$order->id, 2]) }}" onclick='return confirm("{{ __('messages.are_you_sure') }}");' class="btn btn-sm btn-info hide_col">
                                        {{ __('messages.delivery_stage') }}
                                    </a>
                                    <a style="margin-bottom: 5px" href="{{ route('orders.action', [$order->id, 3]) }}" onclick='return confirm("{{ __('messages.are_you_sure') }}");' class="btn btn-sm btn-primary hide_col">
                                        {{ __('messages.installation') }}
                                    </a>
                                    <a href="{{ route('orders.action', [$order->id, 4]) }}" onclick='return confirm("{{ __('messages.are_you_sure') }}");' class="btn btn-sm btn-success hide_col">
                                        {{ __('messages.order_delivered') }}
                                    </a>
                                    @endif

                                    
                                </td>
                                <td class="text-center blue-color hide_col"><a href="{{ route('orders.invoice', $order->id) }}" ><i class="far fa-eye"></i></a></td>
                            </tr>
                            <?php $i ++ ?>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                          <th>{{ __('messages.total') }}:</th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>  

@endsection