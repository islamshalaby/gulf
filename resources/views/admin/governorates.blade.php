@extends('admin.ad_app')

@section('title' , __('messages.show_governorates'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.show_governorates') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="without-print" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{ __('messages.governorate') }}</th>
                            <th>{{ __('messages.country') }}</th>
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
                        @foreach ($data['governorates'] as $governorate)
                            <tr>
                                <td><?=$i;?></td>
                                <td>{{ App::isLocale('en') ? $governorate->name_en : $governorate->name_ar }}</td>
                                <td>
                                    <a href="{{ route('countries.details', $governorate->country_id) }}" target="_blank">
                                        {{ App::isLocale('en') ? $governorate->country->name_en : $governorate->country->name_ar }}
                                    </a>
                                </td>
                                <td class="text-center blue-color"><a href="{{ route('governorates.details', $governorate->id) }}" ><i class="far fa-eye"></i></a></td>
                                @if(Auth::user()->update_data) 
                                    <td class="text-center blue-color" ><a href="{{ route('governorates.edit', $governorate->id) }}" ><i class="far fa-edit"></i></a></td>
                                @endif
                                @if(Auth::user()->delete_data) 
                                    <td class="text-center blue-color" >
                                        
                                        @if(count($governorate->areas) > 0)
                                        {{ __('messages.governorate_has_areas') }}
                                        @else
                                        <a onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="{{ route('governorates.delete', $governorate->id) }}" ><i class="far fa-trash-alt"></i></a>
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