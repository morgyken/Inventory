{{--<div class="row">--}}
    {{--<div class="col-md-4">--}}
        {{--<div class="panel panel-info">--}}
            {{--<div class="panel-heading">Orders Made--}}
                {{--<a href="{{route('inventory.store.orders', $store->id)}}" class="btn btn-xs btn-info pull-right">view--}}
                {{--</a>--}}
            {{--</div>--}}
            {{--<div class="panel-body">--}}
                {{--{{ $ordersMade->count() }}--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="col-md-4">--}}
        {{--<div class="panel panel-info">--}}
            {{--<div class="panel-heading">Orders Received--}}
                {{--<a href="{{route('inventory.store.received', $store->id)}}" class="btn btn-xs btn-info pull-right">view--}}
                {{--</a>--}}
            {{--</div>--}}

            {{--<div class="panel-body">--}}
                {{--{{ $ordersReceived->count() }}--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="col-md-3">--}}
        {{--<div class="panel panel-info">--}}
            {{--<div class="panel-heading">Orders Dispatched <a class="btn btn-xs btn-info pull-right">view</a></div>--}}
            {{--<div class="panel-body">Panel Content</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="col-md-4">--}}
        {{--<div class="panel panel-info">--}}
            {{--<div class="panel-heading">Receive Orders--}}
                {{--<a href="{{route('inventory.store.receive', $store->id)}}" class="btn btn-xs btn-info pull-right">view--}}
                {{--</a>--}}
            {{--</div>--}}
            {{--<div class="panel-body">Panel Content</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}


<div class="row">
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">Orders Made
                <a href="{{ route('inventory.store.orders-made', $store->id) }}" class="btn btn-xs btn-info pull-right">view
                </a>
            </div>
            {{--<div class="panel-body">Panel Content</div>--}}
        </div>
    </div>

    {{--<div class="col-md-4">--}}
        {{--<div class="panel panel-info">--}}
            {{--<div class="panel-heading">Receive Items--}}
                {{--<a href="{{ route('inventory.store.orders-received', $store->id) }}" class="btn btn-xs btn-info pull-right">view</a></div>--}}
            {{--<div class="panel-body">Panel Content</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="col-md-3">--}}
        {{--<div class="panel panel-info">--}}
            {{--<div class="panel-heading">Dispatch <a class="btn btn-xs btn-info pull-right">view</a></div>--}}
            {{--<div class="panel-body">Panel Content</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">Orders Received
                <a href="{{ route('inventory.store.orders-received', $store->id) }}" class="btn btn-xs btn-info pull-right">view</a>
            </div>
            {{--<div class="panel-body">Panel Content</div>--}}
        </div>
    </div>
</div>