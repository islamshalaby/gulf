@extends('admin.ecommerce_app')

@section('title' , __('messages.edit_property'))

@push('styles')
<style>
.hide {
    display: none
}
</style>
    
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-6 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>{{ __('messages.edit_filter') }}</h4>
                        </div>
                    </div>
                </div>
                <form class="options_form" action="" method="post" >
                    @csrf
                    @method('put')
                    <div id="option-inputs">
                        <input type="hidden" value="{{ $data['option']->id }}" name="option_id" />
                        <div class="form-group mb-4">
                            <label for="title_en">{{ __('messages.title_en') }}</label>
                            <input required type="text" name="title_en" class="form-control" id="title_en" placeholder="{{ __('messages.title_en') }}" value="{{ $data['option']->title_en }}" >
                        </div>
                        <div class="form-group mb-4">
                            <label for="title_ar">{{ __('messages.title_ar') }}</label>
                            <input required type="text" name="title_ar" class="form-control" id="title_ar" placeholder="{{ __('messages.title_ar') }}" value="{{ $data['option']->title_ar }}" >
                        </div>
                        <button onclick="update_option(event)" class="btn btn-primary">{{ __('messages.add') }}</button>
                    </div>
                </form>
                
            </div>
            
        </div>
        <div data-option="" class="col-lg-6 col-6 layout-spacing assign-cats hide">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>{{ __('messages.assign_cats') }}</h4>
                        </div>
                    </div>
                </div>
                <form class="cats_form" action="" method="post" >
                    @csrf
                    <div class="row">
                        @if (count($data['categories']) > 0)
                        @foreach ($data['categories'] as $cat)
                        <div class="col-sm-4">
                            <div class="col-sm-6">
                                <label for="title_en">{{ $cat->title_ar }}</label>
                            </div>
                            <div class="col-sm-6">
                                <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                                    <input value="{{ $cat->id }}" onchange="update_category(this)" {{ in_array($cat->id, $data['categories_array']) ? 'checked' : '' }} type="checkbox">
                                    <span style="margin-top: 10px;" class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </form>
                <button class="btn btn-primary next">{{ __('messages.add_values') }}</button>
                
            </div>
        </div>
        <div class="col-lg-6 col-6 layout-spacing hide">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>{{ __('messages.add_values') }}</h4>
                        </div>
                    </div>
                </div>
                <form class="values_form" action="" method="post" >
                    @csrf
                    <input type="hidden" name="option_id" class="form-control" id="option_id" value="" >
                    <div class="form-group mb-4">
                        <label for="value_en">{{ __('messages.value_en') }}</label>
                        <input required type="text" name="value_en" class="form-control" id="value_en" placeholder="{{ __('messages.value_en') }}" value="" >
                    </div>
                    <div class="form-group mb-4">
                        <label for="value_ar">{{ __('messages.value_ar') }}</label>
                        <input required type="text" name="value_ar" class="form-control" id="value_ar" placeholder="{{ __('messages.value_ar') }}" value="" >
                    </div>
                    
                    <button onclick="add_values(event)" class="btn btn-primary">{{ __('messages.add') }}</button>
                    
                </form>
            </div>
        </div>
        <div class="col-lg-6 col-6 layout-spacing list-values hide">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>{{ __('messages.list_values') }}</h4>
                        </div>
                    </div>
                </div>
                <table id="example" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ __('messages.value_en') }}</th>
                            <th>{{ __('messages.value_ar') }}</th>
                        </tr>
                    </thead>
                    <tbody id="values-tbody">
                        @if(count($data['option']->values) > 0)
                            @foreach ($data['option']->values as $val)
                            <tr>
                                <td style="width: 30%;">
                                    <span style="display: inline;"><button onclick="delete_value({{ $val->id }})" class="btn btn-danger"><i class="far fa-trash-alt"></i></button></span>
                                    <span style="display: inline;"><button onclick="update_value({{ $val->id }})" class="btn btn-success"><i class="far fa-edit"></i></button></span>
                                </td>
                                <td><input class="form-control valen{{ $val->id }}" type="text" name="value_en" value="{{ $val->value_en }}" /></td>
                                <td><input class="form-control valar{{ $val->id }}" type="text" name="value_ar" value="{{ $val->value_ar }}" /></td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.main_filter') }}</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive"> 
                    <table id="option-table" class="table table-bordered mb-4">
                        <tbody id="options-data">
                            <tr>
                                <td class="label-table" > {{ __('messages.title_en') }}</td>
                                <td>{{ $data['option']['title_en'] }}</td>
                            </tr>
                            <tr>
                                <td class="label-table" > {{ __('messages.title_ar') }} </td>
                                <td>{{ $data['option']['title_ar'] }}</td>
                            </tr>
                            <tr>
                                <td class="label-table" > {{ __('messages.category') }} </td>
                                <td> 
                                    @if(count($data['option']->categories) > 0)
                                    @foreach($data['option']->categories as $categories)
                                    <a target="_blank" href="{{ route('categories.details', $categories->id) }}">
                                        <span class="badge outline-badge-info">{{ App::isLocale('en') ? $categories->title_en : $categories->title_ar }}</span>
                                    </a>
                                    @endforeach
                                    @endif
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="label-table" > {{ __('messages.list_values') }} </td>
                                <td> 
                                    @if(count($data['option']->values) > 0)
                                    @foreach($data['option']->values as $value)
                                    <span class="badge outline-badge-info">{{ App::isLocale('en') ? $value->value_en : $value->value_ar }}</span>
                                    @endforeach
                                    @endif
                                </td>
                            </tr>
                                
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        // update option form
        function update_option(event){
            event.preventDefault()
            $.post('{{ route('options.update.filter') }}', $(".options_form").serialize(), function(data){
                
                if(data > 0){
                    toastr.success("{{ __('messages.updated_s') }}");
                    $(".options_form").parent(".statbox").parent(".col-lg-6").hide()
                    $(".options_form")[0].reset()
                    $("#option-table").load(" #options-data");
                    $(".assign-cats").fadeIn()
                    $(".assign-cats").attr("data-option", data)
                }
                else{
                    toastr.error("{{ __('messages.title_req') }}");
                }
            });
        }

        // update category
        function update_category(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }

            var optionId = $(".assign-cats").attr("data-option")

            $.post('{{ route('options.categories.update') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                option_id : optionId,
                status: status
            }, function (data) {
                if (data == 1) {
                    toastr.success("{{trans('messages.option_added_to_category')}}");
                } else {
                    toastr.error("{{trans('messages.option_removed_from_category')}}");
                }
                
                $("#option-table").load(" #options-data");
            });
        }

        // go to add values
        $(".next").on("click", function(event) {
            event.preventDefault()
            $(".cats_form")[0].reset()
            $(".cats_form").parent(".statbox").parent(".col-lg-6").hide()
            $(".values_form").parent(".statbox").parent(".col-lg-6").fadeIn()
            $(".list-values").fadeIn()
        })

        // add values
        function add_values(event) {
            event.preventDefault()
            var optionId = $(".assign-cats").attr("data-option")

            $("#option_id").attr("value", optionId)
            
            $.post('{{ route('options.vals.add') }}', $(".values_form").serialize(), function(data){
                if(data > 0){
                    toastr.success("{{ __('messages.added_s') }}");
                    $(".values_form")[0].reset()
                    $("#option-table").load(" #options-data");
                    $("#example").load(" #values-tbody")
                }
                else{
                    toastr.error("{{ __('messages.values_required') }}");
                }
            });
        }

        // update value
        function update_value(valueId) {
            var valEn = $(`.valen${valueId}`).val(),
            valAr = $(`.valar${valueId}`).val()
            
            $.post('{{ route('options.update.value') }}', {
                _token: '{{ csrf_token() }}',
                _method: 'put',
                value_id: valueId,
                value_en : valEn,
                value_ar : valAr
            }, function (data) {
                if (data == 1) {
                    toastr.success("{{trans('messages.value_updated_s')}}");
                } else {
                    toastr.error("{{trans('messages.values_required')}}");
                }
                
                $("#option-table").load(" #options-data");
            });
        }

        // delete value
        function delete_value(valueId) {
            
            $.post('{{ route('options.delete.value') }}', {
                _token: '{{ csrf_token() }}',
                _method: 'delete',
                value_id: valueId
            }, function (data) {
                if (data == 1) {
                    toastr.success("{{trans('messages.value_deleted_s')}}");
                } else if(data == 2) {
                    toastr.warning("{{trans('messages.value_has_products')}}");
                }else {
                    toastr.error("{{trans('messages.value_id_required')}}");
                }
                $("#example").load(" #values-tbody")
                $("#option-table").load(" #options-data");
            });
        }
    </script>
@endpush