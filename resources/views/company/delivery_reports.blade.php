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
            $title = __('messages.show_orders') . " ( " . __('messages.cash') . " )";
        }else {
            $title = __('messages.show_orders') . " ( " . __('messages.wallet') . " )";
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
        $("#area_select, #toDate, #payment_select, #orderStatus, #shop_select").on("change", function() {
            $("#filter-form").submit()
        })
        
    </script>
    
    

    <script>
        var ttle = "{{ $title }}",
            sumPrice = "{{ $data['sum_price'] }}",
            priceString = "{{ __('messages.price') }}",
            deliveryString = "{{ __('messages.delivery_cost') }}",
            installationString = "{{ __('messages.installation_cost') }}",
            sumDelivery = "{{ $data['sum_delivery'] }}",
            sumInstallation = "{{ $data['sum_installation'] }}",
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
                            $(win.document.body).prepend(`<br /><h4 style="border-bottom: 1px solid; padding : 10px">${priceString} : ${sumPrice} ${dinar} | ${installationString} : ${sumInstallation} | ${totalString} : ${sumTotal} ${dinar}</h4>`); //before the table
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
        
        var price = dTbls.column(7).data(),
            {{--  delivery = dTbls.column(7).data(),  --}}
            installation = dTbls.column(8).data(),
            total = dTbls.column(9).data(),
            dinar = "{{ __('messages.dinar') }}"
            console.log(price)
        var totalPrice = parseFloat(price.reduce(function (a, b) { return parseFloat(a) + parseFloat(b); }, 0)).toFixed(3),
            {{--  totalDelivery = parseFloat(delivery.reduce(function (a, b) { return parseFloat(a) + parseFloat(b); }, 0)).toFixed(3),  --}}
            totalInstallation = parseFloat(installation.reduce(function (a, b) { return parseFloat(a) + parseFloat(b); }, 0)).toFixed(3),
            allTotal = parseFloat(total.reduce(function (a, b) { return parseFloat(a) + parseFloat(b); }, 0)).toFixed(3)

        $("#order-tbl tfoot").find('th').eq(7).text(`${totalPrice} ${dinar}`);
        {{--  $("#order-tbl tfoot").find('th').eq(8).text(`${totalDelivery} ${dinar}`);  --}}
        $("#order-tbl tfoot").find('th').eq(8).text(`${totalInstallation} ${dinar}`);
        $("#order-tbl tfoot").find('th').eq(9).text(`${allTotal} ${dinar}`);
    </script>
    
@endpush

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing"> 
        <div class="statbox widget box box-shadow">
            <div class="col-lg-12 filtered-list-search mx-auto">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('orders.company.deliveryReports.index') }}" type="button" class="btn btn-{{ ( strpos($url,'delivery-reports') !== false && !isset($data['order_status']) ) || strpos($url,'fetchbydate') !== false ? 'light' : 'dark' }}">{{ __('messages.all_orders') }}</a>
                    <a href="?order_status=in_progress" type="button" class="btn btn-{{ isset($data['order_status']) && $data['order_status'] == 'in_progress' ? 'light' : 'dark' }}">{{ __('messages.inprogress_orders') }}</a>
                    <a href="?order_status=delivered" type="button" class="btn btn-{{ isset($data['order_status']) && $data['order_status'] == 'delivered' ? 'light' : 'dark' }}">{{ __('messages.delivered_orders') }}</a>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form id="filter-form">
                    <div class="row">
                        <div class="form-group col-md-3">
                            
                            <label for="area">{{ __('messages.area') }}</label>
                            <select required id="area_select" name="area_id" class="form-control">
                                <option disabled selected>{{ __('messages.select') }}</option>
                                @foreach ( $data['areas'] as $area )
                                <option {{ isset($data['area']) && $data['area']['id'] == $area->id ? 'selected' : '' }} value="{{ $area->id }}">{{ App::isLocale('en') ? $area->name_en : $area->name_ar }}</option>
                                @endforeach 
                            </select>

                        </div>
                        <div class="form-group col-md-6">
                        
                            <div class="form-group mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="from">{{ __('messages.from') }}</label>
                                        <input value="{{ isset($data['from']) ? $data['from'] : '' }}" required type="date" name="from" class="form-control" id="from" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="toDate">{{ __('messages.to') }}</label>
                                        <input value="{{ isset($data['to']) ? $data['to'] : '' }}" required type="date" name="to" class="form-control" id="toDate" >
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
                    </div>
                </form>
        
            </div>
            
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.show_delivery_reports') }} 
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
                    <a href="{{ route('webview.company.deliveryReport', $queryArray) }}" target="_blank" class="btn btn-primary">{{ __('messages.print') . ' ' . __('messages.delivery_reports') }}</a>
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
                            <th>{{ __('messages.delivery_date') }}</th>
                            <th>{{ __('messages.user') }}</th>
                            <th>{{ __('messages.payment_method') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.product_price') }}</th>
                            <th>{{ __('messages.installation_cost') }}</th>
                            <th>{{ __('messages.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <?php $i = 1; ?>
                        @foreach ($data['orders'] as $order)
                            <tr>
                                <td><?=$i;?></td>
                                <td>{{ $order->order->order_number }}</td>
                                <td>{{ $order->created_at->format("d-m-y") }}</td>
                                <td>
                                    @if($order->order->status == 4)
                                    {{ $order->updated_at->format("d-m-y") }}
                                    @else
                                    {{ __('messages.inprogress') }}
                                    @endif
                                </td>
                                <td>
                                    <a target="_blank" href="{{ route('users.details', $order->order->user->id) }}">
                                    {{ $order->order->user->name }}
                                    </a>
                                </td>
                                
                                <td>
                                    @if($order->order->payment_method == 1)
                                    {{ __('messages.cash') }}
                                    @else
                                    {{ __('messages.key_net') }}
                                    @endif
                                </td>
                                <td>
                                    @if (in_array($order->status, [1, 2, 3]))
                                    {{ __('messages.inprogress') }}
                                    @elseif(in_array($order->status, [4]))
                                    {{ __('messages.delivered') }}
                                    @endif
                                </td>
                                <td>{{ $order->final_price . " " . __('messages.dinar') }}</td>
                                <td>{{ $order->installation_cost . " " . __('messages.dinar') }}</td>
                                @php
                                    $totalCost = ($order->final_price * $order->count) + ($order->installation_cost * $order->count);
                                @endphp
                                <td>{{ $totalCost . " " . __('messages.dinar') }}</td>
                                
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