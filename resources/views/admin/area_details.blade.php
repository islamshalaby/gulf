@extends('admin.ecommerce_app')

@section('title' , __('messages.area_details'))

@section('content')
        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.area_details') }}</h4>
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
                                    {{ $data['area']['title_en'] }}
                                </td>
                            </tr>
                            <tr>
                                <td class="label-table" > {{ __('messages.title_ar') }}</td>
                                <td>
                                    {{ $data['area']['title_ar'] }}
                                </td>
                            </tr>
                            <tr>
                                <td class="label-table" > {{ __('messages.delivery_cost') }} </td>
                                <td>
                                    {{ $data['area']['delivery_cost'] . " " . __('messages.dinar') }}
                                </td>
                            </tr>                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>  
    
@endsection