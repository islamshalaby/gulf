@extends('admin.app')

@section('title' , __('messages.delivery_information'))

@section('content')

<div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.delivery_information') }}</h4>
             </div>
        </div>

        @if (session('status'))
            <div class="alert alert-danger mb-4" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
                <strong>Error!</strong> {{ session('status') }} </button>
            </div> 
        @endif

        <form action="" method="post" >
            @csrf
            <div class="form-group mb-4 english-direction">
                <label for="delivery_information_en">{{ __('messages.english') }}</label>
                <textarea id="editor-ck-en" required name="delivery_information_en" class="form-control" id="delivery_information_en" rows="5">{{ $data['setting']['delivery_information_en'] }}</textarea>
            </div>
            <div class="form-group mb-4 arabic-direction">
                <label for="delivery_information_ar">{{ __('messages.arabic') }}</label>
                <textarea id="editor-ck-ar" required name="delivery_information_ar" class="form-control" id="delivery_information_ar" rows="5">{{ $data['setting']['delivery_information_ar'] }}</textarea>
            </div>                
            <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
        </form>

</div>

@endsection