@extends('admin.ecommerce_app')

@section('title' , __('messages.add_new_sub_category'))

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.add_new_sub_category') }}</h4>
                 </div>
        </div>
        <form action="{{ Request::segment(2) == 'sub_categories' ? route('sub_categories.create') : route('sub_categories.ads.create') }}" method="post" enctype="multipart/form-data" >
            @csrf
            <div class="custom-file-container" data-upload-id="myFirstImage">
                <label>{{ __('messages.upload') }} ({{ __('messages.single_image') }}) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                <label class="custom-file-container__custom-file" >
                    <input type="file" required name="image" class="custom-file-container__custom-file__custom-file-input" accept="image/*">
                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                    <span class="custom-file-container__custom-file__custom-file-control"></span>
                </label>
                <div class="custom-file-container__image-preview"></div>
            </div>

            <div class="form-group mb-4">
                <label for="title_en">{{ __('messages.title_en') }}</label>
                <input required type="text" name="title_en" class="form-control" id="title_en" placeholder="{{ __('messages.title_en') }}" value="" >
            </div>
            <div class="form-group mb-4">
                <label for="title_ar">{{ __('messages.title_ar') }}</label>
                <input required type="text" name="title_ar" class="form-control" id="title_ar" placeholder="{{ __('messages.title_ar') }}" value="" >
            </div>
            <div class="form-group">
                <label for="category">{{ __('messages.category') }}</label>
                <select id="category" name="sub_car_type_id" class="form-control">
                    <option disabled selected>{{ __('messages.select') }}</option>
                    @foreach ( $data['sub_cars'] as $category )
                    <option value="{{ $category->id }}">{{ App::isLocale('en') ? $category->title_en . " - " . $category->carType->title_en . " - " . $category->carType->carType->title_en . " - " . $category->carType->carType->carType->title_en : $category->title_ar . " - " . $category->carType->title_ar . " - " . $category->carType->carType->title_ar . " - " . $category->carType->carType->carType->title_ar }}</option>
                    @endforeach
                </select>
            </div>

            <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
        </form>
    </div>
@endsection