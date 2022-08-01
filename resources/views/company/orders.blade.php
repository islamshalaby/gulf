@extends('company.app')
@php
    $title = __('messages.show_orders');
    if (!empty($data['from'])) {
        $title = __('messages.show_orders') . " ( " . __('messages.from') . ": " . $data['from'] . " " . __('messages.to') . ": " . $data['to'] . " )";
    }else if (isset($data['area'])) {
        if (App::isLocale('en')) {
            $title = __('messages.show_orders') . " ( " . $data['area']['name_en'] . " )";
        }else {
            $title = __('messages.show_orders') . " ( " . $data['area']['name_ar'] . " )";
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
        $("#area_select, #toDate, #payment_select, #orderStatus").on("change", function() {
            $("#filter-form").submit()
        })
    </script>
    
    

    <script>
        var ttle = "{{ $title }}",
            sumPrice = "{{ $data['sum_price'] }}",
            priceString = "{{ __('messages.price') }}",
            deliveryString = "{{ __('messages.delivery_cost') }}",
            sumInstallation = "{{ __('messages.installation_cost') }}",
            totalInstallation = "{{ $data['sum_installation'] }}",
            totalDelivery = "{{ $data['sum_delivery'] }}",
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
                            $(win.document.body).prepend(`<br /><h4 style="border-bottom: 1px solid; padding : 10px">${priceString} : ${sumPrice} ${dinar} | ${deliveryString} : ${totalDelivery} ${dinar} | ${totalString} : ${sumTotal} ${dinar}</h4>`); //before the table
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
            installation = dTbls.column(8).data(),
            total = dTbls.column(9).data(),
            dinar = "{{ __('messages.dinar') }}"
        var totalPrice = parseFloat(price.reduce(function (a, b) { return parseFloat(a) + parseFloat(b); }, 0)).toFixed(3),
            totalDelivery = parseFloat(delivery.reduce(function (a, b) { return parseFloat(a) + parseFloat(b); }, 0)).toFixed(3),
            totalInstallation = parseFloat(installation.reduce(function (a, b) { return parseFloat(a) + parseFloat(b); }, 0)).toFixed(3),
            allTotal = parseFloat(total.reduce(function (a, b) { return parseFloat(a) + parseFloat(b); }, 0)).toFixed(3)

        $("#order-tbl tfoot").find('th').eq(6).text(`${totalPrice} ${dinar}`);
        $("#order-tbl tfoot").find('th').eq(7).text(`${totalDelivery} ${dinar}`);
        $("#order-tbl tfoot").find('th').eq(8).text(`${totalInstallation} ${dinar}`);
        {{-- $("#order-tbl tfoot").find('th').eq(9).text(`${allTotal} ${dinar}`); --}}
    </script>
    
@endpush

@section('content')
@if(Session::has('success'))
    <div class="alert alert-icon-left alert-light-success mb-4" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12" y2="17"></line></svg>
        <strong>{{ Session('success') }}</strong>
    </div>
@endif
@if(Session::has('danger'))
    <div class="alert alert-arrow-right alert-icon-right alert-light-danger mb-4" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
            <strong>{{ Session('danger') }}</strong>
    </div>
@endif
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing"> 
        <div class="statbox widget box box-shadow">
            <div class="col-lg-12 filtered-list-search mx-auto">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('orders.company.index') }}" type="button" class="btn btn-{{ ( strpos($url,'show') !== false && !isset($data['order_status']) ) || strpos($url,'fetchbydate') !== false ? 'light' : 'dark' }}">{{ __('messages.all_orders') }}</a>
                    <a href="?order_status=opened" type="button" class="btn btn-{{ isset($data['order_status']) && $data['order_status'] == 'opened' ? 'light' : 'dark' }}">{{ __('messages.open_orders') }}</a>
                    <a href="?order_status=closed" type="button" class="btn btn-{{ isset($data['order_status']) && $data['order_status'] == 'closed' ? 'light' : 'dark' }}">{{ __('messages.closed_orders') }}</a>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form id="filter-form" method="" action="">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="area">{{ __('messages.area') }}</label>
                            <select required id="area_select" name="area_id" class="form-control">
                                <option disabled selected>{{ __('messages.select') }}</option>
                                @foreach ( $data['areas'] as $area )
                                <option {{ isset($data['area']) && $data['area']['id'] == $area->id ? 'selected' : '' }} value="{{ $area->id }}">{{ App::isLocale('en') ? $area->name_en : $area->name_en }}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="from">{{ __('messages.from') }}</label>
                                        <input required type="date" name="from" class="form-control" value="{{ isset($data['from']) && !empty($data['from']) ? $data['from'] : '' }}" id="from" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="toDate">{{ __('messages.to') }}</label>
                                        <input required type="date" name="to" class="form-control" value="{{ isset($data['to']) && !empty($data['to']) ? $data['to'] : '' }}" id="toDate" >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="payment_select">{{ __('messages.payment_method') }}</label>
                            <select required id="payment_select" name="method" class="form-control">
                                <option disabled selected>{{ __('messages.select') }}</option>
                                <option {{ isset($data['method']) && $data['method'] == 1 ? 'selected' : '' }} value="1">{{ __('messages.cash') }}</option>
                                <option {{ isset($data['method']) && $data['method'] == 2 ? 'selected' : '' }} value="2">{{ __('messages.key_net') }}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="orderStatus">{{ __('messages.status') }}</label>
                            <select required id="orderStatus" name="order_status2" class="form-control">
                                <option disabled selected>{{ __('messages.select') }}</option>
                                
                                <option {{ isset($data['order_status2']) && $data['order_status2'] == '1' ? 'selected' : '' }} value="1">{{ __('messages.inprogress') }}</option>
                                <option {{ isset($data['order_status2']) && $data['order_status2'] == '2' ? 'selected' : '' }} value="2">{{ __('messages.delivery_stage') }}</option>
                                <option {{ isset($data['order_status2']) && $data['order_status2'] == '4' ? 'selected' : '' }} value="4">{{ __('messages.delivered') }}</option>
                                <option {{ isset($data['order_status2']) && $data['order_status2'] == '5' ? 'selected' : '' }} value="5">{{ __('messages.canceled_from_user') }}</option>
                                <option {{ isset($data['order_status2']) && $data['order_status2'] == '6' ? 'selected' : '' }} value="6">{{ __('messages.canceled_from_admin') }}</option>
                                
                            </select>
                        </div>
                        
                    </div>
                </form>
        
            </div>
            
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.show_orders') }} 
                        @if (isset($data['area']))
                            @if(App::isLocale('en'))
                                {{ "( " . $data['area']['name_en'] . " )" }}
                            @else
                                {{ "( " . $data['area']['name_ar'] . " )" }}
                            @endif
                        @endif
                        <button data-show="0" class="btn btn-primary show_actions">{{ __('messages.hide_actions') }}</button>
                    </h4>
                    @php
                        $queryArray = [];
                        if (isset($data['order_status'])) {
                            $queryArray['order_status'] = $data['order_status'];
                        }
                        if(isset($data['area_id'])) {
                            $queryArray['area_id'] = $data['area_id'];
                        }
                        if(isset($data['from']) && isset($data['to'])) {
                            $queryArray['from'] = $data['from'];
                            $queryArray['to'] = $data['to'];
                        }
                        if(isset($data['method'])) {
                            $queryArray['method'] = $data['method'];
                        }
                        if(isset($data['order_status2'])) {
                            $queryArray['order_status2'] = $data['order_status2'];
                        }
                        $queryArray['company_id'] = $data['company_id'];
                    @endphp
                    <a href="{{ route('webview.company.mainReport', $queryArray) }}" target="_blank" class="btn btn-primary">{{ __('messages.print') . ' ' . __('messages.orders_report') }}</a>
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
                            {{--  <th class="hide_col text-center">{{ __('messages.actions') }}</th>  --}}
                            <th class="text-center hide_col">{{ __('messages.details') }}</th>
                            <th class="text-center hide_col">{{ __('messages.invoice') }}</th>
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
                                    {{ $order->user->name }}
                                </td>
                                <td>
                                    @if($order->payment_method == 1)
                                    {{ __('messages.cash') }}
                                    @else
                                    {{ __('messages.key_net') }}
                                    @endif
                                </td>
                                <td>
                                    @if($order->oItemCompany($data['company_id'])->status == 1)
                                    {{ __('messages.inprogress') }}
                                    @elseif ($order->oItemCompany($data['company_id'])->status == 2)
                                    {{ __('messages.delivery_stage') }}
                                    @elseif ($order->oItemCompany($data['company_id'])->status == 4)
                                    {{ __('messages.delivered') }}
                                    @elseif ($order->oItemCompany($data['company_id'])->status == 5)
                                    {{ __('messages.canceled_from_user') }}
                                    @elseif ($order->oItemCompany($data['company_id'])->status == 6)
                                    {{ __('messages.canceled_from_admin') }}
                                    @endif
                                </td>
                                <td>{{ $order->oItemsCompany($data['company_id'])->sum('final_with_delivery') . " " . __('messages.dinar') }}</td>
                                @php
                                $dCost = "0.000";
                                 if ($order->address->goveronrateArea->deliveryCompany($data['company_id'])->delivery_cost) {
                                    $dCost = $order->address->goveronrateArea->deliveryCompany($data['company_id'])->delivery_cost;
                                 }   
                                @endphp
                                <td>{{ $dCost . " " . __('messages.dinar') }}</td>
                                <td>{{ $order->oItemsCompany($data['company_id'])->sum('final_with_delivery') + $dCost . " " . __('messages.dinar') }}</td>
                                {{--  <td class="hide_col text-center">
                                    @if($order->oItemCompany($data['company_id'])->status == 1)
                                    <a style="margin-bottom: 5px" href="{{ route('orders.company.action', [$order->id, 2]) }}" onclick='return confirm("{{ __('messages.are_you_sure') }}");' class="btn btn-sm btn-info hide_col">
                                        {{ __('messages.delivery_stage') }}
                                    </a>
                                    
                                    <a style="margin-bottom: 5px" href="{{ route('orders.company.action', [$order->id, 6]) }}" onclick='return confirm("{{ __('messages.are_you_sure') }}");' class="btn btn-sm btn-danger hide_col">
                                        {{ __('messages.cancel_order') }}
                                    </a>
                                    @elseif($order->oItemCompany($data['company_id'])->status == 2)
                                    @if ($order->oItemsCompany($data['company_id'])->sum('installation_cost') < 1)
                                    <a style="margin-bottom: 5px" href="{{ route('orders.company.action', [$order->id, 4]) }}" onclick='return confirm("{{ __('messages.are_you_sure') }}");' class="btn btn-sm btn-success hide_col">
                                        {{ __('messages.order_delivered') }}
                                    </a>
                                    @endif
                                    
                                    @endif
                                    @if ($order->oItemCompany($data['company_id'])->status == 3)
                                    <a style="margin-bottom: 5px" href="{{ route('orders.company.action', [$order->id, 4]) }}" onclick='return confirm("{{ __('messages.are_you_sure') }}");' class="btn btn-sm btn-success hide_col">
                                        {{ __('messages.order_delivered') }}
                                    </a>
                                    @endif
                                </td>  --}}
                                <td class="text-center blue-color hide_col"><a href="{{ route('orders.company.details', $order->id) }}" target="_blank" ><i class="far fa-eye"></i></a></td>
                                <td class="text-center blue-color hide_col"><a href="{{ route('orders.company.invoice', $order->id) }}?download=1" target="_blank" ><i class="far fa-eye"></i></a></td>
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
                          <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>  

@endsection