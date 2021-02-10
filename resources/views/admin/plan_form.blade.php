@extends('admin.ad_app')

@section('title' , __('messages.add_new_ad'))



@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.add_new_plan') }}</h4>
                 </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" >
            @csrf      

            <div class="form-group mb-4 outside">
                <label for="ads_count">{{ __('messages.ads_count') }}</label>
                <input required type="number" name="ads_count" class="form-control" id="ads_count" placeholder="{{ __('messages.ads_count') }}" value="" >
            </div>
            <div class="form-group mb-4 outside">
                <label for="price_plan">{{ __('messages.price') }}</label>
                <input required type="number" name="price" class="form-control" id="price_plan" placeholder="{{ __('messages.price_plan') }}" value="" >
            </div>

            <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
        </form>
    </div>
@endsection