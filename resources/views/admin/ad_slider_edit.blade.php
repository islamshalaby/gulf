@extends('admin.ad_app')

@section('title' , __('messages.ad_edit'))

@push('scripts')
    <script>
        @if ($data['ad']['type'] == 1)
            var country = {{ $data['ad']['country_id'] }}
            var url = '/admin-panel/getadpartproducts/' + country;
            $.ajax({
                    url : url,
                    type : 'GET',
                    success : function (data) {
                        
                        $('.productsParent').show()
                        $('select#products').prop("disabled", false)
                        var content = {{ $data['ad']['content'] }}

                        
                        data.forEach(function (product) {
                            var selected = ""
                            if (content == product.id) {
                                selected = "selected"
                            }
                            var  productName = product.title    
                            
                            $('select#products').append(
                                "<option " + selected +" value='" + product.id + "'>" + productName + "</option>"
                            )
                        })
                    }
                })
            
        @endif
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
                        <h4>{{ __('messages.ad_edit') }}</h4>
                 </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" >
            @csrf
            <div class="form-group mb-4">
                <label for="">{{ __('messages.current_image') }}</label><br>
                <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1601416550/{{ $data['ad']['image'] }}"  />
            </div>
            <div class="custom-file-container" data-upload-id="myFirstImage">
                <label>{{ __('messages.change_image') }} ({{ __('messages.single_image') }}) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                <label class="custom-file-container__custom-file" >
                    <input type="file" name="image" class="custom-file-container__custom-file__custom-file-input" accept="image/*">
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
                    <option {{ $country->id == $data['ad']['country_id'] ? 'selected' : '' }} value="{{ $country->id }}">{{ App::isLocale('en') ? $country->name_en : $country->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="sel1">{{ __('messages.ad_type') }}</label>
                <select id="ad_type" name="type" class="form-control">
                    <option disabled selected>{{ __('messages.select') }}</option>
                    <option {{ $data['ad']['type'] == 2 ? 'selected' : '' }} value="2">{{ __('messages.outside_the_app') }}</option>
                    <option {{ $data['ad']['type'] == 1 ? 'selected' : '' }} value="1">{{ __('messages.inside_the_app') }}</option>
                </select>
            </div>

            
                   
            <div style="display: {{ $data['ad']['type'] == 1 ? 'none' : '' }}" class="form-group mb-4 outside">
                <label for="link">{{ __('messages.link') }}</label>
                <input required type="text" name="content" class="form-control" id="link" placeholder="{{ __('messages.link') }}" value="{{ $data['ad']['content'] }}" >
            </div>
            

            <div style="display: none" class="form-group productsParent">
                <label for="products">{{ __('messages.product') }}</label>
                <select id="products" class="form-control" name="content">
                    <option disabled selected>{{ __('messages.select') }}</option>
                </select>
            </div>
            
            {{--  <div class="form-group" >
                <label for="slider">{{ __('messages.slider') }}</label>
                <input  {{ $data['ad']['place'] == 1 ? 'checked' : '' }} type="checkbox"  name="place" value="1"  >
            </div>  --}}

            <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
        </form>
    </div>
@endsection