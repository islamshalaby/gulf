@extends('admin.ad_app')

@section('title' , __('messages.edit'))
@push('scripts')
    <script>
        $("select#users").on("change", function () {
            $('select#products').html("")
            var userId = $(this).find("option:selected").val();
            console.log(userId)
            $.ajax({
                url : "/admin-panel/ads/fetchproducts/" + userId,
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
        var user = $("select#users option:selected").val()

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
                        <h4>{{ __('messages.edit') }}</h4>

                 </div>
            </div>
        </div>
        <form action="{{route('options_values.update.new',$data->id)}}" enctype="multipart/form-data" method="post" >
            @csrf
            <div class="form-group mb-4">
                <label for="plan_price">{{ __('messages.value_ar') }}</label>
                <input required type="text" name="value_ar" value="{{$data->value_ar}}" class="form-control" >
            </div>
            <div class="form-group mb-4">
                <label for="plan_price">{{ __('messages.value_en') }}</label>
                <input required type="text" name="value_en" value="{{$data->value_en}}" class="form-control" >
            </div>
            <input type="submit" value="{{ __('messages.edit') }}" class="btn btn-primary">
        </form>
    </div>
@endsection
