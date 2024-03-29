@extends('admin.ecommerce_app')

@section('title' , __('messages.add_new_delivery_method'))

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.add_new_delivery_method') }}</h4>
                 </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" >
            @csrf
            <div class="custom-file-container" data-upload-id="myFirstImage">
                <label>{{ __('messages.upload') }} ({{ __('messages.single_image') }}) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                <label class="custom-file-container__custom-file" >
                    <input type="file" required name="icon" class="custom-file-container__custom-file__custom-file-input" accept="image/*">
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
            {{-- <div class="form-group mb-4">
                <label for="method_price">{{ __('messages.method_price') }}</label>
                <input required type="number" step="any" min="0" name="price" class="form-control" id="method_price" placeholder="{{ __('messages.method_price') }}" value="" >
            </div> --}}
            <div class="form-group mb-4 english-direction" >
                <label for="demo1">{{ __('messages.english') }} *</label>
                <textarea required name="description_en" class="form-control"  rows="5">{{ old('description_en') }}</textarea>
            </div>

            <div class="form-group mb-4 arabic-direction">
                <label for="demo2">{{ __('messages.arabic') }} *</label>
                <textarea name="description_ar" required  class="form-control"  rows="5">{{ old('description_ar') }}</textarea>
            </div> 
               
            <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
        </form>
    </div>
@endsection