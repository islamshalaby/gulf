@extends('admin.ad_app')


@section('title' , __('messages.show_categories'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.show_categories') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="without-print" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{ __('messages.category_title') }}</th>
                            <th class="text-center">{{ __('messages.cat_options') }}</th>
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
                        @foreach ($data['categories'] as $category)
                            <tr>
                                <td><?=$i;?></td>
                                <td>{{ App::isLocale('en') ? $category->title_en : $category->title_ar }}</td>
                                <td>
                                    <a href="{{route('cat_options.show',[0, $category->id])}}">
                                        <div class="">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-inbox">
                                                <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                                                <path
                                                    d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
                                            </svg>
                                        </div>
                                    </a>
                                </td>
                                <td class="text-center blue-color"><a href="{{ Request::segment(2) == 'categories' ? route('categories.details', $category->id) : route('categories.ads.details', $category->id) }}" ><i class="far fa-eye"></i></a></td>
                                @if(Auth::user()->update_data) 
                                    <td class="text-center blue-color" ><a href="{{ Request::segment(2) == 'categories' ? '/admin-panel/categories/edit/' . $category->id : '/admin-panel/ads_categories/edit/' . $category->id }}" ><i class="far fa-edit"></i></a></td>
                                @endif
                                @if(Auth::user()->delete_data) 
                                    <td class="text-center blue-color" >
                                        @if(Request::segment(2) == 'categories')
                                            @if(count($category->products) == 0 && count($category->subCategories) == 0)
                                            <a onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="/admin-panel/categories/delete/{{ $category->id }}" ><i class="far fa-trash-alt"></i></a>
                                            @else
                                            {{ __('messages.cat_has_products') }}
                                            @endif
                                        @else
                                            @if(count($category->adPrs) == 0 && count($category->subCategories) == 0)
                                            <a onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="/admin-panel/categories/delete/{{ $category->id }}" ><i class="far fa-trash-alt"></i></a>
                                            @else
                                            {{ __('messages.cat_has_products') }}
                                            @endif
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