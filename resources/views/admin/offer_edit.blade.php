@extends('admin.app')

@section('title' , __('messages.offer_edit'))

@push('scripts')
    <script>
        var language = "{{ Config::get('app.locale') }}"
        $("#type").on("change", function() {
            $(".link-input").hide()
            $(".select-input").hide()


            $("#type_elements").html('')
            var elementType = $(this).val()
            if(elementType != 3){
            $("#type_elements").parent(".form-group").show()
            $(".link-input input").attr("disabled", "disabled");
            $(".select-input select").removeAttr('disabled');
            $.ajax({
                url : "/admin-panel/offers/fetch/" + elementType,
                type : 'GET',
                success : function (data) {
                    if (elementType == 1) {
                        $("#type_elements").siblings("label").text('{{ __("messages.product") }}')
                    }else if (elementType == 2){
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
                $(".link-input input").removeAttr("disabled");
            $(".select-input select").attr("disabled", "disabled");
                $(".link-input").show()
            }
            
        })
        
        $(".link-input").hide()
        $(".select-input").hide()
        $(".link-input input").attr("disabled", "disabled");
            $(".select-input select").attr("disabled", "disabled");
        var elementType = $("#type").val()
        if(elementType != 3){
            $("#type_elements").parent(".form-group").show()
            $(".link-input input").attr("disabled", "disabled");
            $(".select-input select").removeAttr('disabled');
            // $target = {{$data['offer']['target_id']}}
            // $target = ${$data['offer']['target_id']};
            // console.log($target);

            $.ajax({
                url : "/admin-panel/offers/fetch/" + elementType,
                type : 'GET',
                success : function (data) {
                    if (elementType == 1) {
                        $("#type_elements").siblings("label").text('{{ __("messages.product") }}')
                    }else  if(elementType == 2){
                        $("#type_elements").siblings("label").text('{{ __("messages.category") }}')
                    }

                    data.forEach(function(element) {
                        itemId = "{{ $data['offer']['target_id'] }}",
                            selected = ""
                        if (itemId == element.id) {
                            selected = "selected"
                        }
                     
                        var elementName = element.title_en
                        if (language == 'ar') {
                            elementName = element.title_ar
                        }
                        $("#type_elements").append(`
                            <option ${selected}  value="${element.id}">${elementName}</option>
                        `)
                    })
                    
                }
            })
        }else{
            $(".link-input input").removeAttr("disabled");
            $(".select-input select").attr("disabled", "disabled");
            $(".link-input").show()
        }
    </script>
@endpush

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.offer_edit') }}</h4>
                 </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" >
            @csrf
            <div class="form-group mb-4">
                <label for="">{{ __('messages.current_image') }}</label><br>
                <img src="https://res.cloudinary.com/dy4xq0cvc/image/upload/w_100,q_100/v1601416550/{{ $data['offer']['image'] }}"  />
            </div>
            <div class="custom-file-container" data-upload-id="myFirstImage">
                <label>{{ __('messages.upload') }} ({{ __('messages.single_image') }}) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                <label class="custom-file-container__custom-file" >
                    <input type="file" name="image" class="custom-file-container__custom-file__custom-file-input" accept="image/*">
                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                    <span class="custom-file-container__custom-file__custom-file-control"></span>
                </label>
                <div class="custom-file-container__image-preview"></div>
            </div>

            <div class="form-group">
                <label for="size">{{ __('messages.offer_size') }}</label>
                <select required id="size" name="size" class="form-control">
                    <option disabled selected>{{ __('messages.select') }}</option>
                    <option {{ $data['offer']['size'] == 1 ? 'selected' : '' }} value="1">{{ __('messages.larg_size') }}</option>
                    <option {{ $data['offer']['size'] == 2 ? 'selected' : '' }} value="2">{{ __('messages.midium_size') }}</option>
                    <option {{ $data['offer']['size'] == 3 ? 'selected' : '' }} value="3">{{ __('messages.small_size') }}</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="type">{{ __('messages.offer_type') }}</label>
                <select required id="type" name="type" class="form-control">
                    <option disabled selected>{{ __('messages.select') }}</option>
                    <option {{ $data['offer']['type'] == 1 ? 'selected' : '' }} value="1">{{ __('messages.product') }}</option>
                    <option {{ $data['offer']['type'] == 2 ? 'selected' : '' }} value="2">{{ __('messages.category') }}</option>
                    <option {{ $data['offer']['type'] == 3 ? 'selected' : '' }} value="3">{{ __('messages.link') }}</option>
                </select>
            </div>

            <div style="display: none" class="form-group select-input">
                <label for="type_elements">{{ __('messages.offer_type') }}</label>
                <select  id="type_elements" name="target_id" class="form-control">
                </select>
            </div>

            <div style="display: none" class="form-group link-input">
                <label for="type_elements">{{ __('messages.link') }}</label>
                <input type="text" value="{{ $data['offer']['target_id'] }}" required  name="target_id" class="form-control" >
            </div>

            <div class="form-group mb-4">
                <label for="sort">{{ __('messages.sort') }}</label>
                <input required type="text" name="sort" class="form-control" id="sort" placeholder="{{ __('messages.sort') }}" value="{{ $data['offer']['sort'] }}" >
            </div>

            <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
        </form>
    </div>
@endsection