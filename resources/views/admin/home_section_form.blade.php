@extends('admin.ecommerce_app')

@section('title' , __('messages.add_new_home_section'))

@push('scripts')
    <script>
        var ss = $(".tags").select2({
            tags: true,
        });
        var language = "{{ Config::get('app.locale') }}"
        $("#type").on("change", function() {
            if ($(this).val() == 1 || $(this).val() == 5) {
                $("#ads_check").html('')
                var section = 'ads[]',
                    selection = 'checkbox'

                if ($(this).val() == 5) {
                    section = 'mini_ads[]'
                }
                
                $.ajax({
                    url : "/admin-panel/home_sections/fetch/" + $(this).val(),
                    type : 'GET',
                    success : function (data) {
                        $("#ads_check").show()
                        $("#ads_check").prop("disabled", false)
                        $("#categoriesList").parent(".form-group").hide()
                        $("#categoriesList").prop("disabled", true)
                        $("#categoriesList").empty()
                        $("#offers_check").parent(".form-group").hide()
                        $("#offers_check").prop("disabled", true)
                        $("#offers_check").empty()
                        $("#brandsList").parent(".form-group").hide()
                        $("#brandsList").prop("disabled", true)
                        $("#brandsList").empty()
                        data.forEach(function(ad) {
                            $("#ads_check").append(`
                                <div class="col-md-3" >
                                    <div >
                                        <label class="new-control new-checkbox new-checkbox-text checkbox-primary">
                                            <input name="${section}" value="${ad.id}" type="${selection}" class="new-control-input">
                                            <span class="new-control-indicator"></span><span class="new-chk-content"><img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1601416550/${ad.image}" /></span>
                                        </label>
                                    </div>     
                                </div>
                            `)
                        })
                        
                    }
                })
            }else if ($(this).val() == 2) {
                $("#categoriesList").html('')
                $.ajax({
                    url : "/admin-panel/home_sections/fetch/2",
                    type : 'GET',
                    success : function (data) {
                        $("#ads_check").prop("disabled", true)
                        $("#ads_check").hide()
                        $("#ads_check").empty()
                        $("#brandsList").prop("disabled", true)
                        $("#brandsList").parent(".form-group").hide()
                        $("#brandsList").empty()
                        $("#offers_check").parent(".form-group").hide()
                        $("#offers_check").prop("disabled", true)
                        $("#offers_check").empty()
                        $("#categoriesList").prop("disabled", false)
                        $("#categoriesList").parent(".form-group").show()
                        data.forEach(function(category) {
                            var categoryName = category.title_en

                            if (language == 'ar') {
                                categoryName = category.title_ar
                            }
                            $("#categoriesList").append(`
                                <option value="${category.id}" >${categoryName}</option>
                            `)
                        })
                        
                    }
                })
            }else if($(this).val() == 3) {
                $("#brandsList").html('')
                $.ajax({
                    url : "/admin-panel/home_sections/fetch/3",
                    type : 'GET',
                    success : function (data) {
                        $("#ads_check").prop("disabled", true)
                        $("#ads_check").hide()
                        $("#ads_check").empty()
                        $("#offers_check").parent(".form-group").hide()
                        $("#offers_check").prop("disabled", true)
                        $("#offers_check").empty()
                        $("#categoriesList").prop("disabled", true)
                        $("#categoriesList").parent(".form-group").hide()
                        $("#categoriesList").empty()
                        $("#brandsList").parent(".form-group").show()
                        $("#brandsList").prop("disabled", false)
                        data.forEach(function(brand) {
                            var brandName = brand.title_en

                            if (language == 'ar') {
                                brandName = brand.title_ar
                            }
                            $("#brandsList").append(`
                                <option value="${brand.id}" >${brand.title_en}</option>
                            `)
                        })
                        
                    }
                })
            }else if ($(this).val() == 4) {
                $("#offers_check").html('')
                $.ajax({
                    url : "/admin-panel/home_sections/fetch/4",
                    type : 'GET',
                    success : function (data) {
                        $("#offers_check").parent(".form-group").show()
                        $("#offers_check").prop("disabled", false)
                        $("#ads_check").hide()
                        $("#ads_check").prop("disabled", true)
                        $("#ads_check").empty()
                        $("#categoriesList").parent(".form-group").hide()
                        $("#categoriesList").prop("disabled", true)
                        $("#categoriesList").empty()
                        $("#brandsList").parent(".form-group").hide()
                        $("#brandsList").prop("disabled", true)
                        $("#brandsList").empty()
                        console.log(data)
                        data.forEach(function(offer) {
                            var offerName = offer.title_en

                            if (language == 'ar') {
                                offerName = offer.title_ar
                            }
                            $("#offers_check").append(`
                            <option value="${offer.id}" >${offerName}</option>
                            `)
                        })
                        
                    }
                })
            }
        })
        
    </script>
@endpush

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.add_new_home_section') }}</h4>
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
            <div class="form-group mb-4">
                <label for="sort">{{ __('messages.sort') }}</label>
                <input required type="number" name="sort" class="form-control" id="sort" placeholder="{{ __('messages.sort') }}" value="" >
            </div>
            
            <div class="form-group">
                <label for="type">{{ __('messages.section_type') }}</label>
                <select id="type" name="type" class="form-control">
                    <option selected>{{ __('messages.select') }}</option>
                    <option value="1">{{ __('messages.ads_big') }}</option>
                    <option value="2">{{ __('messages.categories') }}</option>
                    <option value="3">{{ __('messages.companies') }}</option>
                    <option value="4">{{ __('messages.offers') }}</option>
                    <option value="5">{{ __('messages.ads_small') }}</option>
                    <option value="7">{{ __('messages.redirect_banner') }}</option>
                </select>
            </div>
            <div style="display: none" id="ads_check" class="row" >
                <div class="col-12" >
                    <label> {{ __('messages.ads') }} </label>
                </div>
                
            </div>
            <div style="display : none" class="form-group" >
                <div class="col-12" >
                    <label> {{ __('messages.categories') }} </label>
                </div>
                <select id="categoriesList" name="categories[]" class="form-control tags" multiple="multiple">
                </select>
            </div>
            <div style="display : none" class="form-group" >
                <div class="col-12" >
                    <label> {{ __('messages.companies') }} </label>
                </div>
                <select id="brandsList" name="brands[]" class="form-control tags" multiple="multiple">
                </select>
            </div>
            
            <div style="display: none" class="form-group" >
                
                <label> {{ __('messages.offers') }} </label>
                
                <select id="offers_check" name="offers[]" class="form-control tags" multiple="multiple">
                </select>
                
            </div>
            
            <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
        </form>
    </div>
@endsection