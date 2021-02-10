@extends('admin.ad_app')

@section('title' , __('messages.show_sub_categories'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.show_sub_categories') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="without-print" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{ __('messages.sub_category_title') }}</th>
                            <th>{{ __('messages.category') }}</th>
                            <th class="text-center">{{ __('messages.details') }}</th>
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
                        @foreach ($data['sub_categories'] as $sub_category)
                            <tr>
                                <td><?=$i;?></td>
                                <td>{{ App::isLocale('en') ? $sub_category->title_en : $sub_category->title_ar }}</td>
                                <td>
                                    <a href="{{ route('sub_categories.details', $sub_category->category->id) }}">
                                        {{ App::isLocale('en') ? $sub_category->category->title_en : $sub_category->category->title_ar }}
                                    </a>
                                </td>
                                <td class="text-center blue-color"><a href="{{ route('sub_two_categories.details', $sub_category->id) }}" ><i class="far fa-eye"></i></a></td>
                                @if(Auth::user()->update_data) 
                                    <td class="text-center blue-color" ><a href="{{ route('sub_two_categories.edit', $sub_category->id) }}" ><i class="far fa-edit"></i></a></td>
                                @endif
                                @if(Auth::user()->delete_data) 
                                    <td class="text-center blue-color" >
                                        
                                        <a onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="{{ route('sub_two_categories.delete', $sub_category->id) }}" ><i class="far fa-trash-alt"></i></a>
                                       
                                    </td>
                                @endif                                
                                <?php $i++; ?>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <div class="paginating-container pagination-solid">
            <ul class="pagination">
                <li class="prev"><a href="{{$data['categories']->previousPageUrl()}}">Prev</a></li>
                @for($i = 1 ; $i <= $data['categories']->lastPage(); $i++ )
                    <li class="{{ $data['categories']->currentPage() == $i ? "active" : '' }}"><a href="/admin-panel/categories/show?page={{$i}}">{{$i}}</a></li>               
                @endfor
                <li class="next"><a href="{{$data['categories']->nextPageUrl()}}">Next</a></li>
            </ul>
        </div>   --}}
        
    </div>  

@endsection