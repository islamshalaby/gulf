@extends('admin.app')

@section('title' , 'Med&Law Dashboard Users Section')

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.show_managers') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>id</th>    
                            <th>{{ __('messages.manager_name') }}</th>
                            <th>{{ __('messages.manager_email') }}</th>
                            @if(Auth::user()->update_data)
                                <th class="text-center">{{ __('messages.edit') }}</th>
                            @endif
                            @if(Auth::user()->delete_data)
                                <th class="text-center" >{{ __('messages.delete') }}</th>                            
                            @endif
                      
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($data['managers'] as $manager)
                        <tr>
                            <td><?=$i;?></td>
                            <td>{{ $manager->name }}</td>
                            <td>{{ $manager->email }}</td>
                            @if(Auth::user()->update_data)
                                <td class="text-center blue-color" ><a href="/admin-panel/managers/edit/{{ $manager->id }}" ><i class="far fa-edit"></i></a></td>
                            @endif
                            @if(Auth::user()->delete_data && $manager->id != 1)
                                <td class="text-center blue-color" ><a onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="/admin-panel/managers/delete/{{ $manager->id }}" ><i class="far fa-trash-alt"></i></a></td>
                            @else
                                <td></td>
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

