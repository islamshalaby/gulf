@extends('admin.ecommerce_app')

@section('title' , __('messages.home_section_details'))

@section('content')
        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.home_section_details') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table class="table table-bordered mb-4">
                    <tbody>
                        <tr>
                            <td class="label-table" > {{ __('messages.title_en') }}</td>
                            <td>
                                {{ $data['home_section']['title_en'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.title_ar') }}</td>
                            <td>
                                {{ $data['home_section']['title_ar'] }}
                            </td>
                        </tr>   
                        <tr>
                            <td class="label-table" > {{ __('messages.section_type') }}</td>
                            <td>
                                @if ($data['home_section']['type'] == 1)
                                    {{ __('messages.ads_big') }}
                                @elseif ($data['home_section']['type'] == 2)
                                    {{ __('messages.categories') }}
                                @elseif ($data['home_section']['type'] == 3)
                                    {{ __('messages.brands') }}
                                @elseif ($data['home_section']['type'] == 4)
                                    {{ __('messages.offers') }}
                                @elseif ($data['home_section']['type'] == 5)
                                    {{ __('messages.ads_small') }}
                                @endif
                            </td>
                        </tr>                        
                    </tbody>
                </table>
                
                
                
                
                    @if ($data['home_section']['type'] == 1 || $data['home_section']['type'] == 5)
                        <table class="table table-bordered mb-4">
                            <tbody>
                                @foreach ($data['home_section']['ads'] as $ad)
                                <tr>
                                    <td>{{ __('messages.ad') }}</td>
                                    <td>
                                        <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1601416550/{{ $ad->image }}"  />
                                    </td>
                                </tr>
                                @endforeach          
                            </tbody>
                        </table>
                        
                    @elseif ($data['home_section']['type'] == 2)
                        
                        <table class="table table-bordered mb-4">
                            <tbody>
                                @foreach ($data['home_section']['categories'] as $category)
                                <tr>
                                    <td>{{ __('messages.category') }}</td>
                                    <td>
                                        <a href="{{ route('car_types.details', $category->id) }}">
                                        {{ App::isLocale('en') ? $category->title_en : $category->title_ar }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach          
                            </tbody>
                        </table>

                    @elseif ($data['home_section']['type'] == 3)
                        
                        <table class="table table-bordered mb-4">
                            <tbody>
                                @foreach ($data['home_section']['brands'] as $brand)
                                <tr>
                                    <td>{{ __('messages.brand') }}</td>
                                    <td>
                                        <a href="{{ route('brands.details', $brand->id) }}">
                                        {{ App::isLocale('en') ? $brand->title_en : $brand->title_ar }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach          
                            </tbody>
                        </table>

                    @elseif ($data['home_section']['type'] == 4)
                        
                        <table class="table table-bordered mb-4">
                            <tbody>
                                @foreach ($data['home_section']['offers'] as $offer)
                                <tr>
                                    <td>{{ __('messages.offer') }}</td>
                                    <td>
                                        <a href="{{ route('products.details', $offer->id) }}">
                                            {{ App::isLocale('en') ? $offer->title_en : $offer->title_ar }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach          
                            </tbody>
                        </table>
                        
                        
                    @endif
               
                
            </div>
        </div>
    </div>  
    
@endsection