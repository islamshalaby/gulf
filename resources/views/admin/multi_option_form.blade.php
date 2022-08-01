@extends('admin.ecommerce_app')

@section('title' , __('messages.add_multi_option'))

@push('styles')
    <style>
        .bootstrap-tagsinput .tag {
            color : #3b3f5c
        }
        .bootstrap-tagsinput,
        .bootstrap-tagsinput input {
            width: 100%
        }
        .bootstrap-tagsinput {
            min-height : 45px
        }
    </style>
@endpush
@push('scripts')
    <script>
        // initialize select multiple plugin
        var ss = $(".tags").select2({
            tags: true,
        });
        
    </script>
@endpush

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.add_multi_option') }}</h4>
                 </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" >
            @csrf
                      
            <div class="form-group mb-4">
                <label for="title_en">{{ __('messages.title_en') }}</label>
                <input required type="text" name="title_en" class="form-control" id="title_en" placeholder="{{ __('messages.title_en') }}" value="" >
            </div>
            <div class="form-group mb-4">
                <label for="title_ar">{{ __('messages.title_ar') }}</label>
                <input required type="text" name="title_ar" class="form-control" id="title_ar" placeholder="{{ __('messages.title_ar') }}" value="" >
            </div>
            <div class="form-group">
                <label for="category_select">{{ __('messages.category') }}</label>
                <select id="category_select" name="category_ids[]" class="form-control tags" multiple="multiple">
                    @foreach ( $data['categories'] as $category )
                    <option value="{{ $category->id }}">{{ App::isLocale('en') ? $category->title_en : $category->title_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="title_en">{{ __('messages.value_en') }}</label><br/>
                <input type="text" name="property_values_en" class="form-control" data-role="tagsinput"></input>
            </div>
            <div class="form-group mb-4">
                <label for="title_en">{{ __('messages.value_ar') }}</label><br/>
                <input type="text" name="property_values_ar" class="form-control" data-role="tagsinput"></input>
            </div>
            
            <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
        </form>
    </div>
@endsection