@extends('admin.ecommerce_app')

@section('title' , __('messages.edit_property'))

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.edit_property') }}</h4>
                 </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" >
            @csrf
            <div class="row">
                @if (count($data['categories']) > 0)
                @foreach ($data['categories'] as $cat)
                <div class="col-sm-4">
                    <div class="col-sm-6">
                        <label for="title_en">{{ $cat->title_ar }}</label>
                    </div>
                    <div class="col-sm-6">
                        <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                            <input value="{{ $cat->id }}" onchange="update_category(this)" type="checkbox">
                            <span style="margin-top: 10px;" class="slider round"></span>
                        </label>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
        </form>
    </div>
@endsection