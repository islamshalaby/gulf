@extends('company.app')

@section('title' , __('messages.show_products'))
@push('styles')
<style>
    .filtered-list-search form button {
        left: 4px;
        right : auto
    }
    .add-prod-container {
        padding: 20px 0;
    }
    .widget.box .widget-header,
    .add-prod-container,
    .widget.prod-search {
        background-color: #1b55e2 !important;
    }
    .filtered-list-search {
        margin-top: 50px
    }
    .add-prod-container h4,
    .widget h2{
        color: #FFF
    }
    .filtered-list-search {
        margin-bottom: 0 !important
    }
</style>
@endpush

@section('content')
<div id="badgeCustom" class="col-lg-12 mx-auto layout-spacing">
    <div id="card_2" class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div style="margin-bottom: 50px" class="widget-header">
                <div class="col-lg-8 col-md-8 col-sm-9 filtered-list-search mx-auto">
                    <form class="form-inline my-2 my-lg-0 justify-content-center">
                        <div class="w-100">
                            <input type="text" class="w-100 form-control product-search br-30" id="input-search" name="name" placeholder="{{ __('messages.search_for_product_name') }}">
                            <button class="btn btn-primary" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    <div class="mx-auto center-block add-prod-container text-center">
                        <h4 style="color: #FFF">{{ __('messages.you_can_add_new') }}</h4>
                        @if (isset($data['cat']))
                        <a href="{{ route('products.company.add') . '?cat=' . $data['cat'] }}" class="btn btn-warning">{{ __('messages.add_new_product') }}</a>
                        @else
                        <a href="{{ route('products.company.add') }}" class="btn btn-warning">{{ __('messages.add_new_product') }}</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                @if (count($data['products']) > 0)
                @foreach ($data['products'] as $product)
                <div class="widget-content widget-content-area col-md-3">
                    <div class="card component-card_2">
                        <img src="https://res.cloudinary.com/dk1fceelj/image/upload/w_250,h_250,q_100/v1581928924/{{ isset($product->images[0]) ? $product->images[0]->image : '' }}" class="card-img-top" alt="widget-card-2">
                        <div class="card-body">
                            <h5 class="card-title">{{ App::isLocale('en') ? $product->title_en : $product->title_ar}}</h5>
                            <p class="card-text">{{ $product->remaining_quantity == 0 ? __('messages.out_of_stock_now') : __('messages.remaining_quantity') . " : " . $product->remaining_quantity }}</p>
                            @if(count($product->multiOptions) > 0)
                                @foreach($product->multiOptions as $option)
                                <a style="margin-bottom: 10px" href="#" data-toggle="modal" data-target="#zoomupModal{{ $option->id }}" class="btn btn-{{ $option->remaining_quantity == 0 ? 'danger' : 'primary'}}">{{ __('messages.add_quantity_to') }}{{ App::isLocale('en') ? $option->multiOptionValue->value_en : $option->multiOptionValue->value_ar }}</a>
                                <div id="zoomupModal{{ $option->id }}" class="modal animated zoomInUp custo-zoomInUp" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ App::isLocale('en') ? $product->title_en . " ( " . $option->multiOptionValue->value_en . " )" : $product->title_ar . " ( " . $option->multiOptionValue->value_ar . " )"}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('option.update.quantity', $option->id) }}" method="post" enctype="multipart/form-data" >
                                                    @csrf    
                                                    <div class="form-group mb-4">
                                                        <label for="remaining_quantity">{{ __('messages.quantity') }}</label>
                                                        <input required type="text" name="remaining_quantity" class="form-control" id="remaining_quantity" placeholder="{{ __('messages.quantity') }}" value="" >
                                                    </div>
                                        
                                                    <input type="submit" value="{{ __('messages.add') }}" class="btn btn-primary">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                            <a href="#" data-toggle="modal" data-target="#zoomupModal{{ $product->id }}" class="btn btn-{{ $product->remaining_quantity == 0 ? 'danger' : 'primary'}}">{{ __('messages.add_quantity') }}</a>
                            <div id="zoomupModal{{ $product->id }}" class="modal animated zoomInUp custo-zoomInUp" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ App::isLocale('en') ? $product->title_en : $product->title_ar}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('update.quantity', $product->id) }}" method="post" enctype="multipart/form-data" >
                                                @csrf    
                                                <div class="form-group mb-4">
                                                    <label for="remaining_quantity">{{ __('messages.quantity') }}</label>
                                                    <input required type="text" name="remaining_quantity" class="form-control" id="remaining_quantity" placeholder="{{ __('messages.quantity') }}" value="" >
                                                </div>
                                    
                                                <input type="submit" value="{{ __('messages.add') }}" class="btn btn-primary">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                @endforeach
                @else
                <div class="col-md-12">
                    <div class="mx-auto center-block text-center">
                        <h5 class="text-center center-block">{{ __('messages.no_result') }} 
                            @if (isset($data['cat']))
                            <a href="{{ route('products.add') . '?cat=' . $data['cat'] }}">{{ __('messages.click_here') }}</a>
                            @else
                            <a href="{{ route('products.add') }}">{{ __('messages.click_here') }}</a>
                            @endif
                             {{ __('messages.to_add_new_product') }}</h5>
                    </div>
                </div>
                @endif

                <div style="margin-top: 50px" class="col-md-12">
                    <div class="mx-auto center-block add-prod-container text-center">
                        <h4>{{ __('messages.you_can_add_new') }}</h4>
                        @if (isset($data['cat']))
                        <a href="{{ route('products.company.add') . '?cat=' . $data['cat'] }}" class="btn btn-warning">{{ __('messages.add_new_product') }}</a>
                        @else
                        <a href="{{ route('products.company.add') }}" class="btn btn-warning">{{ __('messages.add_new_product') }}</a>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>  

@endsection