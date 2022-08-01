@extends('admin.ad_app')
@section('title' , __('messages.cat_options'))
@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.cat_options') }}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <button type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#exampleModal">
                            {{ __('messages.add') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th>Id</th>
                            {{--  <th class="text-center">{{ __('messages.image') }}</th>  --}}
                            <th>{{ __('messages.name') }}</th>
                            <th class="text-center">{{ __('messages.list_values') }}</th>
                            @if(Auth::user()->delete_data)<th class="text-center">{{ __('messages.delete') }}</th>@endif
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data as $row)
                            <tr>
                                <td><?=$i;?></td>
                                {{--  <td class="text-center"><img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1581928924/{{ $row->image }}"  /></td>  --}}
                                <td>{{ app()->getLocale() == 'en' ? $row->title_en : $row->title_ar }}</td>
                                <td class="text-center blue-color"><a
                                        href="{{ route('options_values.show', $row->id) }}"><i
                                            class="far fa-eye"></i></a></td>
                                @if(Auth::user()->delete_data)
                                    <td class="text-center blue-color" ><a onclick="return confirm('{{ __('messages.are_you_sure_delete') }}');" href="{{route('cat_options.deleted',$row->id)}}" ><i class="far fa-trash-alt"></i></a></td>
                                @endif
                                <?php $i++; ?>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.add_cat_options') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </div>
                    <form action="{{route('cat_options.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input required type="hidden" name="category_id" value="{{$id}}">
                        <input required type="hidden" name="category_type" value="{{ $type }}">
                        <div class="modal-body">
                            <div class="form-group mb-4">
                                <label for="title_ar">{{ __('messages.name_ar') }}</label>
                                <input required type="text" name="title_ar" class="form-control" id="title_ar" placeholder="{{ __('messages.name_ar') }}" value="" >
                            </div>
                            <div class="form-group mb-4">
                                <label for="title_ar">{{ __('messages.name_en') }}</label>
                                <input required type="text" name="title_en" class="form-control" id="title_en" placeholder="{{ __('messages.name_en') }}" value="" >
                            </div>
                            <div class="form-group">
                                <label for="sel1">{{ __('messages.type') }}</label>
                                <select name="is_required" required class="form-control">
                                    <option value="y" selected>{{ __('messages.mandatory') }}</option>
                                    <option value="n">{{ __('messages.choice') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> {{ __('messages.cancel') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('messages.add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
