@extends('admin.ecommerce_app')

@section('title' , __('messages.car_type_details'))

@section('content')
        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.car_type_details') }}</h4>
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
                                <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1601416550/{{ $data['car_type']['image'] }}"  />
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.title_en') }}</td>
                            <td>
                                {{ $data['car_type']['title_en'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.title_ar') }}</td>
                            <td>
                                {{ $data['car_type']['title_ar'] }}
                            </td>
                        </tr>                          
                    </tbody>
                </table>
            </div>
        </div>
    </div>  
    
@endsection