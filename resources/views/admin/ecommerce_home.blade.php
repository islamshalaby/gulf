@extends('admin.ecommerce_app')

@section('title' , 'Admin Panel Home')

@section('content')
<div class="row" >
    <div class="col-md-6 layout-spacing">
        <a href="{{ route('home.ad.index') }}" class="btn btn-dark">{{ __('messages.ad_dashboard') }}</a>
    </div>  
    <div class="col-md-6 layout-spacing">
        <a href="{{ route('home.ecommerce.index') }}" class="btn btn-dark">{{ __('messages.ecommerce_dashboard') }}</a>
    </div>
</div>

                       
@endsection

