<div class="row">
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">Products in Store
                <a href="{{ route('inventory.store.products', $store->id) }}" class="btn btn-xs btn-info pull-right">go</a>
            </div>
            {{--<div class="panel-body">Panel Content</div>--}}
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">Orders Made
                <a href="{{ route('inventory.store.orders-made', $store->id) }}" class="btn btn-xs btn-info pull-right">go
                </a>
            </div>
            {{--<div class="panel-body">Panel Content</div>--}}
        </div>
    </div>


    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">Orders Received
                <a href="{{ route('inventory.store.orders-received', $store->id) }}" class="btn btn-xs btn-info pull-right">go</a>
            </div>
            {{--<div class="panel-body">Panel Content</div>--}}
        </div>
    </div>
</div>