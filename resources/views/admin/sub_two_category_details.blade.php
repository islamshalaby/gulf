@extends('admin.ad_app')

@section('title' , __('messages.sub_category_details'))

@section('content')
        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.sub_category_details') }}</h4>
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
                                <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1601416550/{{ $data['sub_category']['image'] }}"  />
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.title_en') }}</td>
                            <td>
                                {{ $data['sub_category']['title_en'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.title_ar') }}</td>
                            <td>
                                {{ $data['sub_category']['title_ar'] }}
                            </td>
                        </tr>   
                        <tr>
                            <td class="label-table" > {{ __('messages.category') }}</td>
                            <td>
                                <a href="{{ route('sub_categories.details', $data['sub_category']['category']['id']) }}">
                                {{ App::isLocale('en') ? $data['sub_category']['category']['title_en'] : $data['sub_category']['category']['title_ar'] }}
                                </a>
                            </td>
                        </tr>
                                               
                    </tbody>
                </table>
            </div>
        </div>
    </div>  
    
@endsection