@extends('admin.ad_app')

@section('title' , __('messages.show_products'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        @if(Session::has('success'))
            <div class="alert alert-icon-left alert-light-success mb-4" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12" y2="17"></line></svg>
                <strong>{{ Session('success') }}</strong>
            </div>
        @endif
        @if(Session::has('fail'))
            <div class="alert alert-arrow-right alert-icon-right alert-light-danger mb-4" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                    <strong>{{ Session('fail') }}</strong>
            </div>
        @endif
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.show_products') }} {{ isset($data['user']) ? '( ' . $data['user'] . ' )' : '' }} {{ isset($data['category']) ? '( ' . $data['category'] . ' )' : '' }}</h4>
                    <a onclick="return confirm('{{ __('messages.are_you_sure') }}');" href="{{ route('republish.ads') }}" class="btn btn-danger"><i class="far fa-window-restore"></i> {{ __('messages.unarchive_all') }}</a>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="without-print" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{ __('messages.publication_date') }}</th>
                            <th>{{ __('messages.product_name') }}</th>
                            <th>{{ __('messages.best_offers') }}</th>
                            <th>{{ __('messages.feature_ads') }}</th>
                            {{-- <th>{{ __('messages.productType') }}</th> --}}
                            <th>{{ __('messages.user') }}</th>
                            <th>{{ __('messages.archived_or_not') }}</th>
                            <th>{{ __('messages.comments') }}</th>
                            <th class="text-center">{{ __('messages.details') }}</th>
                            {{-- @if(Auth::user()->update_data) 
                                <th class="text-center">{{ __('messages.edit') }}</th>
                            @endif    --}}
                            @if(Auth::user()->delete_data) 
                                <th class="text-center" >{{ __('messages.delete') }}</th>
                            @endif 
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data['products'] as $product)
                            <tr >
                                <td><?=$i;?></td>
                                <td>{{ date('Y-m-d', strtotime($product->publication_date)) }}</td>
                                <td>{{ $product->title }}</td>
                                <td>
                                    @if ($product->bestOffer)
                                    <a class="btn btn-danger rounded-circle" onclick="return confirm('{{ __('messages.are_you_sure') }}');" href="{{ route('adProduct.removefrombestoffers', $product->id) }}" >
                                        <i class="far fa-heart"></i>
                                    </a>
                                    @elseif( !$product->bestOffer && $product->status == 1)
                                    <a class="btn btn-primary rounded-circle" onclick="return confirm('{{ __('messages.are_you_sure') }}');"  href="{{ route('adProduct.addtobestoffers', $product->id) }}" >
                                        <i class="far fa-heart"></i>
                                    </a>
                                    @else
                                    {{ __('messages.archived') }}
                                    @endif
                                </td>
                                <td>
                                    @if ($product->selected == 1)
                                    <a class="btn btn-warning rounded-circle" onclick="return confirm('{{ __('messages.are_you_sure') }}');" href="{{ route('feature.ads', $product->id) . '?status=' . 0 }}" >
                                        <i class="far fa-star"></i>
                                    </a>
                                    @elseif($product->selected == 0 && $product->status == 1)
                                    <a class="btn btn-primary rounded-circle" onclick="return confirm('{{ __('messages.are_you_sure') }}');"  href="{{ route('feature.ads', $product->id) . '?status=' . 1 }}" >
                                        <i class="far fa-star"></i>
                                    </a>
                                    @else
                                    {{ __('messages.archived') }}
                                    @endif
                                </td>
                                <td>{{ isset($product->user->name) ? $product->user->name : '' }}</td>
                                <td>
                                    {{ $product->status == 1 ? __('messages.published') : __('messages.archived') }} 
                                    @if($product->status == 2)
                                    <a onclick="return confirm('{{ __('messages.are_you_sure') }}');" href="{{ route('republish.ads', ['ad_id' => $product->id]) }}" class="btn btn-danger"><i class="far fa-window-restore"></i> {{ __('messages.unarchive') }}</a>
                                    @endif
                                </td>
                                <td><a target="_blank" href="{{ route('adProduct.comments', $product->id) }}"><i class="far fa-eye"></i></a></td>
                                <td class="text-center blue-color"><a href="/admin-panel/ad_products/details/{{ $product->id }}" ><i class="far fa-eye"></i></a></td>
                                {{-- @if(Auth::user()->update_data) 
                                    <td class="text-center blue-color" ><a href="/admin-panel/ad_products/edit/{{ $product->id }}" ><i class="far fa-edit"></i></a></td>
                                @endif --}}
                                @if(Auth::user()->delete_data) 
                                    <td class="text-center blue-color" ><a onclick="return confirm('{{ __('messages.are_you_sure') }}');" href="/admin-panel/ad_products/delete/{{ $product->id }}" ><i class="far fa-trash-alt"></i></a></td>                                
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

