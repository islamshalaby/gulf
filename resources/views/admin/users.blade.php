@extends('admin.app')

@section('title' , __('messages.show_users'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.show_users') }}
                        <button data-show="0" class="btn btn-primary show_actions">{{ __('messages.hide_actions') }}</button>
                    </h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{ __('messages.user_name') }}</th>
                            <th>{{ __('messages.user_phone') }}</th>
                            <th class="text-center hide_col">{{ __('messages.addresses') }}</th>
                            <th class="text-center hide_col" >{{ __('messages.block_active') }}</th>
                            <th class="text-center hide_col">{{ __('messages.details') }}</th>
                            @if(Auth::user()->update_data) 
                                <th class="text-center hide_col">{{ __('messages.edit') }}</th>
                            @endif    
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data['users'] as $user)
                            <tr class="{{$user->seen == 0 ? 'unread' : '' }}" >
                                <td><?=$i;?></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone }}</td>
                                <td class="text-center blue-color text-center hide_col"><a href="{{ route('user.addresses', $user->id) }}" ><i class="far fa-eye"></i></a></td>
                                <td class="text-center text-center hide_col">
                                    @if($user->active)
                                    <a href="/admin-panel/users/block/{{$user->id}}">
                                        <span class="badge badge-danger">{{ __('messages.block') }}</span>
                                    </a>
                                    @else
                                    <a href="/admin-panel/users/active/{{$user->id}}">
                                        <span class="badge badge-success">{{ __('messages.active') }}</span>
                                    </a>
                                    @endif
                                </td>
                                <td class="text-center blue-color text-center hide_col"><a href="/admin-panel/users/details/{{ $user->id }}" ><i class="far fa-eye"></i></a></td>
                                @if(Auth::user()->update_data) 
                                    <td class="text-center blue-color text-center hide_col" ><a href="/admin-panel/users/edit/{{ $user->id }}" ><i class="far fa-edit"></i></a></td>
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
                <li class="prev"><a href="{{$data['users']->previousPageUrl()}}">Prev</a></li>
                @for($i = 1 ; $i <= $data['users']->lastPage(); $i++ )
                    <li class="{{ $data['users']->currentPage() == $i ? "active" : '' }}"><a href="/admin-panel/users/show?page={{$i}}">{{$i}}</a></li>               
                @endfor
                <li class="next"><a href="{{$data['users']->nextPageUrl()}}">Next</a></li>
            </ul>
        </div>   --}}
    </div>  
@endsection  

