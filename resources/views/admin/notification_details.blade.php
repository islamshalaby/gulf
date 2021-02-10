@extends('admin.app')

@section('title' , 'Admin Panel Ad Details')

@section('content')
        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.notification_details') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table class="table table-bordered mb-4">
                    <tbody>
                            @if($data['notification']['image'])
                                <tr>
                                    <td class="label-table" > {{ __('messages.image') }} </td>
                                    <td>
                                        <img src="https://res.cloudinary.com/dy4xq0cvc/image/upload/w_100,q_100/v1601416550/{{ $data['notification']['image'] }}" />
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td class="label-table" > {{ __('messages.notification_title') }}</td>
                                <td>
                                    {{ $data['notification']['title'] }}
                                </td>
                            </tr>
                            <tr>
                                <td class="label-table" > {{ __('messages.notification_body') }} </td>
                                <td>
                                    {{ $data['notification']['body'] }}
                                </td>
                            </tr>
                            <tr>
                                <td class="label-table" > {{ __('messages.date') }} </td>
                                <td>
                                    {{ $data['notification']['created_at'] }}
                                </td>
                            </tr>

                    </tbody>
                </table>

                <a href="/admin-panel/notifications/resend/{{ $data['notification']['id'] }}" class="btn btn-primary mb-2">{{ __('messages.resend_this_notification') }}</a>
                     @if (session('status'))
                        <div class="alert alert-success mb-4" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
                            <strong>Success</strong> {{ session('status') }} </button>
                        </div> 
                    @endif    

            </div>
        </div>
    </div>  
    
@endsection