@extends('layouts.app')

@section('content_title', $store->name)
@section('content_description','Manage internal stores')

@section('content')

<div class="panel panel-info">
    <div class="panel-heading">
        <h5>View the order trail</h5>
    </div>

    <div class="panel-body">
        <div class="accordion">
            @foreach($details as $detail)
                <h4>
                    <span>{{ $detail['product'] }}</span>
                    <span class="pull-right">{{ $detail['quantity'] }} items ordered</span>
                </h4>
                <div>
                    @forelse($detail['trail'] as $trail)
                        <div class="row">
                            <span class="col-md-3">{{ $trail['date'] }} - </span>
                            <span class="col-md-9 text-left">{{ $trail['quantity'] }} items {{ $trail['message'] }}</span>
                        </div>
                    @empty
                        <p>No action has been taken since item were ordered</p>
                    @endforelse
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.accordion').accordion({heightStyle: "content"});

        // $('body').on('click', '.edit-note', function(event){
        //
        //     $('#note-id').val(event.target.value);
        //
        // });
    })
</script>

@endsection

