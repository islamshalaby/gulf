<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Document</title>
    
</head>
<body dir="rtl">
    <div class="invoice-box" style="max-width: 800px;margin: auto;padding: 30px;border: 1px solid #eee;box-shadow: 0 0 10px rgba(0, 0, 0, .15);font-size: 16px;line-height: 24px;font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;color: #555;">
        <table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
            <tr class="top">
                <td colspan="7" style="padding: 5px;vertical-align: top;">
                    <table style="width: 100%;line-height: inherit;text-align: right;">
                        <tr>
                            <td class="title" style="padding: 5px;vertical-align: top;padding-bottom: 20px;font-size: 45px;line-height: 45px;color: #333;">
                                <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/h_200,w_200/v1581928924/{{ $data['company']['image'] }}" style="width:100px; max-width:300px;">
                            </td>
                            
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 20px;">
                                {{ __('messages.invoice') }} : {{ $data['order']['order_number'] }}<br>
                                {{ __('messages.date') }}: {{ $data['order']['created_at']->format("d-m-y") }}<br>
                                {{ __('messages.status') }}: 
                                @if ($data['order']['status'] == 1)
                                {{ __('messages.in_progress') }}
                                @elseif($data['order']['status'] == 2)
                                {{ __('messages.delivery_stage') }}
                                @elseif($data['order']['status'] == 3)
                                {{ __('messages.installation') }}
                                @elseif($data['order']['status'] == 4)
                                {{ __('messages.order_delivered') }}
                                @elseif($data['order']['status'] == 5)
                                {{ __('messages.canceled_from_user') }}
                                @elseif($data['order']['status'] == 6)
                                {{ __('messages.canceled_from_admin') }}
                                @endif
                                <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="7" style="padding: 5px;vertical-align: top;">
                    <table style="width: 100%;line-height: inherit;text-align: right;">
                        <tr>
                            <td style="padding: 5px;vertical-align: top;padding-bottom: 40px;">
                                <h4 style="margin-bottom: 50px;">{{ __('messages.customer_data') }}</h4><br>
                                {{ $data['order']->user->name }}<br>
                                <a style="text-decoration: none" href="https://www.google.com/maps/?q={{ $data['order']->address ? $data['order']->address->latitude : '' }},{{ $data['order']->address ? $data['order']->address->longitude : '' }}" target="_blank"> {{ $data['order']->address->area ? $data['order']->address->area->title_en . ", " . __('messages.st') . " " . $data['order']->address->street . ", " . __('messages.piece') . " " . $data['order']->address->piece . ", " . __('messages.gaddah') . " " . $data['order']->address->gaddah : '' }} <br/> {{ __('messages.home') . " " . $data['order']->address->building . ', ' . __('messages.floor') . " "  . $data['order']->address->floor . ', ' . __('messages.apartment') . " " . $data['order']->address->apartment_number }}</a><br>
                                <br><br>
                                <h6>{{ __('messages.additional_details') }}</h6>
                                {{ $data['order']->address->extra_details }}
                            </td>
                            
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 40px;">
                                <h4 style="margin-bottom: 50px;"></h4><br>
                                {{ $data['order']->user->phone }}<br>
                                {{ $data['order']->user->email }}
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    S.No
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.items') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.company') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.quantity') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.status') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.price_before_discount') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.price_after_discount') }}
                </td>
                @if ($data['order']->oItems[0]->shipping != 3)
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.installation_cost') }}
                </td>
                @endif
                @if ($data['order']->oItems[0]->shipping == 3)
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.shipping_cost') }}
                </td>
                @endif
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.total') }}
                </td>
                
            </tr>
            @foreach ($data['order']->oItems as $item)
            @if($item->company_id == Auth::user()->id)
            <tr class="item">
                <td style="padding: 5px;vertical-align: top;text-align:center;border-bottom: 1px solid #eee;">
                    {{ $item->product->id }}
                </td>
                
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    {{ $item->product->title_ar }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:center;border-bottom: 1px solid #eee;">
                    {{ $item->company->title_ar }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    {{ $item->count }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    @if($item->status == 1)
                    {{ __('messages.in_progress') }}
                    @elseif ($item->status == 2)
                    {{ __('messages.delivery_stage') }}
                    @elseif ($item->status == 3)
                    {{ __('messages.installation') }}
                    @elseif ($item->status == 4)
                    {{ __('messages.order_delivered') }}
                    @elseif ($item->status == 5)
                    {{ __('messages.canceled_from_user') }}
                    @else
                    {{ __('messages.canceled_from_admin') }}
                    @endif
                </td>
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    {{ $item->price_before_offer == 0 ? $item->final_price : $item->price_before_offer }} {{ __('messages.dinar') }}
                </td>
                
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    {{ $item->final_price }} {{ __('messages.dinar') }}
                </td>
                @if ($item->shipping != 3)
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    {{ $item->installation_cost }} {{ __('messages.dinar') }}
                </td>
                @endif
                @if ($item->shipping == 3)
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    {{ $item->shipping_cost }} {{ __('messages.dinar') }}
                </td>
                @endif
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    {{ $item->final_price * $item->count }} {{ __('messages.dinar') }}
                </td>
            </tr>
            @endif
            @endforeach
            
            <tr class="item">
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 1px solid #eee;">
                    <h5>{{ __('messages.payment_method') }}</h5>
                </td>
                
                <td style="padding: 5px;vertical-align: top;text-align: left;border-bottom: 1px solid #eee;">
                    <p class=" inv-subtitle">
                    @if($data['order']->payment_method == 1)
                    {{ __('messages.cash') }}
                    @elseif ($data['order']->payment_method == 2)
                    {{ __('messages.key_net') }}
                    @endif
                    </p>
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    <h5>{{ __('messages.sub_total') }}</h5>
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    
                </td>
                
                
                <td style="padding: 5px;vertical-align: top;text-align: right;border-bottom: 0px solid #eee;">
                    <p class="">{{ $data['order']->oItemsCompany(Auth::user()->id)->sum('final_with_delivery') . " " . __('messages.dinar') }} </p>
                </td>
            </tr>
            @php
                $dcost = "0.000";
                if ($data['order']->address->goveronrateArea->deliveryCompany(Auth::user()->id)->delivery_cost) {
                    $dcost = $data['order']->address->goveronrateArea->deliveryCompany(Auth::user()->id)->delivery_cost;
                }
            @endphp
            @if ($data['order']->oItems[0]->shipping == 3)
            <tr class="item">
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    
                </td>
                
                <td style="padding: 5px;vertical-align: top;text-align: left;border-bottom: 0px solid #eee;">
                    
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    
                </td>
                
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    <h5>{{ __('messages.shipping_cost') }}</h5>
                </td>
                
                
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    
                </td>
                
                
                <td style="padding: 5px;vertical-align: top;text-align: right;border-bottom: 0px solid #eee;">
                    <p class="">{{ $data['order']->oItemsCompany(Auth::user()->id)->sum('shipping_cost') }} {{ __('messages.dinar') }}</p>
                </td>
                
            </tr>
            @endif
            @if ($data['order']->oItems[0]->shipping != 3)
            <tr class="item">
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    
                </td>
                
                <td style="padding: 5px;vertical-align: top;text-align: left;border-bottom: 0px solid #eee;">
                    
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    <h5>{{ __('messages.delivery_cost') }}</h5>
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    
                </td>
                
                
                <td style="padding: 5px;vertical-align: top;text-align: right;border-bottom: 0px solid #eee;">
                    <p class="">{{ $dcost }} {{ __('messages.dinar') }}</p>
                </td>
            </tr>
            @endif
            @if ($data['order']->oItems[0]->shipping != 3)
            <tr class="item">
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    
                </td>
                
                <td style="padding: 5px;vertical-align: top;text-align: left;border-bottom: 0px solid #eee;">
                    
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    <h5>{{ __('messages.installation_cost') }}</h5>
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:right;border-bottom: 0px solid #eee;">
                    
                </td>
                
                
                <td style="padding: 5px;vertical-align: top;text-align: right;border-bottom: 0px solid #eee;">
                    <p class="">{{ $data['order']->oItemsCompany(Auth::user()->id)->sum('installation_cost') }} {{ __('messages.dinar') }}</p>
                </td>
            </tr>
            @endif
            <tr class="total">
                <td style="padding: 5px;vertical-align: top;text-align:right;"></td>
                <td style="padding: 5px;vertical-align: top;text-align:right;"></td>
                <td style="padding: 5px;vertical-align: top;text-align:right;"></td>
                <td style="padding: 5px;vertical-align: top;text-align: right;border-top: 2px solid #eee;font-weight: bold;">
                    {{ __('messages.invoice_total') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:right;border-top: 2px solid #eee;"></td>
                <td style="padding: 5px;vertical-align: top;text-align:right;border-top: 2px solid #eee;"></td>
                <td style="padding: 5px;vertical-align: top;text-align: right;border-top: 2px solid #eee;font-weight: bold;">
                    {{ $data['order']->oItemsCompany(Auth::user()->id)->sum('final_with_delivery') + $dcost + $data['order']->oItemsCompany(Auth::user()->id)->sum('shipping_cost') }} {{ __('messages.dinar') }}
                </td>
            </tr>
        </table>
    </div>
</body>
</html>



