@extends('admin.ad_app')

@section('title' , __('messages.show_plans'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
			
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.show_plans') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="without-print" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{ __('messages.plan_price') }}</th>
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
                        @foreach ($data['plans'] as $plan)
                            <tr >
                                <td><?=$i;?></td>
                                <td>{{ $plan->price }} {{ __('messages.dinar') }}</td>
                                @if(Auth::user()->update_data) 
                                    <td class="text-center blue-color" ><a href="/admin-panel/plans/edit/{{ $plan->id }}" ><i class="far fa-edit"></i></a></td>
                                @endif
                                @if(Auth::user()->delete_data) 
                                    <td class="text-center blue-color" ><a onclick="return confirm('{{ __('messages.are_you_sure') }}');" href="/admin-panel/plans/delete/{{ $plan->id }}" ><i class="far fa-trash-alt"></i></a></td>                                
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
                <li class="prev"><a href="{{$data['products']->previousPageUrl()}}">Prev</a></li>
                @for($i = 1 ; $i <= $data['products']->lastPage(); $i++ )
                    <li class="{{ $data['products']->currentPage() == $i ? "active" : '' }}"><a href="/admin-panel/users/show?page={{$i}}">{{$i}}</a></li>               
                @endfor
                <li class="next"><a href="{{$data['products']->nextPageUrl()}}">Next</a></li>
            </ul>
        </div>   --}}
    </div>  
@endsection  

