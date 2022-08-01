<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ __('messages.installation_report') }}</title>
    
</head>
<body dir="rtl">
    <div class="invoice-box" style="max-width: 800px;margin: auto;padding: 30px;border: 1px solid #eee;box-shadow: 0 0 10px rgba(0, 0, 0, .15);font-size: 16px;line-height: 24px;font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;color: #555;">
        <table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
            <tr class="top">
                <td colspan="9" style="padding: 5px;vertical-align: top;">
                    <table style="width: 100%;line-height: inherit;text-align: right;">
                        <tr>
                            <td class="title" style="padding: 5px;vertical-align: top;padding-bottom: 20px;font-size: 45px;text-align: center;line-height: 20px;color: #333;">
                                <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/h_300,w_300/v1581928924/{{ $data['setting']['logo'] }}" style="width:100px; max-width:300px;">
                            </td>
                            
                            
                            <td colspan="4" style="padding: 5px;vertical-align: top;text-align: center;padding-bottom: 20px;">
                                <h2 style="margin-bottom: 50px; font-size:35px">{{ __('messages.installation_report') }}</h2><br>
                                <span style="text-align: center;margin-left:70px;display:block">{{ $data['today'] }}</span><br/>
                                <b style="text-align: center;margin-left:70px;display:block">
                                    @if (isset($data['area']))
                                    {{ $data['area']['name_ar'] }}
                                    @endif
                                    @if(isset($data['from']) && isset($data['to']))
                                     - 
                                    {{ '( ' . $data['from'] . " | " . $data['to'] . ' )' }}
                                    @endif
                                    @if(isset($data['method']))
                                     - 
                                        @if($data['method'] == 1)
                                        {{ __('messages.cash') }}
                                        @else
                                        {{ __('messages.key_net') }}
                                        @endif
                                    @endif
                                    @if(isset($data['order_status2']))
                                     - 
                                        @if ($data['order_status2'] == 1)
                                        {{ __('messages.in_progress') }}
                                        @elseif($data['order_status2'] == 2)
                                        {{ __('messages.delivery_stage') }}
                                        @elseif($data['order_status2'] == 3)
                                        {{ __('messages.installation') }}
                                        @elseif($data['order_status2'] == 4)
                                        {{ __('messages.order_delivered') }}
                                        @elseif($data['order_status2'] == 5)
                                        {{ __('messages.canceled_from_user') }}
                                        @elseif($data['order_status2'] == 6)
                                        {{ __('messages.canceled_from_admin') }}
                                        @endif
                                    @endif
                                    @if(isset($data['company']))
                                     - 
                                    {{ $data['company_name']['title_ar'] }}
                                    @endif
                                    @if(isset($data['delivery']))
                                     - 
                                    {{ $data['delivery_method']['title_ar'] }}
                                    @endif
                                </b>
                            </td>
                            
                        </tr>
                        <tr>
                            <td class="title" style="padding: 5px;vertical-align: top;padding-bottom: 20px;font-size: 20px;line-height: 20px;text-align: center;color: #333;">
                                {{ $data['setting']['app_name_ar'] }}
                            </td>
                            <td colspan="11" style="padding: 5px;vertical-align: top;text-align: center;padding-bottom: 20px;">
                                
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="7" style="padding: 5px;vertical-align: top;">
                    <table style="width: 100%;line-height: inherit;text-align: right;">
                        <tr>
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 40px;">
                            </td>
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 40px;">
                            </td>
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 40px;">
                            </td>
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 40px;">
                            </td>
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 40px;">
                            </td>
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 40px;">
                            </td>
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 40px;">
                            </td>
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 40px;">
                            </td>
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 40px;">
                            </td>
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 40px;">
                            </td>
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 40px;">
                            </td>
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 40px;">
                            </td>
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 40px;">
                            </td>
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 40px;">
                            </td>
                            <td style="padding: 5px;vertical-align: top;padding-bottom: 40px;">
                                <br>
                            </td>
                            
                            <td style="padding: 5px;vertical-align: top;text-align: left;padding-bottom: 40px;">
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    ID
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.order_number') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.product_title') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.image') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.amount') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.product_price') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.installation_cost') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.total') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.order_date') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align: center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.user') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align:center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.payment_method') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align: center;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.status') }}
                </td>
            </tr>
            @if ($data['orders'])
            <?php $i = 1; ?>
            @foreach ($data['orders'] as $order)
            <tr class="item">
                <td style="padding: 5px;vertical-align: top;text-align:center;border-bottom: 1px solid #eee;">
                    <?=$i;?>
                </td>
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    {{ $order->order ? $order->order->order_number : '' }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    {{ $order->product->title_ar }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_50/v1581928924/{{ isset($order->product->images[0]->image) ? $order->product->images[0]->image : '' }}"  />
                </td>
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    {{ $order->count }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    {{ $order->final_price . " " . __('messages.dinar') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    {{ $order->installation_cost . " " . __('messages.dinar') }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    {{ ($order->final_price * $order->count) + ($order->installation_cost * $order->count) }} {{ __('messages.dinar') }}
                </td>
                
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    {{ $order->created_at->format("d-m-y") }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    {{ $order->order->user->name }}
                </td>
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    @if($order->order->payment_method == 1)
                    {{ __('messages.cash') }}
                    @else
                    {{ __('messages.key_net') }}
                    @endif
                </td>
                <td style="padding: 5px;vertical-align: top;text-align: center;border-bottom: 1px solid #eee;">
                    @if ($order->status == 5)
                    {{ __('messages.canceled_from_user') }}
                    @elseif ($order->status == 6)
                    {{ __('messages.canceled_from_admin') }}
                    @elseif ($order->status == 1)
                    {{ __('messages.in_progress') }}
                    @elseif($order->status == 3)
                    {{ __('messages.installed') }}
                    @elseif($order->status == 4)
                    {{ __('messages.order_delivered') }}
                    @endif
                </td>
            </tr>
            <?php $i ++; ?>
            @endforeach
            @endif
            
            <tr class="heading">
                <td style="padding: 5px;text-align:center;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ __('messages.total') }}
                </td>
                <td style="padding: 5px;text-align:center;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    
                </td>
                <td style="padding: 5px;text-align:center;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    
                </td>
                <td style="padding: 5px;text-align:center;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    
                </td>
                <td style="padding: 5px;text-align:center;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    
                </td>
                <td style="padding: 5px;text-align:center;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ $data['sum_final_price'] . " " . __('messages.dinar') }}
                </td>
                <td style="padding: 5px;text-align:center;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ $data['sum_installation'] . " " . __('messages.dinar') }}
                </td>
                <td style="padding: 5px;text-align:center;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    {{ $data['sum_total'] . " " . __('messages.dinar') }}
                </td>
                <td style="padding: 5px;text-align:center;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    
                </td>
                <td style="padding: 5px;text-align:center;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    
                </td>
                <td style="padding: 5px;text-align:center;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    
                </td>
                <td style="padding: 5px;text-align:center;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;">
                    
                </td>
            </tr>
            
        </table>
    </div>
</body>
</html>



