@extends('admin.app')

@section('title' , __('messages.add_new_offer'))

@push('scripts')
    <script>
        $("#type").on("change", function() {
            
            $(".link-input").hide()
            $(".select-input").hide()
            var language = "{{ Config::get('app.locale') }}"
            var elementType = $(this).val()
            if(elementType != 3){
                $("#type_elements").html('')
                $("#type_elements").parent(".form-group").show()
            $.ajax({
                url : "fetch/" + elementType,
                type : 'GET',
                success : function (data) {
                    if (elementType == 1) {
                        $("#type_elements").siblings("label").text('{{ __("messages.product") }}')
                    }else if(elementType == 2) {
                        $("#type_elements").siblings("label").text('{{ __("messages.category") }}')
                    }
                    data.forEach(function(element) {
                        var elementName = element.title_en
                        if (language == 'ar') {
                            elementName = element.title_ar
                        }
                        $("#type_elements").append(`
                            <option value="${element.id}">${elementName}</option>
                        `)
                    })
                    
                }
            })

            }else{
                $(".link-input").show()
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
                        <h4>{{ __('messages.add_new_offer') }}</h4>
                 </div>
        </div>
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
                <label for="size">{{ __('messages.offer_size') }}</label>
                <select required id="size" name="size" class="form-control">
                    <option disabled selected>{{ __('messages.select') }}</option>
                    <option value="1">{{ __('messages.larg_size') }}</option>
                    <option value="2">{{ __('messages.midium_size') }}</option>
                    <option value="3">{{ __('messages.small_size') }}</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="type">{{ __('messages.offer_type') }}</label>
                <select required id="type" name="type" class="form-control">
                    <option disabled selected>{{ __('messages.select') }}</option>
                    <option value="1">{{ __('messages.product') }}</option>
                    <option value="2">{{ __('messages.category') }}</option>
                    <option value="3">{{ __('messages.link') }}</option>
                </select>
            </div>

            <div style="display: none" class="form-group select-input">
                <label for="type_elements">{{ __('messages.offer_type') }}</label>
                <select  id="type_elements" name="target_id" class="form-control">
                </select>
            </div>

            <div style="display: none" class="form-group link-input">
                <label for="type_elements">{{ __('messages.link') }}</label>
                <input type="text"   name="target_id" class="form-control" >
            </div>


            <div class="form-group mb-4">
                <label for="sort">{{ __('messages.sort') }}</label>
                <input required type="text" name="sort" class="form-control" id="sort" placeholder="{{ __('messages.sort') }}" value="" >
            </div>

            <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
        </form>
    </div>
@endsection