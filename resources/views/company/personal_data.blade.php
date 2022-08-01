@extends('company.app')

@section('title' , __('messages.personal_data'))

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.personal_data') }}</h4>
             </div>
    </div>
    
    @if (session('status'))
        <div class="alert alert-danger mb-4" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
            <strong>Error!</strong> {{ session('status') }} </button>
        </div> 
    @endif

    <form method="post" action="" enctype="multipart/form-data" >
     @csrf
     <div class="form-group mb-4">
        <label for="">{{ __('messages.current_image') }}</label><br>
        <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1601416550/{{ $data['company']['image'] }}"  />
    </div>
    <div class="custom-file-container" data-upload-id="myFirstImage">
        <label>{{ __('messages.change_image') }} ({{ __('messages.single_image') }}) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
        <label class="custom-file-container__custom-file" >
            <input type="file" name="image" class="custom-file-container__custom-file__custom-file-input" accept="image/*">
            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
            <span class="custom-file-container__custom-file__custom-file-control"></span>
        </label>
        <div class="custom-file-container__image-preview"></div>
    </div>
    <div class="form-group mb-4">
        <label for="title_en">{{ __('messages.title_en') }}</label>
        <input required type="text" name="title_en" class="form-control" id="title_en" placeholder="{{ __('messages.title_en') }}" value="{{ $data['company']['title_en'] }}" >
    </div>
    <div class="form-group mb-4">
        <label for="title_ar">{{ __('messages.title_ar') }}</label>
        <input required type="text" name="title_ar" class="form-control" id="title_ar" placeholder="{{ __('messages.title_ar') }}" value="{{ $data['company']['title_ar'] }}" >
    </div>
    <div class="form-group mb-4">
        <label for="email">{{ __('messages.email') }}</label>
        <input required disabled type="text" name="email" class="form-control" id="email" placeholder="{{ __('messages.email') }}" value="{{ $data['company']['email'] }}" >
    </div>
    <div class="form-group mb-4">
        <label for="password">{{ __('messages.password') }}</label>
        <input required disabled type="password" class="form-control" id="password" name="password" placeholder="{{ __('messages.password') }}" value="" >
    </div>
    <br>
    <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
</form>
</div>

@endsection