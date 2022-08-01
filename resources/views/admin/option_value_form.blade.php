@extends('admin.ad_app')

@section('title' , __('messages.add'))
@push('scripts')
    <script>
        $("select#users").on("change", function () {
            $('select#products').html("")
            var userId = $(this).find("option:selected").val();
            console.log(userId)
            $.ajax({
                url : "fetchproducts/" + userId,
                type : 'GET',
                success : function (data) {
                    $('.productsParent').show()
                    $('select#products').prop("disabled", false)
                    data.forEach(function (product) {
                        $('select#products').append(
                            "<option value='" + product.id + "'>" + product.title + "</option>"
                        )
                    })
                }
            })
        })
        $("#ad_type").on("change", function() {
            if(this.value == 1) {
                $(".outside").show()
                $('.productsParent').hide()
                $('select#products').prop("disabled", true)
                $(".outside input").prop("disabled", false)
                $(".inside").hide()
            }else {
                $(".outside").hide()
                $(".outside input").prop("disabled", true)
                $(".inside").show()
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
                        <h4>{{ __('messages.add') }}</h4>
                    </div>
                </div>
            </div>
            <form action="{{route('options_values.store')}}" method="post" enctype="multipart/form-data" >
                @csrf
                <input required type="hidden" name="option_id" value="{{$option_id}}" class="form-control" >
                <div class="custom-file-container" data-upload-id="myFirstImage">
                    <label>{{ __('messages.upload') }} ({{ __('messages.single_image') }}) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                    <label class="custom-file-container__custom-file" >
                        <input type="file" required name="image" class="custom-file-container__custom-file__custom-file-input" accept="image/*">
                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                    </label>
                    <div class="custom-file-container__image-preview"></div>
                </div>
                <div class="form-group mb-4">
                    <label for="plan_price">{{ __('messages.value_ar') }}</label>
                    <input required type="text" name="value_ar"  class="form-control" >
                </div>
                <div class="form-group mb-4">
                    <label for="plan_price">{{ __('messages.value_en') }}</label>
                    <input required type="text" name="value_en" class="form-control" >
                </div>
                <input type="submit" value="{{ __('messages.add') }}" class="btn btn-primary">
            </form>
        </div>
@endsection
