@extends('admin.app')

@section('title' , __('messages.show_delivery_costs'))

@section('content')
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
                    <h4>{{ __('messages.show_delivery_costs') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="without-print" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{ __('messages.area') }}</th>
                            <th>{{ __('messages.delivery_cost') }}</th>
                            {{-- <th class="text-center">{{ __('messages.details') }}</th> --}}
                            @if(Auth::user()->update_data) 
                                <th class="text-center">{{ __('messages.edit') }}</th>                          
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data['costs'] as $cost)
                            <tr>
                                <td><?=$i;?></td>
                                <td>{{ App::isLocale('en') ? $cost->area->name_en : $cost->area->name_ar }}</td>
                                <td>
                                    @if(Auth::user()->update_data) 
                                    <a  href="#" data-toggle="modal" data-target="#exampleModal{{ $cost->governorate_area_id }}"><i style="color:green" class="far fa-plus-square"></i></a>
                                    @endif
                                    {{ $cost->delivery_cost . " " . __('messages.dinar') }}
                                    <div class="modal fade" id="exampleModal{{ $cost->governorate_area_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModal{{ $cost->governorate_area_id }}Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">{{ App::isLocale('en') ? $cost->area->name_en : $cost->area->name_ar }}</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('governorates.areas.update.deliveryCost') }}" method="post" enctype="multipart/form-data" >    
                                                        @csrf
                                                        <input name="_method" type="hidden" value="PUT">
                                                        <input name="governorate_area_id" type="hidden" value="{{ $cost->governorate_area_id }}">
                                                        <div class="form-group mb-4 outside">
                                                            <label for="delivery_cost">{{ __('messages.delivery_cost') }}</label>
                                                            <input required type="number" step="any" min="0" name="delivery_cost" class="form-control" id="delivery_cost" placeholder="{{ __('messages.delivery_cost') }}" value="{{ $cost->delivery_cost }}" >
                                                        </div>
                                                        
                                            
                                                        <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                {{-- <td class="text-center blue-color"><a href="#" ><i class="far fa-eye"></i></a></td> --}}
                                @if(Auth::user()->update_data) 
                                    <td class="text-center blue-color" ><a href="{{ route('deliveryMethod.edit', $cost->id) }}" ><i class="far fa-edit"></i></a></td>
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