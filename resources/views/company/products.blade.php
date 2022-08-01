@extends('company.app')

@section('title' , __('messages.show_products'))

@push('styles')
    <style>
        .table > tbody > tr > td,
        .table > thead > tr > th {
            font-size : 10px
        }
        .dropdown-menu {
            height: 100px;
            overflow: auto
        }
    </style>
@endpush

@push('scripts')
<script src="/admin/plugins/table/datatable/custom_miscellaneous.js"></script>
    <script>
        var language = "{{ Config::get('app.locale') }}",
            select = "{{ __('messages.select') }}",
            details = "{{ __('messages.details') }}",
            edit = "{{ __('messages.edit') }}",
            delte = "{{ __('messages.delete') }}"
        $("#category").on("change", function () {
            console.log("test2")
            var categoryId = $(this).val()
            

            dTbls.clear().draw();
            
            $.ajax({
                url : "fetchcategoryproducts/" + categoryId,
                type : 'GET',
                success : function (data) {
                    var i = 1
                    
                    data.forEach(function(element) {
                        console.log(element)
                        var elementName = element.title_en,
                            cat = element.category.title_en
                        if (language == 'ar') {
                            elementName = element.title_ar
                            cat = element.category.title_ar
                           
                        }
                        
                        var permition = [],
                            detailsLink = "/company-panel/products/details/" + element.id,
                            editLink = "/company-panel/products/edit/" + element.id,
                            deleteLink = "/company-panel/products/delete/" + element.id,
                            dinar = "{{ __('messages.dinar') }}",
                            visibilityStatus = "{{ __('messages.visible') }}",
                            hideShoProduct = "{{ __('messages.hide_product') }}",
                            hideShowLink = "/company-panel/products/hide/" + element.id + "/" + 1

                            if (element.hidden == 1) {
                                hideShoProduct = "{{ __('messages.show_product') }}"
                                hideShowLink = "/company-panel/products/hide/" + element.id + "/" + 0
                                visibilityStatus = "{{ __('messages.hidden') }}"
                            }
                        @if(Auth::user()->update_data) 
                        permition[0] = `<a class="dropdown-item" href="${editLink}">${edit}</a>`
                        @endif
                        @if(Auth::user()->delete_data) 
                        permition[1] = `<a class="dropdown-item"  onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="${deleteLink}">${delte}</a>`
                        permition[2] = `<a class="dropdown-item" onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="${hideShowLink}">${hideShoProduct}</a>`
                        @endif
                        $("#html5-extension tbody").parent('.form-group').show()
                        var priceBeforeOffer = element.price_before_offer,
                            finalPrice = element.final_price,
                            startFrom = "{{ __('messages.start_from') }}"
                        
                        var rowNode = dTbls.row.add( [
                            `${i}`,
                            `<img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_50,q_50/v1581928924/${ (element.images[0].image) ? element.images[0].image : '' }"  />`,
                            `${elementName}`,
                            `${cat}`,
                            `${element.total_quatity}`,
                            `${element.remaining_quantity}`,
                            `${element.sold_count}`,
                            `${priceBeforeOffer} ${dinar}`,
                            `${finalPrice} ${dinar}`,
                            `${element.updated_at}`,
                            `${element.barcode}`,
                            `<td class="hide_col">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-dark btn-sm">${visibilityStatus}</button>
                                    <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference5" style="will-change: transform;">
                                      <a class="dropdown-item" href="${detailsLink}">${details}</a>
                                      ${(permition[0]) ? permition[0] : ''}
                                      ${(permition[1]) ? permition[1] : ''} 
                                      <div class="dropdown-divider"></div>
                                      ${(permition[2]) ? permition[2] : ''}
                                    </div>
                                  </div>
                            </td>`
                        ] ).draw().node();

                        $( rowNode ).find('td').eq(1).addClass('hide_col');
                       
                        $( rowNode ).find('td').eq(10).addClass('hide_col');
                        i ++
                    })
                    
                }
            })

        })
        
    </script>
@endpush

