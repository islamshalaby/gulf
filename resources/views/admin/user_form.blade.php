@extends('admin.app')

@section('title' , __('messages.add_new_user'))

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.add_new_user') }}</h4>
             </div>
    </div>
    
    @if (session('status'))
        <div class="alert alert-danger mb-4" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
            <strong>Error!</strong> {{ session('status') }} </button>
        </div> 
    @endif

    <form method="post" action="" >
     @csrf
    <div class="form-group mb-4">
        <label for="name">{{ __('messages.user_name') }}</label>
        <input required type="text" name="name" class="form-control" id="name" placeholder="{{ __('messages.user_name') }}" value="" >
    </div>
    <div class="form-group mb-4">
        <label for="phone">{{ __('messages.user_phone') }}</label>
        <input required type="phone" name="phone" class="form-control" id="phone" placeholder="{{ __('messages.user_phone') }}" value="" >
    </div>
    <div class="form-group mb-4">
        <label for="email">{{ __('messages.user_email') }}</label>
        <input required type="Email" class="form-control" id="email" name="email" placeholder="{{ __('messages.user_email') }}" value="" >
    </div>
    <div class="form-group mb-4">
        <label for="password">{{ __('messages.password') }}</label>
        <input required type="password" class="form-control" id="password" name="password" placeholder="{{ __('messages.password') }}" value="" >
    </div>         
    <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
</form>
</div>

@endsection