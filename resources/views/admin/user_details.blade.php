@extends('admin.app')

@section('title' , __('messages.user_details'))

@section('content')

        <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.user_details') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table class="table table-bordered mb-4">
                    <tbody>
                    
                            <tr>
                                <td class="label-table" > {{ __('messages.user_name') }}</td>
                                <td>{{ $data['user']['name'] }}</td>
                            </tr>
                            <tr>
                                <td class="label-table" > {{ __('messages.user_phone') }} </td>
                                <td>{{ $data['user']['phone'] }}</td>
                            </tr>
                            <tr>
                                <td class="label-table" > {{ __('messages.user_email') }} </td>
                                <td> {{ $data['user']['email'] }} </td>
                            </tr>
                           
                            <tr>
                                <td class="label-table" > {{ __('messages.created_at') }} </td>
                                <td> {{ $data['user']['created_at'] }} </td>
                            </tr>

                            <tr>
                                <td class="label-table" > {{ __('messages.status') }} </td>
                                <td> 
                                    @if($data['user']['active'])
                                        <span class="text-success margin-15" >
                                            {{ __('messages.actived') }}
                                        </span>
                                        <a href="/admin-panel/users/block/{{$data['user']['id']}}">
                                            <span class="badge badge-danger">{{ __('messages.block') }}</span>
                                        </a>
                                    @else
                                        <span class="text-danger margin-15" >
                                            {{ __('messages.blocked') }}
                                        </span>
                                        <a href="/admin-panel/users/active/{{$data['user']['id']}}">
                                            <span class="badge badge-success">{{ __('messages.active') }}</span>
                                        </a>
                                    @endif                                
                                </td>
                            </tr>
                            
                    </tbody>
                </table>
            </div>


                @if (session('error'))
                    <div class="alert alert-danger mb-4" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
                        <strong>Error!</strong> {{ session('error') }} </button>
                    </div> 
                @endif    

                @if (session('status'))
                    <div class="alert alert-success mb-4" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
                        <strong>Success!</strong> {{ session('status') }} </button>
                    </div> 
                @endif

                <div class="">
                     <h4>{{ __('messages.send_notification_to_user') }}</h4>
                </div>
                <br>
                <form action="/admin-panel/users/send_notifications/{{ $data['user']['id'] }}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="form-group mb-4">
                        <label for="image">{{ __('messages.image') }}</label>
                        <input type="file" name="image" class="form-control" id="image" placeholder="{{ __('messages.image') }}" value="" >
                    </div>                
                    <div class="form-group mb-4">
                        <label for="title">{{ __('messages.notification_title') }}</label>
                        <input required type="text" name="title" class="form-control" id="title" placeholder="{{ __('messages.notification_title') }}" value="" >
                    </div>
                    <div class="form-group mb-4">
                        <label for="body">{{ __('messages.notification_body') }}</label>
                        <input required type="text" name="body" class="form-control" id="body" placeholder="{{ __('messages.notification_body') }}" value="" >
                    </div>
                    <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
                </form>

                

        </div>
    </div>  

@endsection



