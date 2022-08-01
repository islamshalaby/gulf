@extends('admin.ad_app')

@section('title' , __('messages.add_new_ad'))

@push('scripts')
    <script>
        
        $("#ad_type").on("change", function() {
            if(this.value == 2) {
                $('select#products').html("")
                $(".outside").show()
                $('.productsParent').hide()
                $(".product_type").hide()
                $('select#products').prop("disabled", true)
                $(".outside input").prop("disabled", false)
                $(".inside").hide()
            }else {
                $(".outside").hide()
                $(".outside input").prop("disabled", true)
                $(".product_type").show()
                var country = $("#country").find("option:selected").val()
                var url = '/admin-panel/getadpartproducts/' + country;
                $.ajax({
                    url : url,
                    type : 'GET',
                    success : function (data) {
                        
                        $('.productsParent').show()
                        $('select#products').prop("disabled", false)
                        data.forEach(function (product) {
                            var  productName = product.title    
                            
                            $('select#products').append(
                                "<option value='" + product.id + "'>" + productName + "</option>"
                            )
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
                        <h4>{{ __('messages.add_new_ad') }}</h4>
                 </div>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="list-unstyled mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="" method="post" enctype="multipart/form-data" >
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
            <div class="form-group">
                <label for="country">{{ __('messages.country') }}</label>
                <select id="country" name="country_id" class="form-control">
                    <option selected>{{ __('messages.select') }}</option>
                    @foreach ( $data['countries'] as $country )
                    <option value="{{ $country->id }}">{{ App::isLocale('en') ? $country->name_en : $country->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="sel1">{{ __('messages.ad_type') }}</label>
                <select id="ad_type" name="type" class="form-control">
                    <option selected>{{ __('messages.select') }}</option>
                    <option value="2">{{ __('messages.outside_the_app') }}</option>
                    <option value="1">{{ __('messages.inside_the_app') }}</option>
                </select>
            </div>

            <div style="display: none" class="form-group mb-4 outside">
                <label for="link">{{ __('messages.link') }}</label>
                <input required type="text" name="content" class="form-control" id="link" placeholder="{{ __('messages.link') }}" value="" >
            </div>


            {{--  <div style="display: none" class="form-group product_type">
                <label for="sel1">{{ __('messages.category') }}</label>
                <select id="product_type" name="product_type" class="form-control">
                    <option disabled selected>{{ __('messages.select') }}</option>
                    <option value="1">{{ __('messages.ecoomercepart') }}</option>
                    <option value="2">{{ __('messages.adpart') }}</option>
                </select>
            </div>  --}}


            
            <div style="display: none" class="form-group productsParent">
                <label for="products">{{ __('messages.product') }}</label>
                <select id="products" class="form-control" name="content">
                </select>
            </div>

            {{--  <div class="form-group" >
                <label for="slider">{{ __('messages.slider') }}</label>
                <input type="checkbox"  name="place" value="1"  >
            </div>  --}}

            <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
        </form>
    </div>
@endsection