@extends('admin.app')

@section('title' , __('messages.offer_details'))

@section('content')
        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.offer_details') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table class="table table-bordered mb-4">
                    <tbody>
                        <tr>
                            <td class="label-table" > {{ __('messages.image') }}</td>
                            <td>
                                <img src="https://res.cloudinary.com/dy4xq0cvc/image/upload/w_100,q_100/v1601416550/{{ $data['offer']['image'] }}"  />
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.offer_size') }}</td>
                            <td>
                                @if ($data['offer']['size'] == 1)
                                    {{ __('messages.larg_size') }}
                                @elseif($data['offer']['size'] == 2)
                                    {{ __('messages.midium_size') }}
                                @else
                                    {{ __('messages.small_size') }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.offer_type') }} </td>
                            <td>
                                @if ($data['offer']['type'] == 1)
                                    {{ __('messages.product') }}
                                @endif
                                @if ($data['offer']['type'] == 2)
                                    {{ __('messages.category') }}
                                @endif
                                @if ($data['offer']['type'] == 3)
                                {{ __('messages.link') }}
                            @endif
                            </td>
                        </tr>  
                        @if ($data['offer']['type'] == 1)
                        <tr>
                            <td class="label-table" > {{ __('messages.product') }} </td>
                            <td>
                                {{ App::isLocale('en') ? $data['offer']['product']['title_en'] : $data['offer']['product']['title_ar'] }}
                            </td>
                        </tr>   
                        @endif
                        @if ($data['offer']['type'] == 2)
                        <tr>
                            <td class="label-table" > {{ __('messages.category') }} </td>
                            <td>
                                <a href="{{ route('categories.details', $data['offer']['category']['id']) }}">
                                {{ App::isLocale('en') ? $data['offer']['category']['title_en'] : $data['offer']['category']['title_ar'] }}
                                </a>
                            </td>
                        </tr> 
                        @endif 
                        @if ($data['offer']['type'] == 3)
                        <tr>
                            <td class="label-table" > {{ __('messages.link') }} </td>
                            <td>
                                <a target="_blank" href="{{$data['offer']['target_id']}}">
                                    {{$data['offer']['target_id']}}
                                </a>
                            </td>
                        </tr> 
                        @endif            
                    </tbody>
                </table>
            </div>
        </div>
    </div>  
    
@endsection