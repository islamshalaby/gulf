@extends('admin.ad_app')

@section('title' , __('messages.show_offers_sections'))
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
            var url = "{{ route('offers_control.sort') }}";
            
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
                    <h4>{{ __('messages.comments') }}</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="timeline-simple">

                <div class="timeline-list">
                    @if(count($data['product']->comments) > 0)
                    @foreach ($data['product']->comments as $comment)
                    <div class="timeline-post-content">
                        <div class="user-profile">
                            <img src="https://res.cloudinary.com/dyyeedzqi/image/upload/w_100,q_100/v1581928924/all_liwbsi.png" alt="">
                        </div>
                        <div class="">
                            <h4>{{ $comment->user->name }}</h4>
                            <p class="meta-time-date">{{ date('Y-m-d', strtotime($comment->created_at)) }}</p>
                            <div class="">
                                <p class="post-text">{{ $comment->content }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
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



