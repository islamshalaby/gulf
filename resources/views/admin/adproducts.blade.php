@extends('admin.ad_app')

@section('title' , __('messages.show_products'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
				
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.show_products') }} {{ isset($data['user']) ? '( ' . $data['user'] . ' )' : '' }} {{ isset($data['category']) ? '( ' . $data['category'] . ' )' : '' }}</h4>
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
                            {{-- <th>{{ __('messages.category_title') }}</th> --}}
                            {{-- <th>{{ __('messages.productType') }}</th> --}}
                            <th>{{ __('messages.user') }}</th>
                            <th>{{ __('messages.archived_or_not') }}</th>
                            <th class="text-center">{{ __('messages.details') }}</th>
                            @if(Auth::user()->update_data) 
                                <th class="text-center">{{ __('messages.edit') }}</th>
                            @endif   
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
                                    <a href="/admin-panel/users/details/{{ $product->user_id }}" target="_blank">
                                        {{ $product->user }}
                                    </a>
                                </td>
                                <td>{{ $product->status == 1 ? __('messages.published') : __('messages.archived') }}</td>
                                <td class="text-center blue-color"><a href="/admin-panel/ad_products/details/{{ $product->id }}" ><i class="far fa-eye"></i></a></td>
                                @if(Auth::user()->update_data) 
                                    <td class="text-center blue-color" ><a href="/admin-panel/ad_products/edit/{{ $product->id }}" ><i class="far fa-edit"></i></a></td>
                                @endif
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

