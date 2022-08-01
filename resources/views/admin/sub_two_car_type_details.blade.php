@extends('admin.ecommerce_app')

@section('title' , __('messages.new_sub_one_car_type_details'))

@section('content')
        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.new_sub_one_car_type_details') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table class="table table-bordered mb-4">
                    <tbody>
                        <tr>
                            <td class="label-table" > {{ __('messages.image') }}</td>
                            <td>
                                <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1601416550/{{ $data['sub_two_car_type']['image'] }}"  />
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.title_en') }}</td>
                            <td>
                                {{ $data['sub_two_car_type']['title_en'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.title_ar') }}</td>
                            <td>
                                {{ $data['sub_two_car_type']['title_ar'] }}
                            </td>
                        </tr>   
                        <tr>
                            <td class="label-table" > {{ __('messages.category') }}</td>
                            <td>
                                <a href="{{ route('sub_one_car_types.details', $data['sub_two_car_type']['sub_one_car_type_id']) }}">
                                {{ App::isLocale('en') ? $data['sub_two_car_type']->carType->title_en : $data['sub_two_car_type']->carType->title_ar }}
                                </a>
                            </td>
                        </tr>
                                               
                    </tbody>
                </table>
            </div>
        </div>
    </div>  
    
@endsection