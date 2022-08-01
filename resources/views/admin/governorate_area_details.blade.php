@extends('admin.app')

@section('title' , __('messages.area_details'))

@section('content')
        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.area_details') }}</h4>
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
                                    {{ $data['area']['name_en'] }}
                                </td>
                            </tr>
                            <tr>
                                <td class="label-table" > {{ __('messages.title_ar') }}</td>
                                <td>
                                    {{ $data['area']['name_ar'] }}
                                </td>
                            </tr>
                            <tr>
                                <td class="label-table" > {{ __('messages.country') }} </td>
                                <td>
                                    <a href="{{ route('countries.details', $data['area']->governorate->country->id) }}" target="_blank">
                                        {{ App::isLocale('en') ? $data['area']->governorate->country->name_en : $data['area']->governorate->country->name_ar }}
                                    </a>
                                </td>
                            </tr>  
                            <tr>
                                <td class="label-table" > {{ __('messages.governorate') }} </td>
                                <td>
                                    <a href="{{ route('governorates.details', $data['area']->governorate_id) }}" target="_blank">
                                        {{ App::isLocale('en') ? $data['area']->governorate->name_en : $data['area']->governorate->name_ar }}
                                    </a>
                                </td>
                            </tr>                          
                    </tbody>
                </table>
            </div>
        </div>
    </div>  
    
@endsection