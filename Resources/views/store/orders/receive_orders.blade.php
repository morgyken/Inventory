@extends('layouts.app')

@section('content_title', $store->name)
@section('content_description', "manage store stock movement")

@section('content')

    @include('inventory::store.orders.includes.dashboard')

    <div class="panel panel-info">
        <div class="panel-heading">Receive orders made <b class="pull-right">Dispatched By: {{ $order->dispatchingStore->name }}</b></div>
        <div class="panel-body">

            <section style="margin: 10px 0 50px 0">
                <label class="col-md-2">Item</label>
                <label class="col-md-1">Ordered</label>
                <label class="col-md-1">Dispatched</label>
                <label class="col-md-1">Received</label>
                <label class="col-md-2">Receiving</label>
                <label class="col-md-2">Reject</label>
                <label class="col-md-3">Reason</label>
            </section>

            {!! Form::open(['class'=>'form-horizontal','route'=>['inventory.dispatch.accept-order', $order->requesting_store, $order->id]]) !!}

                @foreach($order->details as $detail)
                    <p class="col-md-2">{{ $detail->product->name }}</p>
                    <p class="col-md-1 text-center">{{ $detail->quantity }}</p>
                    <p class="col-md-1 text-center">{{ $detail->dispatched }}</p>
                    <p class="col-md-1 text-center">{{ $detail->accepted }}</p>

                    <input type="hidden" name="receive[{{$loop->index}}][order_detail_id]" value="{{ $detail->id }}" />

                    <input type="hidden" name="receive[{{$loop->index}}][received_by]" value="{{ Auth::id() }}" />

                    <div id="receive-{{ $loop->index }}" class="col-md-2">
                        <div class="form-group" style="margin-right:1px;margin-left:1px">
                            <input type="number" class="form-control" min="0" max="{{ $detail->available }}" value="{{ $detail->available }}" readonly
                                    name="receive[{{$loop->index}}][received]" />
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group" style="margin-right:1px;margin-left:1px">
                            <input id="reject-{{ $loop->index }}" type="number" class="form-control reject"
                                   min="0" value="0" max="{{ $detail->available }}" name="receive[{{$loop->index}}][rejected]" />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group" style="margin-right:1px;margin-left:1px">
                            <input type="text" class="form-control" name="receive[{{$loop->index}}][reason]">
                        </div>
                    </div>
                @endforeach

                <div class="col-md-12 pull-right">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-save"></i> Receive Items
                    </button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $(".reject").bind("keyup mouseup", function(event) {

                var reject = event.target.value ? parseInt(event.target.value) : 0;

                var receivingObj = $("#receive-" + event.target.id.split("-")[1] + " input");

                var available = parseInt(receivingObj.attr('max'));

                receivingObj.val(available - reject);
            });
        });
    </script>
@endsection