@extends('admin.ecommerce_app')

@section('title' , __('messages.show_delivery_methods'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.show_delivery_methods') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="without-print" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{ __('messages.delivery_method') }}</th>
                            {{-- <th>{{ __('messages.method_price') }}</th> --}}
                            @if(Auth::user()->update_data) 
                                <th class="text-center">{{ __('messages.edit') }}</th>                          
                            @endif
                            {{-- @if(Auth::user()->delete_data) 
                                <th class="text-center">{{ __('messages.delete') }}</th>                          
                            @endif --}}
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data['methods'] as $method)
                            <tr>
                                <td><?=$i;?></td>
                                <td>{{ App::isLocale('en') ? $method->title_en : $method->title_ar }}</td>
                                {{-- <td>{{ $method->price . " " . __('messages.dinar') }}</td> --}}
                                {{-- <td class="text-center blue-color"><a href="#" ><i class="far fa-eye"></i></a></td> --}}
                                @if(Auth::user()->update_data) 
                                    <td class="text-center blue-color" ><a href="{{ route('deliveryMethod.edit', $method->id) }}" ><i class="far fa-edit"></i></a></td>
                                @endif
                                {{-- @if(Auth::user()->delete_data) 
                                    <td class="text-center blue-color" >
                                        
                                        <a onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="{{ $method
                                            ->id }}" ><i class="far fa-trash-alt"></i></a>
                                        
                                    </td>
                                @endif                                 --}}
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