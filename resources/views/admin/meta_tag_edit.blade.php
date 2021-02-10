@extends('admin.app')

@section('title' , 'Admin Panel Edit Ad')

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.meta_tags') }}</h4>
                 </div>
        </div>
        <form action="" method="post" >
                @csrf
                <div class="form-group mb-4">
                    <label for="home_meta_en">{{ __('messages.english') }}</label>
                    <textarea required name="home_meta_en" class="form-control" id="home_meta_en" rows="5">{{ $data['meta']['home_meta_en'] }}</textarea>
                </div>
                <div class="form-group mb-4">
                    <label for="home_meta_ar">{{ __('messages.arabic') }}</label>
                    <textarea required name="home_meta_ar" class="form-control" id="home_meta_ar" rows="5">{{ $data['meta']['home_meta_ar'] }}</textarea>
                </div>                
                <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
        </form>
    </div>
@endsection