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
                                {{ App::isLocale('en') ? $data['product']->category->title_en : $data['product']->category->title_ar }}
                            </td>
                        </tr>
                        @if (!empty($data['product']->sub_category_id))
                        <tr>
                            <td class="label-table" > {{ __('messages.sub_category') }} </td>
                            <td>
                                {{ App::isLocale('en') ? $data['product']->subCategory->title_en : $data['product']->subCategory->title_ar }}
                            </td>
                        </tr>
                        @endif
                        @if (!empty($data['product']->sub_category_two_id))
                        <tr>
                            <td class="label-table" > {{ __('messages.sub_two_category') }} </td>
                            <td>
                                @if(!empty($data['product']->subTwoCategory))
                                {{ App::isLocale('en') ? $data['product']->subTwoCategory->title_en : $data['product']->subTwoCategory->title_ar }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        @if (!empty($data['product']->sub_category_three_id))
                        <tr>
                            <td class="label-table" > {{ __('messages.sub_three_category') }} </td>
                            <td>
                                @if(!empty($data['product']->subThreeCategory))
                                {{ App::isLocale('en') ? $data['product']->subThreeCategory->title_en : $data['product']->subThreeCategory->title_ar }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        @if (!empty($data['product']->sub_category_four_id))
                        <tr>
                            <td class="label-table" > {{ __('messages.sub_four_category') }} </td>
                            <td>
                                @if(!empty($data['product']->subFourCategory))
                                {{ App::isLocale('en') ? $data['product']->subFourCategory->title_en : $data['product']->subFourCategory->title_ar }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        
                        <tr>
                            <td class="label-table" > {{ __('messages.user') }} </td>
                            <td>
                                {{ $data['product']->user->name }}
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
                @if (count($data['product']->options) > 0)
                <h5>{{ __('messages.properties') }}</h5>
                <table class="table table-bordered mb-4">
                    <tbody>
                        @for ($k = 0; $k < count($data['product']->options); $k ++)
                        <tr>
                            <td class="label-table" > {{ App::isLocale('en') ? $data['product']->options[$k]['option_en'] : $data['product']->options[$k]['option_ar'] }}</td>
                            <td>
                                @if(App::isLocale('en'))
                                {{ !empty($data['product']->options[$k]['val_en']) ? $data['product']->options[$k]['val_en'] : $data['product']->options[$k]['value'] }}
                                @else
                                {{ !empty($data['product']->options[$k]['val_ar']) ? $data['product']->options[$k]['val_ar'] : $data['product']->options[$k]['value'] }}
                                @endif
                            </td>
                        </tr>
                        @endfor          
                    </tbody>
                </table>
                @endif
                <label for="">{{ __('messages.main_image') }}</label><br>
                <div class="row">
                    <div class="col-md-2 product_image">
                        <img style="width: 100%" src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1601416550/{{ $data['product']->images[0]->image }}"  />
                    </div>
                </div>
                <label style="margin-top: 20px" for="">{{ __('messages.product_images') }}</label><br>
                <div class="row">
                    @if (count($data['product']->images) > 0)
                        @php
                            $i = 0
                        @endphp
                        @foreach ($data['product']->images as $image)
                        @if ($i != 0)
                        <div style="position : relative" class="col-md-2 product_image">
                            <img width="100%" src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1601416550/{{ $image->image }}"  />
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