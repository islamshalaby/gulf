@extends('admin.app')

@section('title' , __('messages.area_edit'))

@push('scripts')
<script>
    $("#country").on("change", function() {
        $("#governorate").html("")
        var country = $(this).find("option:selected").val();
        $.ajax({
            url : "/admin-panel/fetchgovernoratescountry/" + country,
            type : 'GET',
            success : function (data) {
                $("#governorate").parent(".form-group").show()
                var  language = "{{ Config::get('app.locale') }}"
                data.forEach(function (governorate) {
                    var name = governorate.name_en
                    if (language == "ar") {
                        name = governorate.name_ar
                    }
                    
                    $('select#governorate').append(
                        "<option value='" + governorate.id + "'>" + name + "</option>"
                    )
                })
            }
        })
    })
</script>
@endpush

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.area_edit') }}</h4>
                 </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" >
            @csrf
                       
            <div class="form-group mb-4">
                <label for="title_en">{{ __('messages.title_en') }}</label>
                <input required type="text" name="name_en" class="form-control" id="title_en" placeholder="{{ __('messages.title_en') }}" value="{{ $data['area']['name_en'] }}" >
            </div>
            <div class="form-group mb-4">
                <label for="title_ar">{{ __('messages.title_ar') }}</label>
                <input required type="text" name="name_ar" class="form-control" id="title_ar" placeholder="{{ __('messages.title_ar') }}" value="{{ $data['area']['name_ar'] }}" >
            </div>
            <div class="form-group mb-4">
                <label for="city_code">{{ __('messages.city_code') }}</label>
                <input required type="text" name="city_code" class="form-control" id="city_code" placeholder="{{ __('messages.city_code') }}" value="{{ $data['area']['city_code'] }}" >
            </div>
            <div class="form-group">
                <label for="country">{{ __('messages.country') }}</label>
                <select id="country" name="country_id" class="form-control">
                    <option disabled>{{ __('messages.select') }}</option>
                    @foreach ( $data['countries'] as $country )
                    <option {{ $data['area']->governorate->country->id == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ App::isLocale('en') ? $country->name_en : $country->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            <div style="" class="form-group">
                <label for="governorate">{{ __('messages.governorate') }}</label>
                <select id="governorate" name="governorate_id" class="form-control">
                    <option disabled>{{ __('messages.select') }}</option>
                    @foreach ( $data['governorates'] as $governorate )
                    <option {{ $data['area']->governorate_id == $governorate->id ? 'selected' : '' }} value="{{ $governorate->id }}">{{ App::isLocale('en') ? $governorate->name_en : $governorate->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
        </form>
    </div>
@endsection