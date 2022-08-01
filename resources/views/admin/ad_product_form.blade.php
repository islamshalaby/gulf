@extends('admin.ad_app')

@section('title' , __('messages.add_new_product'))

@push('scripts')
    <script>
    var language = "{{ Config::get('app.locale') }}",
    select = "{{ __('messages.select') }}"
    $("#category").on("change", function() {
        $('select#subcategory').html("")
        $('select#subtwocategory').html("")
        $('select#subthreecategory').html("")
        var categoryId = $(this).find("option:selected").val();

        $.ajax({
                url : "/admin-panel/sub_categories/" + categoryId,
                type : 'GET',
                success : function (data) {
                    $('#subcategory').parent('.form-group').show()
                    $('#subtwocategory').parent('.form-group').hide()
                    $('#subthreecategory').parent('.form-group').hide()

                    $('select#subcategory').prepend(
                            `<option selected disabled>${select}</option>`
                    )
                    data.forEach(function (cat) {
                        catName = cat.title_ar
                        $('select#subcategory').append(
                            "<option value='" + cat.id + "'>" + catName + "</option>"
                        )
                    })
                }
            })
    })

        $("#subcategory").on("change", function() {
        $('select#subtwocategory').html("")
        $('select#subthreecategory').html("")
        
        var categoryId = $(this).find("option:selected").val();

        $.ajax({
                url : "/admin-panel/sub_two_categories/" + categoryId,
                type : 'GET',
                success : function (data) {
                    $('#subcategory').parent('.form-group').show()
                    $('#subtwocategory').parent('.form-group').show()
                    $('#subthreecategory').parent('.form-group').hide()

                    $('select#subtwocategory').prepend(
                            `<option selected disabled>${select}</option>`
                    )
                    data.forEach(function (cat) {
                        catName = cat.title_ar
                        $('select#subtwocategory').append(
                            "<option value='" + cat.id + "'>" + catName + "</option>"
                        )
                    })
                }
            })
    })


            $("#subtwocategory").on("change", function() {

        $('select#subthreecategory').html("")
        
        var categoryId = $(this).find("option:selected").val();

        $.ajax({
                url : "/admin-panel/sub_three_categories/" + categoryId,
                type : 'GET',
                success : function (data) {
                    $('#subcategory').parent('.form-group').show()
                    $('#subtwocategory').parent('.form-group').show()
                    $('#subthreecategory').parent('.form-group').show()

                    $('select#subthreecategory').prepend(
                            `<option selected disabled>${select}</option>`
                    )
                    data.forEach(function (cat) {
                        catName = cat.title_ar
                        $('select#subthreecategory').append(
                            "<option value='" + cat.id + "'>" + catName + "</option>"
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
                    <h4>{{ __('messages.add_new_product') }}</h4>
             </div>
				
    </div>
    
    @if (session('status'))
        <div class="alert alert-danger mb-4" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
            <strong>Error!</strong> {{ session('status') }} </button>
        </div> 
		
    @endif

    <form method="post" enctype="multipart/form-data" action="" >
     @csrf
    <div class="form-group mb-4">
        <label for="title">{{ __('messages.product_name') }}</label>
        <input required type="text" name="title" class="form-control" id="title" placeholder="{{ __('messages.product_name') }}" value="" >
    </div>

    <div class="form-group">
        <label for="sel1">{{ __('messages.category') }}</label>
        <select required id="category" class="form-control" name="category_id" id="sel1">
            <option selected disabled>{{ __('messages.select') }}</option>
            @foreach ($data['categories'] as $category)
            <option value="{{ $category->id }}">{{ $category->title_ar }}</option>
            @endforeach
        </select>
    </div>

    <div  style="display : none" class="form-group">
        <label for="subcategory">{{ __('messages.sub_category') }}</label>
        <select required id="subcategory" class="form-control" name="sub_category_id" >

        </select>
    </div>

    <div style="display : none" class="form-group">
        <label for="subcategory">{{ __('messages.sub_two_category') }}</label>
        <select required id="subtwocategory" class="form-control" name="sub_category_two_id" >

        </select>
    </div>

    <div style="display : none" class="form-group">
        <label for="subcategory">{{ __('messages.sub_three_category') }}</label>
        <select required id="subthreecategory" class="form-control" name="sub_category_three_id" >

        </select>
    </div>


    <div class="form-group">
        <label for="sel1">{{ __('messages.user') }}</label>
        <select class="form-control" name="user_id" id="sel1">
            <option selected disabled>{{ __('messages.select') }}</option>
            @foreach ($data['users'] as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group mb-4 arabic-direction">
        <label for="description">{{ __('messages.description') }}</label>
        <textarea required name="description" placeholder="{{ __('messages.description') }}"  class="form-control" id="description" rows="5"></textarea>
    </div>
    <div class="form-group mb-4">
        <label for="price">{{ __('messages.product_price') }}</label>
        <input required type="number" class="form-control" step="any" min="0"  id="price" name="price" placeholder="{{ __('messages.product_price') }}" value="" >
    </div>  

    <div class="custom-file-container" data-upload-id="myFirstImage">
        <label>{{ __('messages.upload') }} ({{ __('messages.multiple_images') }}) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
        <label class="custom-file-container__custom-file" >
            <input type="file" required name="images[]" multiple class="custom-file-container__custom-file__custom-file-input" accept="image/*">
            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
            <span class="custom-file-container__custom-file__custom-file-control"></span>
        </label>
        <div class="custom-file-container__image-preview"></div>
    </div>    
    <div style="margin-bottom : 20px" >
        <label class="new-control new-checkbox new-checkbox-text checkbox-primary">
          <input name="selected" value="1" type="checkbox" class="new-control-input">
          <span class="new-control-indicator"></span><span class="new-chk-content">{{ __('messages.add_to_choose_for_you') }}</span>
        </label>
    </div>     

    <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
</form>
</div>

@endsection