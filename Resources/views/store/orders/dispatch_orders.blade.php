@extends('layouts.app')

@section('content_title', "Manage Store")
@section('content_description', "manage store stock movement")

@section('content')

    @include('inventory::store.orders.includes.dashboard')

    <div class="panel panel-info">
        <div class="panel-heading">Dispatch orders</div>
        <div class="panel-body">

            <section style="margin: 10px 0 50px 0">
                <label class="col-md-4">Item</label>
                <label class="col-md-3">Ordered</label>
                <label class="col-md-3">Dispatched</label>
                <label class="col-md-2">Dispatch</label>
            </section>

            {!! Form::open(['class'=>'form-horizontal','route'=>['inventory.dispatch.store', $order->id]]) !!}
                @foreach($order->details as $detail)

                    <input type="hidden" name={{ "dispatch[".$loop->index."][dispatched_by]" }} value="{{ Auth::id() }}"/>

                    <p class="col-md-4">{{ $detail->product->name }}</p>
                    <p class="col-md-3">{{ $detail->quantity }}</p>
                    <p class="col-md-3">{{ $detail->dispatched }}</p>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="hidden" name={{ "dispatch[".$loop->index."][order_detail_id]" }} value="{{ $detail->id }}"/>

                            <input type="number" value="{{ $detail->pending }}" max="{{ $detail->pending }}" min="0"
                                   class="form-control" name={{ "dispatch[".$loop->index."][dispatched]" }}>
                        </div>
                    </div>
                @endforeach

                <div class="col-md-12 pull-right">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-save"></i> Dispatch Items
                    </button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection