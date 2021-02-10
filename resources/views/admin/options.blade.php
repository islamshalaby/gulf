@extends('admin.ecommerce_app')

@section('title' , __('messages.show_options'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
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
                            <th>id</th>
                            <th>{{ __('messages.option_title') }}</th>
                            <th>{{ __('messages.category') }}</th>
                            @if(Auth::user()->update_data) 
                                <th class="text-center">{{ __('messages.edit') }}</th>                          
                            @endif
                            @if(Auth::user()->delete_data) 
                                <th class="text-center">{{ __('messages.delete') }}</th>                          
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data['options'] as $option)
                            <tr>
                                <td><?=$i;?></td>
                                <td>{{ App::isLocale('en') ? $option->title_en : $option->title_ar }}</td>
                                <td>
                                    @if(count($option->categories) > 0)
                                    @foreach($option->categories as $categories)
                                    <a target="_blank" href="{{ route('categories.details', $categories->id) }}">
                                        <span class="badge outline-badge-info">{{ App::isLocale('en') ? $categories->title_en : $categories->title_ar }}</span>
                                    </a>
                                    @endforeach
                                    @endif
                                </td>
                                @if(Auth::user()->update_data) 
                                <td class="text-center blue-color" ><a href="{{ route('options.edit', $option->id) }}" ><i class="far fa-edit"></i></a></td>
                                @endif
                                @if(Auth::user()->delete_data) 
                                    <td class="text-center blue-color" ><a onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="{{ route('options.delete', $option->id) }}" ><i class="far fa-trash-alt"></i></a></td>
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