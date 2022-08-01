@extends('admin.app')

@section('title' , 'Admin Panel AboutApp')

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.setting') }}</h4>
             </div>
    </div>
    @if(Session::has('success'))
        <div class="alert alert-icon-left alert-light-success mb-4" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12" y2="17"></line></svg>
            <strong>{{ Session('success') }}</strong>
        </div>
    @endif
    <form method="post" action="" enctype="multipart/form-data" >
        @csrf
         <div class="form-group mb-4">
            <label>{{ __('messages.current_logo') }}</label>
            <br>
            <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1601416550/{{$data['setting']['logo']}}" >    
        </div>

         <div class="form-group mb-4">
            <label for="logo">{{ __('messages.logo') }}</label>
            <input  type="file" name="logo" class="form-control" id="logo" placeholder="{{ __('messages.logo') }}" value="" >
        </div>

        <div class="form-group mb-4">
            <label>{{ __('messages.individual_logo') }}</label>
            <br>
            <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1601416550/{{$data['setting']['individual_logo']}}" >    
        </div>

         <div class="form-group mb-4">
            <label for="individual_logo">{{ __('messages.individual_logo') }}</label>
            <input  type="file" name="individual_logo" class="form-control" id="individual_logo" placeholder="{{ __('messages.logo') }}" value="" >
        </div>

        <div class="form-group mb-4">
            <label>{{ __('messages.companies_logo') }}</label>
            <br>
            <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1601416550/{{$data['setting']['companies_logo']}}" >    
        </div>

         <div class="form-group mb-4">
            <label for="companies_logo">{{ __('messages.companies_logo') }}</label>
            <input  type="file" name="companies_logo" class="form-control" id="companies_logo" placeholder="{{ __('messages.logo') }}" value="" >
        </div>

        <div class="form-group mb-4">
            <label>{{ __('messages.vehicle_ads_banner') }}</label>
            <br>
            <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1601416550/{{$data['setting']['vehicle_banner']}}" >    
        </div>

         <div class="form-group mb-4">
            <label for="vehicle_banner">{{ __('messages.vehicle_ads_banner') }}</label>
            <input  type="file" name="vehicle_banner" class="form-control" id="vehicle_banner" placeholder="{{ __('messages.logo') }}" value="" >
        </div>

        <div class="form-group mb-4">
            <label>{{ __('messages.stores_banner') }}</label>
            <br>
            <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1601416550/{{$data['setting']['store_image']}}" >    
        </div>

         <div class="form-group mb-4">
            <label for="store_banner">{{ __('messages.stores_banner') }}</label>
            <input  type="file" name="store_image" class="form-control" id="store_banner" placeholder="{{ __('messages.logo') }}" value="" >
        </div>

         <div class="form-group mb-4">
            <label for="app_name_en">{{ __('messages.app_name_en') }}</label>
            <input required type="text" name="app_name_en" class="form-control" id="app_name_en" placeholder="{{ __('messages.app_name_en') }}" value="{{$data['setting']['app_name_en']}}" >
        </div>
         <div class="form-group mb-4">
            <label for="app_name_ar">{{ __('messages.app_name_ar') }}</label>
            <input required type="text" name="app_name_ar" class="form-control" id="app_name_ar" placeholder="{{ __('messages.app_name_ar') }}" value="{{$data['setting']['app_name_ar']}}" >
        </div>
         <div class="form-group mb-4">
            <label for="email">{{ __('messages.email') }}</label>
            <input required type="email" name="email" class="form-control" id="email" placeholder="{{ __('messages.email') }}" value="{{$data['setting']['email']}}" >
        </div>
        <div class="form-group mb-4">
            <label for="phone">{{ __('messages.phone') }}</label>
            <input required type="phone" name="phone" class="form-control" id="phone" placeholder="{{ __('messages.phone') }}" value="{{$data['setting']['phone']}}" >
        </div>
        <div class="form-group mb-4">
            <label for="app_phone">{{ __('messages.support_phone') }}</label>
            <input required type="phone" name="app_phone" class="form-control" id="app_phone" placeholder="{{ __('messages.support_phone') }}" value="{{$data['setting']['app_phone']}}" >
        </div>
        <div class="form-group mb-4">
            <label for="address_en">{{ __('messages.address_en') }}</label>
            <input  type="text" name="address_en" class="form-control" id="address_en" placeholder="{{ __('messages.address_en') }}" value="{{$data['setting']['address_en']}}" >
        </div>
        <div class="form-group mb-4">
            <label for="address_ar">{{ __('messages.address_ar') }}</label>
            <input  type="text" name="address_ar" class="form-control" id="address_ar" placeholder="{{ __('messages.address_ar') }}" value="{{$data['setting']['address_ar']}}" >
        </div>
        <div class="form-group mb-4">
            <label for="facebook">{{ __('messages.facebook') }}</label>
            <input  type="text" name="facebook" class="form-control" id="facebook" placeholder="{{ __('messages.facebook') }}" value="{{$data['setting']['facebook']}}" >
        </div>
        <div class="form-group mb-4">
            <label for="youtube">{{ __('messages.youtube') }}</label>
            <input  type="text" name="youtube" class="form-control" id="youtube" placeholder="{{ __('messages.youtube') }}" value="{{$data['setting']['youtube']}}" >
        </div>
        <div class="form-group mb-4">
            <label for="twitter">{{ __('messages.twitter') }}</label>
            <input  type="text" name="twitter" class="form-control" id="twitter" placeholder="{{ __('messages.twitter') }}" value="{{$data['setting']['twitter']}}" >
        </div>
        <div class="form-group mb-4">
            <label for="instegram">{{ __('messages.instegram') }}</label>
            <input  type="text" name="instegram" class="form-control" id="instegram" placeholder="{{ __('messages.instegram') }}" value="{{$data['setting']['instegram']}}" >
        </div>
        <div class="form-group mb-4">
            <label for="snap_chat">{{ __('messages.snap_chat') }}</label>
            <input  type="text" name="snap_chat" class="form-control" id="snap_chat" placeholder="{{ __('messages.snap_chat') }}" value="{{$data['setting']['snap_chat']}}" >
        </div>
        <div class="form-group mb-4">
            <label for="ad_period">{{ __('messages.normal_ad_period') }}</label>
            <input  type="number" name="ad_period" class="form-control" id="ad_period" placeholder="{{ __('messages.normal_ad_period') }}" value="{{$data['setting']['ad_period']}}" >
        </div>
        <div class="form-group mb-4">
            <label for="feature_ad_period">{{ __('messages.feature_ad_period') }}</label>
            <input  type="number" name="feature_ad_period" class="form-control" id="feature_ad_period" placeholder="{{ __('messages.feature_ad_period') }}" value="{{$data['setting']['feature_ad_period']}}" >
        </div>
        <div class="form-group mb-4">
            <label for="feature_ad_period">{{ __('messages.pin_ad_period') }}</label>
            <input  type="number" name="pin_ad_period" class="form-control" id="pin_ad_period" placeholder="{{ __('messages.pin_ad_period') }}" value="{{$data['setting']['pin_ad_period']}}" >
        </div>
        
        <div class="form-group mb-4">
            <label for="free_ads_count">{{ __('messages.free_ads_count') }}</label>
            <input  type="number" name="free_ads_count" class="form-control" id="free_ads_count" placeholder="{{ __('messages.free_ads_count') }}" value="{{$data['setting']['free_ads_count']}}" >
        </div>
        <div class="form-group mb-4">
            <label for="free_ads_count">{{ __('messages.free_ads_count') }}</label>
            <input  type="number" name="free_ads_count" class="form-control" id="free_ads_count" placeholder="{{ __('messages.free_ads_count') }}" value="{{$data['setting']['free_ads_count']}}" >
        </div>
        <div class="form-group mb-4">
            <label for="vehicle_title_en">{{ __('messages.ads_service_title_en') }}</label>
            <input  type="text" name="vehicle_title_en" class="form-control" placeholder="{{ __('messages.ads_service_title_en') }}" value="{{$data['services'][0]['title_en']}}" >
        </div>
        <div class="form-group mb-4">
            <label for="vehicle_title_ar">{{ __('messages.ads_service_title_ar') }}</label>
            <input  type="text" name="vehicle_title_ar" class="form-control" placeholder="{{ __('messages.ads_service_title_ar') }}" value="{{$data['services'][0]['title_ar']}}" >
        </div>
        <div class="form-group mb-4 english-direction" >
            <label for="vehicle_description_en">{{ __('messages.ads_service_description_en') }} *</label>
            <textarea required name="vehicle_description_en" class="form-control"  rows="3">{{$data['services'][0]['description_en']}}</textarea>
        </div>
        <div class="form-group mb-4 english-direction" >
            <label for="vehicle_description_ar">{{ __('messages.ads_service_description_ar') }} *</label>
            <textarea required name="vehicle_description_ar" class="form-control"  rows="3">{{$data['services'][0]['description_ar']}}</textarea>
        </div>
        <div class="form-group mb-4">
            <label for="store_title_en">{{ __('messages.store_service_title_en') }}</label>
            <input  type="text" name="store_title_en" class="form-control" placeholder="{{ __('messages.store_service_title_en') }}" value="{{$data['services'][1]['title_en']}}" >
        </div>
        <div class="form-group mb-4">
            <label for="vehicle_title_ar">{{ __('messages.store_service_title_ar') }}</label>
            <input  type="text" name="store_title_ar" class="form-control" placeholder="{{ __('messages.store_service_title_ar') }}" value="{{$data['services'][1]['title_ar']}}" >
        </div>
        <div class="form-group mb-4 english-direction" >
            <label for="store_description_en">{{ __('messages.store_service_description_en') }} *</label>
            <textarea required name="store_description_en" class="form-control"  rows="3">{{$data['services'][1]['description_en']}}</textarea>
        </div>
        <div class="form-group mb-4 english-direction" >
            <label for="store_description_ar">{{ __('messages.store_service_description_ar') }} *</label>
            <textarea required name="store_description_ar" class="form-control"  rows="3">{{$data['services'][1]['description_ar']}}</textarea>
        </div>
        <div class="form-group mb-4">
            <input  type="hidden" name="latitude" class="form-control"  value="{{$data['setting']['latitude']}}" >
        </div>
        <div class="form-group mb-4">
            <input  type="hidden" name="longitude" class="form-control" value="{{$data['setting']['longitude']}}" >
        </div>   
        <div class="form-group mb-4">
            <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-text checkbox-primary">
                  <input  type="checkbox" {{ $data['setting']['hide_payment'] == 1 ? 'checked' : '' }} name="hide_payment" class="new-control-input all-permisssions">
                  <span class="new-control-indicator"></span><span class="new-chk-content">{{ __('messages.hide_payment') }}</span>
                </label>
            </div>  
        </div>
        
        <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
        
    </form>
</div>
@endsection