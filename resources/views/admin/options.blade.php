@extends('admin.ecommerce_app')
@push('styles')
<style>
.hide {
    display: none
}

td, th {
    width : 13% !important
}
</style>
    
@endpush

@section('title' , __('messages.show_options'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-6 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>{{ __('messages.add_filter') }}</h4>
                        </div>
                    </div>
                </div>
                <form class="options_form" action="" method="post" >
                    @csrf
                    <div id="option-inputs">
                        <div class="form-group mb-4">
                            <label for="title_en">{{ __('messages.title_en') }}</label>
                            <input required type="text" name="title_en" class="form-control" id="title_en" placeholder="{{ __('messages.title_en') }}" value="" >
                        </div>
                        <div class="form-group mb-4">
                            <label for="title_ar">{{ __('messages.title_ar') }}</label>
                            <input required type="text" name="title_ar" class="form-control" id="title_ar" placeholder="{{ __('messages.title_ar') }}" value="" >
                        </div>
                        <button onclick="add_option(event)" class="btn btn-primary">{{ __('messages.add') }}</button>
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
                                    <input value="{{ $cat->id }}" onchange="update_category(this)" type="checkbox">
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
                    <button class="btn btn-primary done-btn">{{ __('messages.done') }}</button>
                    
                    
                </form>
            </div>
        </div>
    </div>
</div>
    
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        @if(Session::has('success'))
            <div class="alert alert-icon-left alert-light-success mb-4" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12" y2="17"></line></svg>
                <strong>{{ Session('success') }}</strong>
            </div>
        @endif
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.show_options') }}</h4>
                </div>
            </div>
        </div>
        
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="without-print" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">id</th>
                            <th class="text-center">{{ __('messages.option_title') }}</th>
                            <th class="text-center">{{ __('messages.category') }}</th>
                            <th class="text-center">{{ __('messages.list_values') }}</th>
                            @if(Auth::user()->update_data) 
                                <th class="text-center">{{ __('messages.edit') }}</th>                          
                            @endif
                            @if(Auth::user()->delete_data) 
                                <th class="text-center">{{ __('messages.delete') }}</th>                          
                            @endif
                        </tr>
                    </thead>
                    <tbody id="options-data">
                        <?php $i = 1; ?>
                        @foreach ($data['options'] as $option)
                            <tr>
                                <td class="text-center"><?=$i;?></td>
                                <td class="text-center">{{ App::isLocale('en') ? $option->title_en : $option->title_ar }}</td>
                                <td class="text-center">
                                    @if(count($option->categories) > 0)
                                    @foreach($option->categories as $categories)
                                    <a target="_blank" href="{{ route('categories.details', $categories->id) }}">
                                        <span class="badge outline-badge-info">{{ App::isLocale('en') ? $categories->title_en : $categories->title_ar }}</span>
                                    </a>
                                    @endforeach
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(count($option->values) > 0)
                                    @foreach($option->values as $value)
                                    <span class="badge outline-badge-info">{{ App::isLocale('en') ? $value->value_en : $value->value_ar }}</span>
                                    @endforeach
                                    @endif
                                </td>
                                
                                @if(Auth::user()->update_data) 
                                <td class="text-center blue-color" ><a href="{{ route('options.edit', $option->id) }}" ><i class="far fa-edit"></i></a></td>
                                @endif
                                @if(Auth::user()->delete_data) 
                                    <td class="text-center blue-color" >
                                        @if(count($option->products) > 0)
                                        {{ __('messages.option_added_products') }}
                                        @else
                                        <a onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="{{ route('options.delete', $option->id) }}" ><i class="far fa-trash-alt"></i></a>
                                        @endif 
                                    </td>
                                @endif  
                                <?php $i++; ?>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>  

@endsection

@push('scripts')
    <script type="text/javascript">

        // add option form
        function add_option(event){
            event.preventDefault()
            $.post('{{ route('options.add.post') }}', $(".options_form").serialize(), function(data){
                
                if(data > 0){
                    toastr.success("{{ __('messages.added_s') }}");
                    $(".options_form").parent(".statbox").parent(".col-lg-6").hide()
                    $(".options_form")[0].reset()
                    $("#without-print").load(" #options-data");
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
                
                $("#without-print").load(" #options-data");
            });
        }

        // go to add values
        $(".next").on("click", function(event) {
            event.preventDefault()
            $(".cats_form")[0].reset()
            $(".cats_form").parent(".statbox").parent(".col-lg-6").hide()
            $(".values_form").parent(".statbox").parent(".col-lg-6").fadeIn()
        })

        // add values
        function add_values(event) {
            event.preventDefault()
            var optionId = $(".assign-cats").attr("data-option")

            $("#option_id").attr("value", optionId)
            
            $.post('{{ route('options.vals.add') }}', $(".values_form").serialize(), function(data){
                console.log(data)
                if(data > 0){
                    toastr.success("{{ __('messages.added_s') }}");
                    $(".values_form")[0].reset()
                    $("#without-print").load(" #options-data")
                }
                else{
                    toastr.error("{{ __('messages.values_required') }}");
                }
            });
        }

        // go back to add option
        $(".done-btn").on("click", function(event) {
            event.preventDefault()
            $(".values_form").parent(".statbox").parent(".col-lg-6").hide()
            $(".options_form").parent(".statbox").parent(".col-lg-6").fadeIn()
        })
    </script>
@endpush