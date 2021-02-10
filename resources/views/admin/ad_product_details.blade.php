@extends('admin.ad_app')

@section('title' , __('messages.product_details'))

@section('content')
        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.product_details') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table class="table table-bordered mb-4">
                    <tbody>
                        <tr>
                            <td class="label-table" > {{ __('messages.publication_date') }}</td>
                            <td>
                                {{ date('Y-m-d', strtotime($data['product']['publication_date'])) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.product_name') }}</td>
                            <td>
                                {{ $data['product']['title'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.category') }} </td>
                            <td>
                                {{ $data['product']['category_name'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.sub_category') }} </td>
                            <td>
                                {{ $data['product']['sub_category_name'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.sub_two_category') }} </td>
                            <td>
                                {{ $data['product']['sub_two_category_name'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.sub_three_category') }} </td>
                            <td>
                                {{ $data['product']['sub_three_category_name'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.user') }} </td>
                            <td>
                                {{ $data['product']['user_name'] }}
                            </td>
                        </tr>   
                        <tr>
                            <td class="label-table" > {{ __('messages.description') }} </td>
                            <td>
                                {{ $data['product']['description'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.product_price') }} </td>
                            <td>
                                {{ $data['product']['price'] }} {{ __('messages.dinar') }}
                            </td>
                        </tr>  
                  
                    </tbody>
                </table>
                <label for="">{{ __('messages.main_image') }}</label><br>
                <div class="row">
                    <div class="col-md-2 product_image">
                        <img style="width: 100%" src="https://res.cloudinary.com/dy4xq0cvc/image/upload/w_100,q_100/v1601416550/{{ $data['product']->images[0] }}"  />
                    </div>
                </div>
                <label style="margin-top: 20px" for="">{{ __('messages.product_images') }}</label><br>
                <div class="row">
                    @if (count($data['product']['images']) > 0)
                        @php
                            $i = 0
                        @endphp
                        @foreach ($data['product']['images'] as $image)
                        @if ($i != 0)
                        <div style="position : relative" class="col-md-2 product_image">
                            <img width="100%" src="https://res.cloudinary.com/dy4xq0cvc/image/upload/w_100,q_100/v1601416550/{{ $image }}"  />
                        </div>
                        @endif
                        
                        @php
                            $i ++
                        @endphp
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>  
    
@endsection