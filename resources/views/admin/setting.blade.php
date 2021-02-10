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
            <label for="map_url">{{ __('messages.map_url') }}</label>
            <input  type="text" name="map_url" class="form-control" id="map_url" placeholder="{{ __('messages.map_url') }}" value="{{$data['setting']['map_url']}}" >
        </div>
        <div class="form-group mb-4">
            <input  type="hidden" name="latitude" class="form-control"  value="{{$data['setting']['latitude']}}" >
        </div>
        <div class="form-group mb-4">
            <input  type="hidden" name="longitude" class="form-control" value="{{$data['setting']['longitude']}}" >
        </div>        
            <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
        
    </form>
</div>
@endsection