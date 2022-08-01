@extends('admin.app')

@section('title' , __('messages.add_new_governorate'))

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.add_new_governorate') }}</h4>
                 </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" >
            @csrf
              
            <div class="form-group mb-4">
                <label for="title_en">{{ __('messages.title_en') }}</label>
                <input required type="text" name="name_en" class="form-control" id="title_en" placeholder="{{ __('messages.title_en') }}" value="{{ old('name_en') }}" >
            </div>
            <div class="form-group mb-4">
                <label for="title_ar">{{ __('messages.title_ar') }}</label>
                <input required type="text" name="name_ar" class="form-control" id="title_ar" placeholder="{{ __('messages.title_ar') }}" value="{{ old('name_ar') }}" >
            </div>

            <div class="form-group">
                <label for="country">{{ __('messages.country') }}</label>
                <select id="country" name="country_id" class="form-control">
                    <option selected>{{ __('messages.select') }}</option>
                    @foreach ( $data['countries'] as $country )
                    <option {{ old('country_id') == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ App::isLocale('en') ? $country->name_en : $country->name_ar }}</option>
                    @endforeach
                </select>
            </div>
               
            <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
        </form>
    </div>
@endsection