@extends('admin.app')

@section('title' , __('messages.address_details'))

@section('content')
        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.address_details') }} ( <a target="_blank" href="{{ route('users.details', $data['address']->user->id) }}" >{{ $data['address']->user->name }}</a> )</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table class="table table-bordered mb-4">
                    
                    <tbody>
                        <tr>
                            <td class="label-table" > {{ __('messages.address_type') }}</td>
                            <td>
                                {{ $data['address']->address_type == 1 ? __('messages.home_address') : __('messages.work_address') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.address_title') }}</td>
                            <td>
                                {{ $data['address']->title }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.area') }}</td>
                            <td>
                                <a href="{{ route('areas.details', $data['address']->area->id) }}" target="_blank">
                                {{ $data['address']->area->title_en }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.street') }}</td>
                            <td>
                                {{ $data['address']->street }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.avenue') }}</td>
                            <td>
                                {{ $data['address']->gaddah }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.building') }}</td>
                            <td>
                                {{ $data['address']->building }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.floor') }}</td>
                            <td>
                                {{ $data['address']->floor }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table" > {{ __('messages.apartment_number') }}</td>
                            <td>
                                {{ $data['address']->apartment_number }}
                            </td>
                        </tr>
                                                   
                    </tbody>
                   
                    
                </table>
            </div>
        </div>
    </div>  
    
@endsection