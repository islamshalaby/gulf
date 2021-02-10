@extends('admin.app')

@section('title' , __('messages.offers_show'))

@push('scripts')
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js" type="text/javascript"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("tbody#sortable").sortable({
        items : "tr",
        placeholder : "ui-state-hightlight",
        update : function () {
            var ids = $('tbody#sortable').sortable("serialize");
            var url = "{{ route('offers.sort') }}";
            
            $.post(url , ids + "&_token={{ csrf_token() }}");
    
            //  console.log(ids);
    
    
        }
    });
</script>
@endpush

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.offers_show') . " ( " . __('messages.drag&drop') . " )" }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="without-print" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{ __('messages.image') }}</th>
                            <th class="text-center">{{ __('messages.details') }}</th>
                            @if(Auth::user()->update_data) 
                                <th class="text-center">{{ __('messages.edit') }}</th>                          
                            @endif
                            @if(Auth::user()->delete_data) 
                                <th class="text-center">{{ __('messages.delete') }}</th>                          
                            @endif
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        <?php $i = 1; ?>
                        @foreach ($data['offers'] as $offer)
                            <tr  id="id_{{ $offer['id'] }}">
                                <td><?=$i;?></td>
                                <td><img src="https://res.cloudinary.com/dy4xq0cvc/image/upload/w_100,q_100/v1601416550/{{ $offer->image }}"  /></td>
                                <td class="text-center blue-color">
                                    <a href="{{ route('offers.details', $offer->id) }}">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </td>
                                @if(Auth::user()->update_data) 
                                    <td class="text-center blue-color" ><a href="{{ route('offers.edit', $offer->id) }}" ><i class="far fa-edit"></i></a></td>
                                @endif
                                @if(Auth::user()->delete_data) 
                                    <td class="text-center blue-color" ><a onclick='return confirm("{{ __('messages.are_you_sure') }}");' href="{{ route('offers.delete', $offer->id) }}" ><i class="far fa-trash-alt"></i></a></td>
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
                <li class="prev"><a href="{{$data['categories']->previousPageUrl()}}">Prev</a></li>
                @for($i = 1 ; $i <= $data['categories']->lastPage(); $i++ )
                    <li class="{{ $data['categories']->currentPage() == $i ? "active" : '' }}"><a href="/admin-panel/categories/show?page={{$i}}">{{$i}}</a></li>               
                @endfor
                <li class="next"><a href="{{$data['categories']->nextPageUrl()}}">Next</a></li>
            </ul>
        </div>   --}}
        
    </div>  

@endsection