@extends('admin.app')

@section('title' , 'Admin Panel All Notifications')

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.show_rates') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>{{ __('messages.review') }}</th>
                            <th>{{ __('messages.rate') }}</th>
                            <th>{{ __('messages.user_name') }}</th>
                            <th class="text-center" >{{ __('messages.accept') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data['rates'] as $rate)
                            <tr>
                                <td><?=$i;?></td>
                                <td>{{ $rate->text }}</td>
                                <td>{{ $rate->rate }}</td>
                                <td>
                                    <a style="color : blue" target="_blank" href="/admin-panel/users/details/{{$rate['user']['id']}}">
                                        {{ $rate['user']['name'] }}
                                    </a>
                                </td>
                                @if($rate->admin_approval == 0)
                                <td class="text-center">
                                    <a href="/admin-panel/rates/active/{{$rate->id}}">
                                        <span class="badge badge-success">قبول</span>
                                    </a>
                                </td>
                                @else
                                <td class="text-center">
                                   {{ __('messages.accepted')}}
                                </td>
                                @endif
                                <?php $i++; ?>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>  

@endsection