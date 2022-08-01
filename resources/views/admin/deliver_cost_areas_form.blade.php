@extends('admin.ecommerce_app')
@php
    $areaName = App::isLocale('en') ? $data['area']->name_en : $data['area']->name_ar;
@endphp
@section('title' , __('messages.add_by_areas')  . " ( " . $areaName . " ) ")

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
                    <h4>{{ __('messages.add_by_areas') . " ( " . $areaName . " ) " }}</h4>
                    {{--  @if($data['show_add'])
                    <a class="btn btn-primary" href="{{ route('areas.add.delivercost', $data['area']['id']) }}">{{ __('messages.add') }}</a>
                    @endif  --}}
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="without-print" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{ __('messages.company') }}</th>
                            <th>{{ __('messages.delivery_cost') . " ( " . __('messages.dinar') . " )" }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data['stores'] as $store)
                            <tr>
                                <td><?=$i;?></td>
                                <td>{{ App::isLocale('en') ? $store->title_en : $store->title_ar }}  </td>
                                <td colspan="2">
                                    <form method="post">
                                        @csrf
                                        <div class="row">
                                        <input type="hidden" name="store_id" value="{{ $store->id }}" /><input type="hidden" name="area_id" value="{{ $data['area_id'] }}" />
                                        <div class="form-group col-sm-4 mb-4">
                                            <input required type="number" step="any" min="0" name="delivery_cost" class="form-control" id="delivery_cost" placeholder="{{ __('messages.delivery_cost') }}" value="{{ $store->deliveryByarea($data['area_id']) ? $store->deliveryByarea($data['area_id'])->delivery_cost : '' }}" >
                                        </div>
                                        <div class="form-group  col-sm-4 mb-4">
                                            <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
                                        </div>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    
                                </td>
                                
                                <td class="text-center blue-color" >
                                    
                                </td>
                                                     
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