@extends('admin.app')

@section('title' , 'Admin Panel All Notifications')

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.show_notifications') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>{{ __('messages.notification_title') }}</th>
                            <th class="text-center">{{ __('messages.details') }}</th>
                            @if(Auth::user()->delete_data) 
                                <th class="text-center" >{{ __('messages.delete') }}</th>                            
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data['notifications'] as $notification)
                            <tr>
                                <td><?=$i;?></td>
                                <td>{{ $notification->title }}</td>
                                <td class="text-center blue-color"><a href="/admin-panel/notifications/details/{{ $notification->id }}" ><i class="far fa-eye"></i></a></td>
                                @if(Auth::user()->delete_data)
                                    <td class="text-center blue-color" ><a onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="/admin-panel/notifications/delete/{{ $notification->id }}" ><i class="far fa-trash-alt"></i></a></td>                                
                                @endif
                                <?php $i++; ?>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <div class="paginating-container pagination-solid">
            <ul class="pagination">
                <li class="prev"><a href="{{$data['notifications']->previousPageUrl()}}">Prev</a></li>
                @for($i = 1 ; $i <= $data['notifications']->lastPage(); $i++ )
                    <li class="{{ $data['notifications']->currentPage() == $i ? "active" : '' }}"><a href="/admin-panel/notifications/show?page={{$i}}">{{$i}}</a></li>               
                @endfor
                <li class="next"><a href="{{$data['notifications']->nextPageUrl()}}">Next</a></li>
            </ul>
        </div>           --}}
    </div>  

@endsection