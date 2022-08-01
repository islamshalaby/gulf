@extends('admin.ecommerce_app')

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
                            <td class="label-table" > {{ __('messages.title_en') }}</td>
                            <td>
                                {{ $data['product']['title_en'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.title_ar') }}</td>
                            <td>
                                {{ $data['product']['title_ar'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.category') }} </td>
                            <td>
                                <a target="_blank" href="{{ route('categories.details', $data['product']['category']['id']) }}">
                                    {{ App::isLocale('en') ? $data['product']['category']['title_en'] : $data['product']['category']['title_ar'] }}
                                </a>
                            </td>
                        </tr>
                        @if (!empty($data['product']['sub_one_car_type_id']) && $data['product']['sub_one_car_type_id'] != 0)
                        <tr>
                            <td class="label-table" > {{ __('messages.sub_category') }} </td>
                            <td>
                                <a target="_blank" href="{{ route('sub_one_car_types.details', $data['product']['sub_one_car_type_id']) }}">
                                    {{ App::isLocale('en') ? $data['product']['subOneCar']['title_en'] : $data['product']['subOneCar']['title_ar'] }}
                                </a>
                            </td>
                        </tr>
                        @endif
                        
                        @if (!empty($data['product']['sub_two_car_type_id']) && $data['product']['sub_two_car_type_id'] != 0)
                        <tr>
                            <td class="label-table" > {{ __('messages.sub_two_car_types') }} </td>
                            <td>
                                <a target="_blank" href="{{ route('sub_two_car_types.details', $data['product']['sub_two_car_type_id']) }}">
                                    {{ App::isLocale('en') ? $data['product']->subTwoCar->title_en : $data['product']->subTwoCar->title_ar }}
                                </a>
                            </td>
                        </tr>
                        @endif
                        
                        @if (!empty($data['product']['category_id']) && $data['product']['category_id'] != 0)
                        <tr>
                            <td class="label-table" > {{ __('messages.section') }} </td>
                            <td>
                                <a target="_blank" href="{{ route('categories.details', $data['product']['category_id']) }}">
                                    {{ App::isLocale('en') ? $data['product']->section->title_en : $data['product']->section->title_ar }}
                                </a>
                            </td>
                        </tr>
                        @endif
                        
                        @if (!empty($data['product']['sub_category_id']) && $data['product']['sub_category_id'] != 0)
                        <tr>
                            <td class="label-table" > {{ __('messages.sub_section') }} </td>
                            <td>
                                <a target="_blank" href="{{ route('sub_categories.details', $data['product']['sub_category_id']) }}">
                                    {{ App::isLocale('en') ? $data['product']->subCategory->title_en : $data['product']->subCategory->title_ar }}
                                </a>
                            </td>
                        </tr>
                        @endif
                        

                        <tr>
                            <td class="label-table" > {{ __('messages.company') }} </td>
                            <td>
                                <a target="_blank" href="{{ route('companies.details', $data['product']['company']['id']) }}">
                                    {{ App::isLocale('en') ? $data['product']->company->title_en : $data['product']->company->title_ar }}
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="label-table" > {{ __('messages.year') }} </td>
                            <td>
                                {{ $data['product']['year'] }}
                            </td>
                        </tr>

                        <tr>
                            <td class="label-table" > {{ __('messages.status') }} </td>
                            <td>
                                {{ $data['product']['type'] == 1 ? __('messages.new') : __('messages.used') }}
                            </td>
                        </tr>
                        
            
                        <tr>
                            <td class="label-table" > {{ __('messages.description_en') }} </td>
                            <td>
                                {{ $data['product']['description_en'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.total_quatity') }} </td>
                            <td>
                                {{ $data['product']['total_quatity'] }}
                            </td>
                        </tr>
                         <tr>
                            <td class="label-table" > {{ __('messages.remaining_quantity') }} </td>
                            <td>
                                {{ $data['product']['remaining_quantity'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.sold_quantity') }} </td>
                            <td>
                                {{ $data['product']['sold_count'] }}
                            </td>
                        </tr>
               
                        <tr>
                            <td class="label-table" > {{ __('messages.product_price') }} </td>
                            <td>
                                {{ $data['product']['final_price'] }} {{ __('messages.dinar') }}
                            </td>
                        </tr>  
                        @if ($data['product']['offer'] == 1)
                        <tr>
                            <td class="label-table" > {{ __('messages.price_before_discount') }} </td>
                            <td>
                                {{ $data['product']['price_before_offer'] }} {{ __('messages.dinar') }}
                            </td>
                        </tr> 
                        @endif
                            
                        <tr>
                            <td class="label-table" > {{ __('messages.last-update_date') }} </td>
                            <td>
                                {{ $data['product']['updated_at']->format('Y-m-d') }}
                            </td>
                        </tr>             
                    </tbody>
                </table>
                @if (isset($data['options']) && count($data['options']) > 0)
                <h5>{{ __('messages.options2') }}</h5>
                <table class="table table-bordered mb-4">
                    <tbody>
                        @foreach ($data['options'] as $option)
                        <tr>
                            <td class="label-table" > {{ App::isLocale('en') ? $option['option_title_en'] : $option['option_title_ar'] }}</td>
                            <td>
                                {{ App::isLocale('en') ? $option['value_en'] : $option['value_ar'] }}
                            </td>
                        </tr>
                        @endforeach           
                    </tbody>
                </table>
                @endif

                <div class="row">
                    @if (count($data['product']['images']) > 0)
                        @foreach ($data['product']['images'] as $image)
                        <div style="position : relative" class="col-md-2 product_image">
                            <img width="100%" src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1601416550/{{ $image->image }}"  />
                        </div>
                        @endforeach
                    @endif
                </div>
                <div style="text-align:center" >
                    <br>
                    <a href="#" data-toggle="modal" data-target="#zoomupModal{{ $data['product']['id'] }}" class="btn btn-{{ $data['product']['remaining_quantity'] == 0 ? 'danger' : 'primary'}}">{{ __('messages.add_quantity') }}</a>
                </div>

                <div id="zoomupModal{{ $data['product']['id'] }}" class="modal animated zoomInUp custo-zoomInUp" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ App::isLocale('en') ? $data['product']['title_en'] : $data['product']['title_ar']}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('update.quantity', $data['product']['id']) }}" method="post" enctype="multipart/form-data" >
                                    @csrf    
                                    <div class="form-group mb-4">
                                        <label for="remaining_quantity">{{ __('messages.quantity') }}</label>
                                        <input required type="text" name="remaining_quantity" class="form-control" id="remaining_quantity" placeholder="{{ __('messages.quantity') }}" value="" >
                                    </div>
                        
                                    <input type="submit" value="{{ __('messages.add') }}" class="btn btn-primary">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>  
    
@endsection