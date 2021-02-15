@extends('admin.ad_app')

@section('title' , __('messages.offers_control_details'))

@section('content')
        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.offers_control_details') }}</h4>
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
                                {{ $data['section']['title_en'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.title_ar') }}</td>
                            <td>
                                {{ $data['section']['title_ar'] }}
                            </td>
                        </tr> 
                        <tr>
                            <td class="label-table" > {{ __('messages.image') }}</td>
                            <td>
                                <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1581928924/{{ $data['section']['icon'] }}"  />
                            </td>
                        </tr>   
                                               
                    </tbody>
                </table>
                
                @if(count($data['section']->adOffers) > 0)
                <table class="table table-bordered mb-4">
                    <tbody>
                        @foreach ($data['section']->adOffers as $offer)
                        <tr>
                            <td>{{ __('messages.product') }}</td>
                            <td>
                               <a target="_blank" href="/admin-panel/ad_products/details/{{ $offer->id }}">{{ $offer->title }}</a>
                            </td>
                        </tr>
                        @endforeach          
                    </tbody>
                </table> 
                @endif    
            </div>
        </div>
    </div>  
    
@endsection