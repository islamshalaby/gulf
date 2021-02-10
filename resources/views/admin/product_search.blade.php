@extends('admin.ecommerce_app')

@section('title' , __('messages.show_products'))
@push('styles')
<style>
    .filtered-list-search form button {
        left: 4px;
        right : auto
    }
    .add-prod-container {
        padding: 20px 0;
    }
    .widget.box .widget-header,
    .add-prod-container,
    .widget.prod-search {
        background-color: #1b55e2 !important;
    }
    .filtered-list-search {
        margin-top: 50px
    }
    .add-prod-container h4,
    .widget h2{
        color: #FFF
    }
</style>
@endpush

@push('scripts')
    <script>
        var language = "{{ Config::get('app.locale') }}",
            select = "{{ __('messages.select') }}"
        $(".search-manually").on('click', function() {
            $(this).hide()
            $(".filter-selects").slideDown()
        })
        $("#category").on("change", function() {
            $("#sub_category_select").parent(".form-group").hide()
            
            var categoryId = $(this).val()
            
            $("#sub_category_select").html("")
            $.ajax({
                url : "/admin-panel/products/fetchsubcategorybycategory/" + categoryId,
                type : 'GET',
                success : function (data) {
                    $("#sub_category_select").prepend(`
                            <option selected disabled>${select}</option>
                        `)
                    data.forEach(function(element) {
                        var elementName = element.title_en
                        if (language == 'ar') {
                            elementName = element.title_ar
                        }
                        
                        $("#sub_category_select").parent('.form-group').show()
                        $("#sub_category_select").append(`
                            <option value="${element.id}">${elementName}</option>
                        `)
                    })
                }
            })
        })

        $("#category").on("change", function() {
            $("#manual_search").submit()
        })
    </script>
@endpush

@section('content')
<div id="badgeCustom" class="col-lg-12 mx-auto layout-spacing">
    <div class="statbox widget prod-search box box-shadow">
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <h2 style="margin-bottom: 20px" class="text-center">{{ __('messages.what_do_sell') }}</h2>
        <div class="col-lg-8 col-md-8 col-sm-9 filtered-list-search mx-auto">
            <form class="form-inline my-2 my-lg-0 justify-content-center">
                <div class="w-100">
                    <input type="text" class="w-100 form-control product-search br-30" id="input-search" name="name" placeholder="{{ __('messages.search_for_product_name') }}">
                    <button class="btn btn-primary" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></button>
                </div>
            </form>
        </div>
        <h5 style="cursor: pointer; color: #FFF" class="text-center search-manually">{{ __('messages.or_search_manually') }}</h5>
        <div style="display: none" class="widget-content widget-content-area filter-selects">
            
            <form id="manual_search" action="{{ route('products.getbysubcat') }}">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="category">{{ __('messages.category') }}</label>
                        <select name="category_id" required id="category" class="form-control">
                            <option disabled selected>{{ __('messages.select') }}</option>
                            @foreach ( $data['categories'] as $category )
                            <option value="{{ $category->id }}">{{ App::isLocale('en') ? $category->title_en : $category->title_ar }}</option>
                            @endforeach 
                        </select>
                    </div>
                    {{-- <div style="display: none" class="form-group col-md-4">
                        <label for="sub_category_select">{{ __('messages.sub_category') }}</label>
                        <select required id="sub_category_select" name="sub_cat" class="form-control">
                            <option disabled selected>{{ __('messages.select') }}</option>
                        </select>
                    </div> --}}
                </div>
            </form>
            
        </div>
        
    </div>  

@endsection