@section('content')
<div id="badgeCustom" class="col-lg-12 mx-auto layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-content widget-content-area">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="category">{{ __('messages.category') }}</label>
                    <select required id="category" name="category" class="form-control">
                        <option disabled selected>{{ __('messages.select') }}</option>
                        @foreach ( $data['categories'] as $category )
                        <option value="{{ $category->id }}">{{ App::isLocale('en') ? $category->title_en : $category->title_ar }}</option>
                        @endforeach 
                    </select>
                </div>
            </div>
            @if($data['expire'] == 'no')
            <a class="btn btn-primary" href="/company-panel/products/show?expire=soon">{{ __('messages.expired_soon') }}</a>
            @endif

            @if($data['expire'] == 'soon')
            <a class="btn btn-primary" href="/company-panel/products/show">{{ __('messages.return_all_products') }}</a>
            @endif            
        </div>
        
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
                    <h4>{{ __('messages.show_products') }}
                        <button data-show="0" class="btn btn-primary show_actions">{{ __('messages.hide_actions') }}</button>
                    </h4>
                    
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="html5-extension" class="table table-hover non-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th class="hide_col">{{ __('messages.image') }}</th>
                            <th>{{ __('messages.product_title') }}</th>
                            <th>{{ __('messages.category') }}</th>
                            <th>{{ __('messages.total_quatity') }}</th>
                            <th>{{ __('messages.remaining_quantity') }}</th>
                            <th>{{ __('messages.sold_quantity') }}</th>
                            <th>{{ __('messages.price_before_discount') }}</th>
                            <th>{{ __('messages.price_after_discount') }}</th>
                            <th>{{ __('messages.last-update_date') }}</th>
                            <th>{{ __('messages.barcode') }}</th>
                            <th class="text-center hide_col">{{ __('messages.actions') }}</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data['products'] as $product)
                            <tr>
                                <td><?=$i;?></td>
                                <td class="hide_col"><img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_50,q_50/v1581928924/{{ isset($product->images[0]->image) ? $product->images[0]->image : '' }}"  /></td>
                                <td>{{ App::isLocale('en') ? $product->title_en : $product->title_ar }}</td>
                                <td>{{ App::isLocale('en') ?  $product->category->title_en : $product->category->title_ar }}</td>
                                <td>{{ $product->multi_options == 0 ? $product->total_quatity : $product->multiOptions->sum("total_quatity") }}</td>
                                <td>{{ $product->multi_options == 0 ? $product->remaining_quantity : $product->multiOptions->sum("remaining_quantity") }}</td>
                                <td>{{ $product->sold_count }}</td>
                                <td>
                                    @if($product->multi_options == 0)
                                    {{ $product->offer == 1 ? $product->price_before_offer . " " . __('messages.dinar') : $product->final_price . " " . __('messages.dinar') }}
                                    @else
                                    {{ $product->offer == 1 ? __('messages.start_from') . $product->multiOptions[0]->price_before_offer . " " . __('messages.dinar') : __('messages.start_from') . $product->multiOptions[0]->final_price . " " . __('messages.dinar') }}
                                    @endif
                                </td>
                                <td>
                                    @if($product->multi_options == 0)
                                    {{ $product->final_price . " " . __('messages.dinar') }}
                                    @else
                                    {{ __('messages.start_from') . $product->multiOptions[0]->final_price . " " . __('messages.dinar') }}
                                    @endif
                                </td>
                                <td>{{ $product->updated_at->format("d-m-y") }}</td>
                                <td>
                                    @if($product->multi_options == 0)
                                        {{ $product->barcode }}
                                    @else
                                        @if(count($product->multiOptions) > 0)
                                        <div class="dropdown custom-dropdown-icon">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-4" style="will-change: transform;">
                                                @foreach ($product->multiOptions as $m_option)
                                                    @if (!empty($m_option->barcode ))
                                                    <a class="dropdown-item" href="javascript:void(0);">{{ $m_option->barcode }}</a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    @endif
                                </td>
                                <td class="hide_col">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-dark btn-sm">
                                            {{ $product->hidden == 0 ? __('messages.visible') : __('messages.hidden') }}
                                        </button>
                                        <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference5" style="will-change: transform;">
                                          <a class="dropdown-item" href="{{ route('products.company.details', $product->id) }}">{{ __('messages.details') }}</a>
                                           
                                            <a class="dropdown-item" href="{{ route('products.company.edit', $product->id) }}">{{ __('messages.edit') }}</a>
                                            
                                            
                                            <a class="dropdown-item"  onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="{{ route('products.delete', $product->id) }}">{{ __('messages.delete') }}</a>
                                             
                                          <div class="dropdown-divider"></div>
                                          @if($product->hidden == 0)
                                          <a class="dropdown-item" onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="{{ route('products.company.visibility.status', [$product->id, 1]) }}">{{ __('messages.hide_product') }}</a>
                                          @else
                                          <a class="dropdown-item" onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="{{ route('products.company.visibility.status', [$product->id, 0]) }}">{{ __('messages.show_product') }}</a>
                                          @endif
                                          
                                        </div>
                                      </div>
                                </td>
                                                                
                                <?php $i++; ?>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <td></td>    
                    <tfoot>
                </table>
            </div>
        </div>
        {{-- <div class="paginating-container pagination-solid">
            <ul class="pagination">
                <li class="prev"><a href="{{$data['categories']->previousPageUrl()}}">Prev</a></li>
                @for($i = 1 ; $i <= $data['categories']->lastPage(); $i++ )
                    <li class="{{ $data['categories']->currentPage() == $i ? "active" : '' }}"><a href="/company-panel/categories/show?page={{$i}}">{{$i}}</a></li>               
                @endfor
                <li class="next"><a href="{{$data['categories']->nextPageUrl()}}">Next</a></li>
            </ul>
        </div>   --}}
        
    </div>  

@endsection