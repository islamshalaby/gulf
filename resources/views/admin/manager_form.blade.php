@extends('admin.app')

@section('title' , 'Admin Panel Add New User')

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.add_new_manager') }}</h4>
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
        <label for="name">{{ __('messages.manager_name') }}</label>
        <input required type="text" name="name" class="form-control" id="name" placeholder="{{ __('messages.manager_name') }}" value="" >
    </div>

    <div class="form-group mb-4">
        <label for="email">{{ __('messages.manager_email') }}</label>
        <input required type="Email" class="form-control" id="email" name="email" placeholder="{{ __('messages.manager_email') }}" value="" >
    </div>
    <div class="form-group mb-4">
        <label for="password">{{ __('messages.password') }}</label>
        <input required type="password" class="form-control" id="password" name="password" placeholder="{{ __('messages.password') }}" value="" >
    </div>

     <div class="row" >
        <div class="col-12" >
            <label> {{ __('messages.permissions') }} </label>
        </div>
        <div class="col-md-3" >
             <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-text checkbox-primary">
                  <input  type="checkbox" class="new-control-input all-permisssions">
                  <span class="new-control-indicator"></span><span class="new-chk-content">{{ __('messages.all') }}</span>
                </label>
            </div>     
        </div>

        @foreach ($data['permissions'] as $permission)
        <div class="col-md-3" >
             <div class="n-chk">
                <label class="new-control new-checkbox new-checkbox-text checkbox-primary">
                  <input name="permission[]" value="{{ $permission->id }}" type="checkbox" class="new-control-input single-permission">
                  @if( Config::get('app.locale') == 'en' )    
                    <span class="new-control-indicator"></span><span class="new-chk-content">{{ $permission->permission_en }}</span>
                  @elseif( Config::get('app.locale') == 'ar' )
                    <span class="new-control-indicator"></span><span class="new-chk-content">{{ $permission->permission_ar }}</span>  
                  @endif  
                </label>
            </div>     
        </div>            
        @endforeach
        
     </div>
     <br>   
     <div class="row" >
        <div class="col-12" >
            <label> {{ __('messages.another_permissions') }} </label>
        </div>
        
        <div class="col-md-3" >
             <div >
                <label class="new-control new-checkbox new-checkbox-text checkbox-primary">
                  <input name="add_data" value="1" type="checkbox" class="new-control-input">
                  <span class="new-control-indicator"></span><span class="new-chk-content">{{ __('messages.add') }}</span>
                </label>
            </div>     
        </div>            
        <div class="col-md-3" >
             <div >
                <label class="new-control new-checkbox new-checkbox-text checkbox-primary">
                  <input name="update_data" value="1" type="checkbox" class="new-control-input">
                  <span class="new-control-indicator"></span><span class="new-chk-content">{{ __('messages.update') }}</span>
                </label>
            </div>     
        </div> 
        <div class="col-md-3" >
             <div >
                <label class="new-control new-checkbox new-checkbox-text checkbox-primary">
                  <input name="delete_data" value="1" type="checkbox" class="new-control-input">
                  <span class="new-control-indicator"></span><span class="new-chk-content">{{ __('messages.delete') }}</span>
                </label>
            </div>     
        </div> 
        
     </div>

    <br>
    <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
</form>
</div>

@endsection